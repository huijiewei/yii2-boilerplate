import Vue from 'vue'

const ShopBrandService = {
  all(query) {
    return Vue.http.get('shop-brands', query)
  },

  create(shopBrand) {
    return Vue.http.post('shop-brands', shopBrand)
  },

  view(id) {
    return Vue.http.get('shop-brands/' + id)
  },

  edit(shopBrand) {
    return Vue.http.put('shop-brands/' + shopBrand.id, shopBrand)
  },

  delete(id) {
    return Vue.http.delete('shop-brands/' + id)
  },
}

export default ShopBrandService
