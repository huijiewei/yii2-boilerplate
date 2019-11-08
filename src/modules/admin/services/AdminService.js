import Vue from 'vue'

const AdminService = {
  all () {
    return Vue.http.get('admins')
  },

  groups () {
    return Vue.http.get('filter/admin-groups')
  },

  delete (id) {
    return Vue.http.delete('admins/' + id)
  },

  create (admin) {
    return Vue.http.post('admins', admin)
  },

  edit (id, admin = null) {
    const endpoint = 'admins/' + id

    if (admin === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.put(endpoint, admin)
  }
}

export default AdminService
