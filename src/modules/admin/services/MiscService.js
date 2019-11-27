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
  },

  shopCategoryRoute(id) {
    return Vue.http.get('misc/shop-category-route', { id: id })
  },

  shopCategoryChildren(id) {
    return Vue.http.get('misc/shop-category-children', { id: id })
  }
}

export default MiscService
