import Vue from 'vue'

const OpenService = {
  adminGroupAcl () {
    return Vue.http.get('open/admin-group-acl')
  },

  adminGroupOptions () {
    return Vue.http.get('open/admin-group-options')
  }
}

export default OpenService
