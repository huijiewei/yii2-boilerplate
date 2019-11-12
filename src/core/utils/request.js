import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'

class Request {
  constructor (options) {
    const opt = {
      ...{
        baseUrl: '',
        timeout: 20000,
        withCredentials: false,
        beforeRequest: (config) => { return config },
        successHandler: (response) => Promise.resolve(response),
        errorHandler: (error) => Promise.reject(error)
      },
      ...options
    }

    const httpClient = axios.create({
      baseURL: opt.baseUrl,
      timeout: opt.timeout,
      withCredentials: opt.withCredentials,
      responseType: 'json',
      paramsSerializer: (params) => {
        const keys = Object.keys(params)
        let options = ''

        keys.forEach((key) => {
          const isParamTypeObject = typeof params[key] === 'object'
          const isParamTypeArray = isParamTypeObject && (params[key].length >= 0)

          if (!isParamTypeObject) {
            options += `${key}=${params[key]}&`
          }

          if (isParamTypeObject && isParamTypeArray) {
            params[key].forEach((element) => {
              options += `${key}=${element}&`
            })
          }
        })

        return options ? options.slice(0, -1) : options
      }
    })

    let retries = 0

    axiosRetry(httpClient, {
      retries: 3,
      retryDelay: () => {
        return 1000
      },
      retryCondition: (error) => {
        let config = error.config

        if (!config) {
          return false
        }

        if (error.response && error.response.status < 500) {
          return false
        }

        retries = retries + 1
        if (retries >= 3) {
          retries = 0
          return false
        }

        return true
      }
    })

    loadProgressBar({ showSpinner: false }, httpClient)

    httpClient.interceptors.request.use((config) => {
      return opt.beforeRequest(config)
    }, undefined)

    httpClient.interceptors.response.use((response) => {
      return opt.successHandler(response)
    }, (error) => opt.errorHandler(error))

    this.httpClient = httpClient
  }

  request (method, url, params = null, data = null) {
    const config = {
      url: url,
      method: method
    }

    if (params) {
      config.params = params
    }

    if (data) {
      config.data = data
    }

    return this.httpClient.request(config)
  }

  get (url, params = []) {
    return this.request('GET', url, params)
  }

  head (url, params = []) {
    return this.request('HEAD', url, params)
  }

  post (url, data = null, params = null) {
    return this.request('POST', url, params, data)
  }

  put (url, data = null, params = null) {
    return this.request('PUT', url, params, data)
  }

  path (url, data = null, params = null) {
    return this.request('PATH', url, params, data)
  }

  delete (url, params = null) {
    return this.request('DELETE', url, params)
  }

  download (method, url, params = null, data = null) {
    const config = {
      url: url,
      method: method,
      timeout: 60000,
      responseType: 'blob',
      headers: { 'X-NOT-BACK': true }
    }

    if (params) {
      config.params = params
    }

    if (data) {
      config.data = data
    }

    return this.httpClient.request(config).then(response => {
      let filename = response.headers['x-suggested-filename']

      if (!filename) {
        const filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/
        const matches = filenameRegex.exec(response.headers['content-disposition'])
        if (matches != null && matches[1]) {
          filename = matches[1].replace(/['"]/g, '')
        }
      }

      if (filename) {
        const url = window.URL.createObjectURL(new Blob([response.data]))
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', decodeURIComponent(filename))
        link.click()
        window.URL.revokeObjectURL(url)

        return true
      } else {
        return false
      }
    })
  }
}

export default Request
