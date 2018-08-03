import Vue from 'vue'

const ShopCategoryService = {
  tree() {
    return Vue.http.get('filter/shop-category-tree')
  }
}

export default ShopCategoryService
