import Vue from 'vue'

const MiscService = {
  adminGroupAcl() {
    return Vue.http.get('misc/admin-group-acl')
  },

  adminGroupList() {
    return Vue.http.get('misc/admin-group-list')
  },

  shopBrandList() {
    return Vue.http.get('misc/shop-brand-list')
  },

  shopCategoryTree() {
    return Vue.http.get('misc/shop-category-tree')
  },

  shopCategoryRoute(id) {
    return Vue.http.get('misc/shop-category-route', { id: id })
  }
}

export default MiscService
