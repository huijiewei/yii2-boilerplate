import Vue from 'vue'

const OpenService = {
  adminGroupAcl () {
    return Vue.http.get('open/admin-group-acl')
  },

  adminGroupMap () {
    return Vue.http.get('open/admin-group-map')
  }
}

export default OpenService
