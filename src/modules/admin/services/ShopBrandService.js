import Vue from 'vue'

const ShopBrandService = {
  all(query) {
    return Vue.http.get('shop-brands', query)
  },

  create(shopBrand = null) {
    return Vue.http.post('shop-brands', shopBrand)
  },

  edit(id, shopBrand = null) {
    const endpoint = 'shop-brands/' + id

    if (shopBrand === null) {
      return Vue.http.get(endpoint)
    }

    return Vue.http.put(endpoint, shopBrand)
  },

  delete(id) {
    return Vue.http.delete('shop-brands/' + id)
  }
}

export default ShopBrandService
