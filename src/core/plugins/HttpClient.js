import Request from '../utils/request'

const HttpGetMethod = ['GET', 'HEAD']
const RouteBackHttpCodes = [404, 400, 403]
const UnauthorizedHttpCode = 401
const UnprocessableEntityHttpCode = 422

const HttpClient = {
  install (Vue, { apiHost, store, getAccessTokenGetter, setLoginActionDispatch, setErrorDispatch }) {
    const request = new Request({
      baseUrl: apiHost,
      beforeRequest: (config) => {
        const accessToken = store.getters[getAccessTokenGetter]

        if (accessToken) {
          config.headers['X-Client-Id'] = accessToken.clientId
          config.headers['X-Access-Token'] = accessToken.accessToken
        }

        return config
      },
      successHandler: (response) => {
        if (response.config.responseType === 'blob') {
          return Promise.resolve(response)
        }

        return Promise.resolve(response.data)
      },
      errorHandler: (error) => {
        if (!error.response) {
          store.dispatch(setErrorDispatch, { message: error.message, routeBack: true })

          return Promise.reject(error)
        }

        if (error.response.status === UnauthorizedHttpCode) {
          if (!error.config.__retry) {
            error.config.__retry = true

            if (HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
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

        let message = '网络错误'
        let routeBack = false

        const contentType = error.response.headers['content-type']

        if (contentType.startsWith('application/problem+json')) {
          message = error.response.data.detail || error.response.data.title
        } else if (contentType.startsWith('application/json')) {
          if (error.response.data.message) {
            message = error.response.data.message
          } else {
            message = error.response.statusText
          }
        } else {
          if (error.response.statusText) {
            message = error.response.statusText
          } else {
            if (error.response.status >= 500) {
              message = '系统出现错误'
            } else {
              message = '网络错误'
            }
          }
        }

        const notBack = error.config.headers['X-NOT-BACK'] || false

        if (!notBack &&
          RouteBackHttpCodes.includes(error.response.status) &&
          HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
          routeBack = true
        }

        store.dispatch(setErrorDispatch, {
          message: message,
          routeBack: routeBack
        })

        return Promise.reject(error)
      }
    })

    Vue.http = request
    Vue.prototype.$http = request
  }
}

export default HttpClient
