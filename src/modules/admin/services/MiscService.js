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

  shopCategoryPath(id) {
    return Vue.http.get('misc/shop-category-path', { id: id })
  },
}

export default MiscService
