import Vue from 'vue'

const AdminGroupService = {
  all() {
    return Vue.http.get('admin-group')
  },
  acls() {
    return Vue.http.get('filter/admin-all-acl')
  },
  delete(id) {
    return Vue.http.delete('admin-group/delete', { id: id })
  },
  create(adminGroup = null) {
    const endpoint = 'admin-group/create'

    if (adminGroup === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.post(endpoint, adminGroup)
  },
  edit(id, adminGroup = null) {
    const endpoint = 'admin-group/edit'

    if (adminGroup === null) {
      return Vue.http.get(endpoint, { id: id })
    }

    return Vue.http.put(endpoint, adminGroup, { id: id })
  }
}

export default AdminGroupService
