import Vue from 'vue'

const UserService = {
  all(query) {
    return Vue.http.get('user/index', query)
  },

  delete(id) {
    return Vue.http.delete('user/delete' + id)
  },

  create(user) {
    return Vue.http.post('user/post', user)
  },

  edit(id, user = null) {
    const endpoint = 'users/' + id

    if (user === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.put(endpoint, user)
  },
}

export default UserService
