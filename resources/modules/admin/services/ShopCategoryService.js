import Vue from 'vue'

const ShopCategoryService = {
  tree() {
    return Vue.http.get('filter/shop-category-tree')
  },

  edit(id, shopCategory = null) {
    const endpoint = 'shop-category/edit'

    if (shopCategory === null) {
      return Vue.http.get(endpoint, { id: id })
    }

    return Vue.http.put(endpoint, shopCategory, { id: id })
  },

  create(shopCategory = null, parentId = 0) {
    const endpoint = 'shop-category/create'

    if (shopCategory === null) {
      return Vue.http.get(endpoint, { parentId: parentId })
    }

    return Vue.http.post(endpoint, shopCategory)
  }
}

export default ShopCategoryService
