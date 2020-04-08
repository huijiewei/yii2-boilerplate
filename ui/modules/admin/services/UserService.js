import Vue from 'vue'

const UserService = {
  all(query) {
    return Vue.http.get('users', query)
  },

  delete(id) {
    return Vue.http.delete('users/' + id)
  },

  create(user) {
    return Vue.http.post('users', user)
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
