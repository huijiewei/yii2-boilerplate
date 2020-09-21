import Vue from 'vue'

const ShopCategoryService = {
  create(shopCategory) {
    return Vue.http.post('shop-categories', shopCategory)
  },

  view(id) {
    return Vue.http.get('shop-categories/' + id, { withParents: true })
  },

  edit(shopCategory) {
    return Vue.http.put('shop-categories/' + shopCategory.id, shopCategory)
  },

  delete(id) {
    return Vue.http.delete('shop-categories/' + id)
  },
}

export default ShopCategoryService
