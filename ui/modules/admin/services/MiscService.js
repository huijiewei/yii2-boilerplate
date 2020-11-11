import Vue from 'vue'

const MiscService = {
  districts(parentId) {
    return Vue.http.get('misc/districts', { parentId: parentId }, false)
  },

  districtPath(id) {
    return Vue.http.get('misc/district-path', { id: id }, false)
  },

  districtSearchTree(keyword) {
    return Vue.http.get(
      'misc/district-search-tree',
      { keyword: keyword },
      false
    )
  },

  adminGroups() {
    return Vue.http.get('misc/admin-groups', null, false)
  },

  adminGroupPermissions() {
    return Vue.http.get('misc/admin-group-permissions', null, false)
  },

  shopCategoryTree() {
    return Vue.http.get('misc/shop-category-tree', null, false)
  },

  shopCategoryPath(id) {
    return Vue.http.get('misc/shop-category-path', { id: id }, false)
  },

  cmsCategoryTree() {
    return Vue.http.get('misc/cms-category-tree', null, false)
  },

  cmsCategoryPath(id) {
    return Vue.http.get('misc/cms-category-path', { id: id }, false)
  },
}

export default MiscService
