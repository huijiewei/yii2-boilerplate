import Vue from 'vue'

const AdminService = {
  all() {
    return Vue.http.get('admin', { expand: 'group' })
  },

  delete(id) {
    return Vue.http.delete('admin/delete', { id: id })
  },

  create(admin = null) {
    const endpoint = 'admin/create'

    if (admin === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.post(endpoint, admin)
  },

  edit(id, admin = null) {
    const endpoint = 'admin/edit'

    if (admin === null) {
      return Vue.http.get(endpoint, { id: id })
    }

    return Vue.http.put(endpoint, admin, { id: id })
  }
}

export default AdminService
