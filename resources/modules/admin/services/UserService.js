import Vue from 'vue'

const UserService = {
  all(query) {
    return Vue.http.get('user', query)
  },

  delete(id) {
    return Vue.http.delete('user/delete', { id: id })
  },

  create(user = null) {
    const endpoint = 'user/create'

    if (user === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.post(endpoint, user)
  },

  edit(id, user = null) {
    const endpoint = 'user/edit'

    if (user === null) {
      return Vue.http.get(endpoint, { id: id })
    }

    return Vue.http.put(endpoint, user, { id: id })
  }
}

export default UserService
