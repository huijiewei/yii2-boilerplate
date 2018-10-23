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
  }
}

export default ShopCategoryService
