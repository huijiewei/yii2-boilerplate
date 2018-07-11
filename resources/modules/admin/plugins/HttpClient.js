import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'
import { Message } from 'element-ui'

const HttpCodes = {
  OK: 200,
  UNAUTHORIZED: 401
}

const HttpGetMethod = ['GET', 'HEAD', 'OPTIONS']

const HttpClient = {
  install(Vue, { store, router }) {
    let CancelToken = axios.CancelToken
    let source = CancelToken.source()

    let httpClient = axios.create({
      baseURL: document.querySelector('meta[name="api-host"]').getAttribute('content'),
      timeout: 10000,
      xsrfCookieName: null,
      xsrfHeaderName: null,
      cancelToken: source.token
    })

    axiosRetry(httpClient, {
      retries: 3,
      retryDelay: () => {
        return 1000
      }
    })

    loadProgressBar({}, httpClient)

    httpClient.interceptors.request.use(function(config) {
      let accessToken = store.state.auth.accessToken

      if (accessToken) {
        config.headers['Access-Token'] = accessToken
      }

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
            Message.error(data.message)
          } else if (Array.isArray(data)) {
            data.forEach(function(item) {
              console.log(item)
              Message.error(item.message)
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
      }
    }
  }
}

export default HttpClient
