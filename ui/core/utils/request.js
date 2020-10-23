import axios from 'axios'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'
import contentDisposition from 'content-disposition'
import { throttleAdapterEnhancer } from 'axios-extensions'
import flatry from '@core/utils/flatry'

class Request {
  constructor(options) {
    const opt = {
      ...{
        baseUrl: '',
        timeout: 10 * 1000,
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

    httpClient.interceptors.request.use(
      (config) => {
        return opt.beforeRequest(config)
      },
      (error) => {
        return opt.onError(error)
      }
    )

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

  request(
    method,
    url,
    params = null,
    data = null,
    historyBack = false,
    cancelIgnore = false
  ) {
    const config = {
      url: url,
      method: method,
      historyBack: historyBack,
      cancelIgnore: cancelIgnore,
    }

    if (params) {
      config.params = params
    }

    if (data) {
      config.data = data
    }

    return flatry(this.httpClient.request(config))
  }

  get(url, params = null, historyBack = true, cancelIgnore = false) {
    return this.request('GET', url, params, null, historyBack, cancelIgnore)
  }

  post(url, data = null, params = null, historyBack = false) {
    return this.request('POST', url, params, data, historyBack)
  }

  put(url, data = null, params = null, historyBack = false) {
    return this.request('PUT', url, params, data, historyBack)
  }

  path(url, data = null, params = null, historyBack = false) {
    return this.request('PATH', url, params, data, historyBack)
  }

  delete(url, params = null, historyBack = false) {
    return this.request('DELETE', url, params, null, historyBack)
  }

  download(method, url, params = null, data = null, historyBack = false) {
    const config = {
      url: url,
      method: method,
      timeout: 120 * 1000,
      responseType: 'blob',
      historyBack: historyBack,
      onDownloadProgress: (progressEvent) => {
        console.log(progressEvent)
      },
    }

    if (params) {
      config.params = params
    }

    if (data) {
      config.data = data
    }

    return flatry(
      this.httpClient.request(config).then((response) => {
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
    )
  }
}

export default Request
