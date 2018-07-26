import Vue from 'vue'

const UserService = {
  all(query) {
    return Vue.http.get('user', query)
  }
}

export default UserService
