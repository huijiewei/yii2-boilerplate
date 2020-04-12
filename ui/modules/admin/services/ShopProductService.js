import Vue from 'vue'

const ShopProductService = {
  all(query) {
    return Vue.http.get('shop-products', query)
  },

  create(shopProduct) {
    return Vue.http.post('shop-products', shopProduct)
  },

  view(id) {
    return Vue.http.get('shop-products/' + id)
  },

  edit(shopProduct) {
    return Vue.http.put('shop-products/' + shopProduct.id, shopProduct)
  },

  delete(id) {
    return Vue.http.delete('shop-products/' + id)
  },
}

export default ShopProductService
