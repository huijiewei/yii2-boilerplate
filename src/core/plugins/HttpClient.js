import Request from '../utils/request'

const HttpCodes = {
  OK: 200,
  BAD_REQUEST: 400,
  UNAUTHORIZED: 401,
  FORBIDDEN: 403,
  NOT_FOUND: 404
}

const HttpGetMethod = ['GET', 'HEAD']

const HttpClient = {
  install (Vue, { apiHost, apiToken, tokenPrefix, store, router, Message, MessageBox, loginUrl, loginDispatch }) {
    const request = new Request({
      baseUrl: apiHost,
      getApiToken: () => {
        return apiToken
      },
      getUserToken: () => {
        return window.localStorage.getItem(tokenPrefix + '-user-token')
      },
      setUserToken: (accessToken) => {
        return window.localStorage.setItem(tokenPrefix + '-user-token', accessToken)
      },
      successHandler: (response) => {
        if (response.headers.includes('X-USER-TOKEN')) {
          this.setUserToken(response.headers['X-USER-TOKEN'])
        }

        if (response.config.responseType === 'blob') {
          return Promise.resolve(response)
        }

        return Promise.resolve(response.data)
      },
      errorHandler: (error) => {
        if (error.response) {
          if (error.response.status === HttpCodes.UNAUTHORIZED) {
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

          if (error.response.status === HttpCodes.NOT_FOUND || error.response.status === HttpCodes.FORBIDDEN || error.response.status === HttpCodes.BAD_REQUEST) {
            let message = '网络错误'

            if (error.response.data) {
              message = error.response.data.message
            } else if (error.response.message) {
              message = error.response.message
            } else if (error.response.statusText) {
              message = error.response.statusText
            }

            const msgBox = MessageBox.alert(
              message,
              {
                center: true,
                confirmButtonText: '确定',
                type: 'warning',
                showClose: false
              }
            )

            if (HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
              msgBox.then(() => {
                router.back()
              })
            }

            return Promise.reject(error)
          }

          if (error.response.data) {
            const data = error.response.data

            if (data.message) {
              Message.warning(data.message)
            } else if (Array.isArray(data)) {
              data.forEach(function (item) {
                Message.warning(item.message)
              })
            } else if (data instanceof Blob) {
              const blb = new Blob([data])
              const reader = new FileReader()

              reader.onloadend = (e) => {
                const result = JSON.parse(e.target.result)

                Message.error(result.message)
              }

              reader.readAsText(blb)
            }
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
