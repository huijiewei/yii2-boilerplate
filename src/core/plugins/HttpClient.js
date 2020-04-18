import Request from '../utils/request'

const UnauthorizedHttpCode = 401
const UnprocessableEntityHttpCode = 422

const HttpGetMethod = ['GET', 'HEAD']

const HttpClient = {
  install(
    Vue,
    {
      apiHost,
      store,
      getAccessTokenGetter,
      setLoginActionDispatch,
      setErrorDispatch,
      javaParamsSerializer = false,
    }
  ) {
    const errorMessage = (message, historyBack) => {
      store.dispatch(setErrorDispatch, {
        message: message,
        historyBack: historyBack,
      })
    }

    const request = new Request({
      baseUrl: apiHost,
      javaParamsSerializer: javaParamsSerializer,
      beforeRequest: (config) => {
        const accessToken = store.getters[getAccessTokenGetter]

        if (accessToken) {
          config.headers['X-Client-Id'] = accessToken.clientId
          config.headers['X-Access-Token'] = accessToken.accessToken
        }

        return config
      },
      onSuccess: (response) => {
        if (response.config.responseType === 'blob') {
          return Promise.resolve(response)
        }

        return Promise.resolve(response.data)
      },
      onError: (error) => {
        const historyBack = error.config.historyBack

        if (!error.response) {
          errorMessage(error.message, historyBack)

          return Promise.reject(error)
        }

        if (error.response.status === UnauthorizedHttpCode) {
          if (!error.config.__retry) {
            error.config.__retry = true

            if (
              historyBack ||
              HttpGetMethod.includes(error.config.method.toUpperCase())
            ) {
              store.dispatch(setLoginActionDispatch, 'direct')
            } else {
              store.dispatch(setLoginActionDispatch, 'modal')
            }
          }

          return Promise.reject(error)
        }

        if (error.response.status === UnprocessableEntityHttpCode) {
          return Promise.reject(error)
        }

        if (!error.response.data) {
          errorMessage(
            error.response.statusText ||
              (error.response.status >= 500 ? '系统错误' : '请求错误'),
            historyBack
          )

          return Promise.reject(error)
        }

        if (error.response.data instanceof Blob) {
          const reader = new FileReader()

          reader.onloadend = (e) => {
            const data = JSON.parse(e.target.result.toString())

            errorMessage(data.detail || data.message || data.title, historyBack)
          }

          reader.readAsText(new Blob([error.response.data]))

          return Promise.reject(error)
        }

        errorMessage(
          error.response.data.detail ||
            error.response.data.message ||
            error.response.data.title,
          historyBack
        )

        return Promise.reject(error)
      },
    })

    Vue.http = request
    Vue.prototype.$http = request
  },
}

export default HttpClient
