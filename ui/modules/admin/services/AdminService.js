import Vue from 'vue'

const AdminService = {
  all() {
    return Vue.http.get('admins')
  },

  log(query) {
    return Vue.http.get('admin-logs', query)
  },

  delete(id) {
    return Vue.http.delete('admins/' + id)
  },

  create(admin) {
    return Vue.http.post('admins', admin)
  },

  view(id) {
    return Vue.http.get('admins/' + id)
  },

  edit(admin) {
    return Vue.http.put('admins/' + admin.id, admin)
  },
}

export default AdminService
