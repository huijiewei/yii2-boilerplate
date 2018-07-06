import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'

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
