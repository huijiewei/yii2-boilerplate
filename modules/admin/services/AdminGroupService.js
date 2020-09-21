import Vue from 'vue'

const AdminGroupService = {
  all() {
    return Vue.http.get('admin-groups')
  },

  delete(id) {
    return Vue.http.delete('admin-groups/' + id)
  },

  create(adminGroup) {
    return Vue.http.post('admin-groups', adminGroup)
  },

  view(id) {
    return Vue.http.get('admin-groups/' + id)
  },

  edit(adminGroup) {
    return Vue.http.put('admin-groups/' + adminGroup.id, adminGroup)
  },
}

export default AdminGroupService
