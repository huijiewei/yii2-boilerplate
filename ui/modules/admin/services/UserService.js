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

  view(id) {
    return Vue.http.get('users/' + id)
  },

  edit(user) {
    return Vue.http.put('users/' + user.id, user)
  },
}

export default UserService
