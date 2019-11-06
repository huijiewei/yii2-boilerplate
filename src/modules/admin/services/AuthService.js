import Vue from 'vue'

const AuthService = {
  login (credentials) {
    return Vue.http.post('auth/login', credentials)
  },
  logout () {
    return Vue.http.post('auth/logout')
  },
  account () {
    return Vue.http.get('auth/account')
  }
}

export default AuthService
