import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'
import { Message } from 'element-ui'

const HttpClient = {
  install(Vue) {
    let httpClient = axios.create({
      baseURL: document.querySelector('meta[name="api-host"]').getAttribute('content'),
      timeout: 1000
    })

    axiosRetry(httpClient, {
      retries: 3,
      retryDelay: () => {
        return 1000
      }
    })

    loadProgressBar({}, httpClient)

    httpClient.interceptors.response.use(undefined, function(error) {
      if (error.response) {
        console.log(error.response)

        if (error.response.data) {
          if (error.response.data.message) {
            Message.error(error.response.data.message)
          }
        }
      } else if (error.request) {
        Message.error(error.request)
      } else {
        Message.error(error.message)
      }

      return Promise.reject(error)
    })

    Vue.prototype.$http = {
      get(url, params = []) {
        return httpClient.get(url, {
          params: params
        })
      },
      post(url, params = [], data = []) {
        return httpClient.post(url, {
          params: params,
          data: data
        })
      }
    }
  }
}

export default HttpClient
