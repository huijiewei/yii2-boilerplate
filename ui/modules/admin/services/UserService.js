import Vue from 'vue'

const UserService = {
  all(query) {
    return Vue.http.get('users', query)
  },

  delete(id) {
    return Vue.http.delete('user/delete' + id)
  },

  create(user) {
    return Vue.http.post('user/post', user)
  },

  view(id) {
    return Vue.http.get('users/' + id)
  },

  edit(user) {
    return Vue.http.put('users/' + user.id, user)
  },
}

export default UserService
