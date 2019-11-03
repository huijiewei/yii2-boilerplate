import Request from '../utils/request'

const HttpGetMethod = ['GET', 'HEAD']
const RouteBackHttpCodes = [404, 400, 403]
const UnAuthorizedHttpCode = 401

const HttpClient = {
  install (Vue, { apiHost, store, router, Message, MessageBox, loginUrl, loginDispatch, accessTokenGetter }) {
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
        if (error.response) {
          if (error.response.status === UnAuthorizedHttpCode) {
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

          let message = '网络错误'

          const contentType = error.response.headers['content-type']

          if (!contentType.startsWith('application/json')) {
            message = error.response.statusText
          } else {
            if (error.response.data.message) {
              message = error.response.data.message
            } else if (Array.isArray(error.response.data)) {
              const messages = []

              error.response.data.forEach(function (item) {
                messages.push(item.message)
              })

              message = messages.join('<br><br>')
            } else if (error.response.data instanceof Blob) {
              const blob = new Blob([error.response.data])
              const reader = new FileReader()

              reader.onloadend = (e) => {
                const result = JSON.parse(e.target.result)

                message = result.message
              }

              reader.readAsText(blob)
            } else {
              message = error.response.statusText
            }
          }

          const alert = MessageBox.alert(
            message,
            {
              dangerouslyUseHTMLString: true,
              center: true,
              confirmButtonText: '确定',
              type: 'warning',
              showClose: false
            }
          )

          const xMethod = error.config.headers['X-METHOD'] || ''

          if (xMethod !== 'download' &&
            RouteBackHttpCodes.includes(error.response.status) &&
            HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
            alert.then(() => {
              router.back()
            })
          }
        } else {
          Message.error(error.message)
        }

        return Promise.reject(error)
      }
    })

    Vue.http = request
    Vue.prototype.$http = request
  }
}

export default HttpClient
