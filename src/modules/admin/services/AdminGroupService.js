import Vue from 'vue'

const AdminGroupService = {
  all () {
    return Vue.http.get('admin-groups')
  },
  acl () {
    return Vue.http.get('filter/admin-group-acl')
  },
  delete (id) {
    return Vue.http.delete('admin-groups/' + id)
  },
  create (adminGroup = null) {
    return Vue.http.post('admin-groups', adminGroup)
  },
  edit (id, adminGroup = null) {
    const endpoint = 'admin-groups/' + id

    if (adminGroup === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.put(endpoint, adminGroup)
  }
}

export default AdminGroupService
