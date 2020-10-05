import axios from 'axios'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'
import contentDisposition from 'content-disposition'
import { cacheAdapterEnhancer, throttleAdapterEnhancer } from 'axios-extensions'

class Request {
  constructor(options) {
    const opt = {
      ...{
        baseUrl: '',
        timeout: 20000,
        withCredentials: false,
        paramsSerializer: null,
        beforeRequest: (config) => {
          return config
        },
        onSuccess: (response) => Promise.resolve(response),
        onError: (error) => Promise.reject(error),
      },
      ...options,
    }

    const axiosConfig = {
      baseURL: opt.baseUrl,
      timeout: opt.timeout,
      withCredentials: opt.withCredentials,
      paramsSerializer: opt.paramsSerializer,
      adapter: throttleAdapterEnhancer(axios.defaults.adapter),
    }

    const httpClient = axios.create(axiosConfig)

    loadProgressBar({ showSpinner: false }, httpClient)

    httpClient.interceptors.request.use((config) => {
      return opt.beforeRequest(config)
    }, undefined)

    httpClient.interceptors.response.use(
      (response) => {
        return opt.onSuccess(response)
      },
      (error) => {
        return opt.onError(error)
      }
    )

    this.httpClient = httpClient
  }

  request(method, url, params = null, data = null, back = false) {
    const config = {
      url: url,
      method: method,
    }

    if (back === true) {
      config.historyBack = true
    }

    if (params) {
      config.params = params
    }

    if (data) {
      config.data = data
    }

    return this.httpClient.request(config)
  }

  all() {}

  get(url, params = null, back = true) {
    return this.request('GET', url, params, null, back)
  }

  head(url, params = null) {
    return this.request('HEAD', url, params)
  }

  post(url, data = null, params = null, back = false) {
    return this.request('POST', url, params, data, back)
  }

  put(url, data = null, params = null, back = false) {
    return this.request('PUT', url, params, data, back)
  }

  path(url, data = null, params = null, back = false) {
    return this.request('PATH', url, params, data, back)
  }

  delete(url, params = null, back = false) {
    return this.request('DELETE', url, params, null, back)
  }

  download(method, url, params = null, data = null, back = false) {
    const config = {
      url: url,
      method: method,
      timeout: 60000,
      responseType: 'blob',
      historyBack: back,
    }

    if (params) {
      config.params = params
    }

    if (data) {
      config.data = data
    }

    return this.httpClient.request(config).then((response) => {
      let filename = response.headers['x-suggested-filename']

      if (!filename) {
        const disposition = contentDisposition.parse(
          response.headers['content-disposition']
        )

        filename = disposition.parameters.filename
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
