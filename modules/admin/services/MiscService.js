import Vue from 'vue'

const MiscService = {
  adminGroups() {
    return Vue.http.get('misc/admin-groups')
  },

  adminGroupPermissions() {
    return Vue.http.get('misc/admin-group-permissions')
  },

  shopCategoryTree() {
    return Vue.http.get('misc/shop-category-tree')
  },

  shopCategoryPath(id) {
    return Vue.http.get('misc/shop-category-path', { id: id })
  },
}

export default MiscService
