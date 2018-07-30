import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'

class Request {
  constructor(options) {
    const opt = {
      ...{
        baseUrl: '',
        timeout: 10000,
        withCredentials: false,
        getClientId: () => {
          return null
        },
        getAccessToken: () => {
          return null
        },
        successHandler: (response) => Promise.resolve(response),
        errorHandler: (error) => Promise.reject(error)
      },
      ...options
    }

    const httpClient = axios.create({
      baseURL: opt.baseUrl,
      timeout: opt.timeout,
      withCredentials: opt.withCredentials
    })

    axiosRetry(httpClient, {
      retries: 3,
      retryDelay: () => {
        return 1000
      }
    })

    loadProgressBar({ showSpinner: false }, httpClient)

    httpClient.interceptors.request.use((config) => {
      const clientId = opt.getClientId()

      if (clientId) {
        config.headers['X-Client-Id'] = clientId
      }

      const accessToken = opt.getAccessToken()

      if (accessToken) {
        config.headers['X-Access-Token'] = accessToken
      }

      return config
    }, undefined)

    httpClient.interceptors.response.use((response) => {
      return opt.successHandler(response)
    }, (error) => opt.errorHandler(error))

    this.httpClient = httpClient
  }

  request(method, url, params = null, data = null) {
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

  get(url, params = []) {
    return this.request('GET', url, params)
  }

  head(url, params = []) {
    return this.request('HEAD', url, params)
  }

  post(url, data = null, params = null) {
    return this.request('POST', url, params, data)
  }

  put(url, data = null, params = null) {
    return this.request('PUT', url, params, data)
  }

  path(url, data = null, params = null) {
    return this.request('PATH', url, params, data)
  }

  delete(url, params = null) {
    return this.request('DELETE', url, params)
  }

  download(method, url, params = null, data = null) {
    console.log(params)
    const config = {
      url: url,
      method: method,
      responseType: 'blob'
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
