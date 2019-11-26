import Vue from 'vue'

const MiscService = {
  adminGroupAcl() {
    return Vue.http.get('misc/admin-group-acl')
  },

  adminGroupMap() {
    return Vue.http.get('misc/admin-group-map')
  },

  shopCategoryTree() {
    return Vue.http.get('misc/shop-category-tree')
  }
}

export default MiscService
