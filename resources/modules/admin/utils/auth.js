const clientIdItemKey = 'bp-admin-client-id'
const accessTokenItemKey = 'bp-admin-access-token'

const Auth = {
  getClientId() {
    return window.localStorage.getItem(clientIdItemKey)
  },

  setClientId(clientId) {
    window.localStorage.setItem(clientIdItemKey, clientId)
  },

  getAccessToken() {
    return window.localStorage.getItem(accessTokenItemKey)
  },

  setAccessToken(accessToken) {
    if (accessToken == null) {
      window.localStorage.removeItem(accessTokenItemKey)
    } else {
      window.localStorage.setItem(accessTokenItemKey, accessToken)
    }
  }
}

export default Auth
