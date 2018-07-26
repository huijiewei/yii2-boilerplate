import Vue from 'vue'

const UserService = {
  all(page = 1) {
    return Vue.http.get('user', { page: page })
  }
}

export default UserService
