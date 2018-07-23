import Vue from 'vue'

const AuthService = {
  login(credentials) {
    return Vue.http.post('auth/login', credentials)
  },
  logout() {
    return Vue.http.post('auth/logout')
  },
  authentication() {
    return Vue.http.get('auth/authentication')
  }
}

export default AuthService
