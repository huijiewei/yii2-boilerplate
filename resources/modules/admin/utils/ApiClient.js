import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'

class ApiClient {
  httpClient = null

  constructor() {
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

    this.httpClient = httpClient
  }

  get(url, params = []) {
    return this.httpClient.get(url, {
      params: params
    })
  }

  post(url, params = [], data = []) {
    return this.httpClient.post(url, {
      params: params,
      data: data
    })
  }
}

const apiClient = new ApiClient()

export default apiClient
