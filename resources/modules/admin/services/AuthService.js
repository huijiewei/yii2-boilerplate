import Vue from 'vue'

const AuthService = {
  login(data) {
    return Vue.http.post('auth/login', data)
  },
  logout() {
    return Vue.http.post('auth/logout')
  },
  getCurrentUser() {
    return Vue.http.get('auth/current-user')
  }
}

export default AuthService
