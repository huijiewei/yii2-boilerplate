import Request from '../utils/request'

const HttpGetMethod = ['GET', 'HEAD']
const RouteBackHttpCodes = [404, 400, 403]
const UnauthorizedHttpCode = 401
const UnprocessableEntityHttpCode = 422

const HttpClient = {
  install (Vue, { apiHost, store, router, loginUrl, loginDispatch, accessTokenGetter, errorMessageDispatch }) {
    const request = new Request({
      baseUrl: apiHost,
      getAccessToken: () => {
        return store.getters[accessTokenGetter]
      },
      successHandler: (response) => {
        if (response.config.responseType === 'blob') {
          return Promise.resolve(response)
        }

        return Promise.resolve(response.data)
      },
      errorHandler: (error) => {
        if (!error.response) {
          store.dispatch(errorMessageDispatch, error.message)

          return Promise.reject(error)
        }

        if (error.response.status === UnauthorizedHttpCode) {
          if (!error.config.__retry) {
            error.config.__retry = true

            if (HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
              if (router.currentRoute.path === loginUrl) {
                router.replace(router.currentRoute.fullPath)
              } else {
                router.replace({ path: loginUrl, query: { direct: router.currentRoute.fullPath } })
              }
            } else {
              store.dispatch(loginDispatch)
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
          message = error.response.data.detail
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

        const xMethod = error.config.headers['X-METHOD'] || ''

        if (xMethod !== 'download' &&
          RouteBackHttpCodes.includes(error.response.status) &&
          HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
          routeBack = true
        }

        store.dispatch(errorMessageDispatch, {
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
