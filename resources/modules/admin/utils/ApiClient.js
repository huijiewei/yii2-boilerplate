import axios from 'axios'
import axiosRetry from 'axios-retry'
import { loadProgressBar } from 'axios-progress-bar'
import 'axios-progress-bar/dist/nprogress.css'

import { message } from 'antd'

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

    httpClient.interceptors.response.use(undefined, function(error) {
      message.error(error.message)
    })

    this.httpClient = httpClient
  }

  async get(url, params = []) {
    let response = await this.httpClient.get(url, {
      params: params
    })

    return await response.data
  }

  async post(url, params = [], data = []) {
    let response = await this.httpClient.post(url, {
      params: params,
      data: data
    })

    return await response.data
  }
}

const apiClient = new ApiClient()

export default apiClient
