import Auth from '../utils/auth'
import Request from '../utils/request'

const HttpCodes = {
  OK: 200,
  UNAUTHORIZED: 401,
  FORBIDDEN: 403,
  NOT_FOUND: 404
}

const HttpGetMethod = ['GET', 'HEAD']

const HttpClient = {
  install(Vue, { store, router, Message, MessageBox }) {
    const request = new Request({
      baseUrl: document.querySelector('meta[name="api-host"]').getAttribute('content'),
      getClientId: () => {
        return Auth.getClientId()
      },
      getAccessToken: () => {
        return Auth.getAccessToken()
      },
      successHandler: (response) => Promise.resolve(response.data),
      errorHandler: (error) => {
        if (error.response) {
          if (error.response.status === HttpCodes.UNAUTHORIZED) {
            if (!error.config.__retry) {
              error.config.__retry = true

              if (HttpGetMethod.includes(error.response.config.method.toUpperCase())) {
                if (router.currentRoute.name === 'login') {
                  router.replace(router.currentRoute.fullPath)
                } else {
                  router.replace({ name: 'login', query: { direct: router.currentRoute.fullPath } })
                }
              } else {
                store.dispatch('auth/showLoginModal')
              }
            }

            return Promise.reject(error)
          }

          if (error.response.status === HttpCodes.NOT_FOUND || error.response.status === HttpCodes.FORBIDDEN) {
            const msgBox = MessageBox.alert(
              error.response.data ? error.response.data.message : error.response.message,
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
            let data = error.response.data
            if (data.message) {
              Message.warning(data.message)
            } else if (Array.isArray(data)) {
              data.forEach(function(item) {
                Message.warning(item.message)
              })
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
