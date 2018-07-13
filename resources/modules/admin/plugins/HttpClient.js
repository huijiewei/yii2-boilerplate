import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'

const HttpCodes = {
  OK: 200,
  UNAUTHORIZED: 401,
  FORBIDDEN: 403
}

const HttpGetMethod = ['GET', 'HEAD', 'OPTIONS']

const HttpClient = {
  install(Vue, { store, router, Message }) {
    const httpClient = axios.create({
      baseURL: document.querySelector('meta[name="api-host"]').getAttribute('content'),
      timeout: 10000,
      xsrfCookieName: null,
      xsrfHeaderName: null
    })

    axiosRetry(httpClient, {
      retries: 3,
      retryDelay: () => {
        return 1000
      }
    })

    loadProgressBar({ showSpinner: false }, httpClient)

    httpClient.interceptors.request.use(function(config) {
      const accessToken = store.state.auth.accessToken

      if (accessToken) {
        config.headers['X-Access-Token'] = accessToken
      }

      config.headers['X-Client-Id'] = store.state.auth.clientId

      return config
    }, undefined)

    httpClient.interceptors.response.use(undefined, function(error) {
      if (error.response) {
        if (error.response.status === HttpCodes.UNAUTHORIZED) {
          if (HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
            router.replace({ path: '/login', query: { direct: router.currentRoute.fullPath } })
          } else {
            store.dispatch('toggleLoginModal')
          }

          return Promise.reject(error)
        }

        if (error.response.data) {
          let data = error.response.data
          if (data.message) {
            Message.warning(data.message)
          } else if (Array.isArray(data)) {
            data.forEach(function(item) {
              console.log(item)
              Message.warning(item.message)
            })
          }
        }
      } else {
        Message.error(error.message)
      }

      return Promise.reject(error)
    })

    Vue.prototype.$http = {
      get(url, params = []) {
        return httpClient.request({
          url: url,
          method: 'GET',
          params: params
        })
      },
      post(url, data = null, params = null) {
        return httpClient.request({
          url: url,
          method: 'POST',
          params: params,
          data: data
        })
      },
      put(url, data = null, params = null) {
        return httpClient.request({
          url: url,
          method: 'PUT',
          params: params,
          data: data
        })
      },
      delete(url, params = null) {
        return httpClient.request({
          url: url,
          method: 'DELETE',
          params: params
        })
      }
    }
  }
}

export default HttpClient
