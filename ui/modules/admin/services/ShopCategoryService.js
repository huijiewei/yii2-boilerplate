import Vue from 'vue'

const ShopCategoryService = {
  create(shopCategory = null) {
    return Vue.http.post('shop-categories', shopCategory)
  },

  edit(id, shopCategory = null) {
    const endpoint = 'shop-categories/' + id

    if (shopCategory === null) {
      return Vue.http.get(endpoint, { withParents: true })
    }

    return Vue.http.put(endpoint, shopCategory)
  },

  delete(id) {
    return Vue.http.delete('shop-categories/' + id)
  },
}

export default ShopCategoryService
