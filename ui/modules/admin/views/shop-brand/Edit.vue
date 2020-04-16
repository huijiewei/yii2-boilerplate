<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}{{ name }}</h4>
    </div>
    <shop-brand-form
      v-if="shopBrand"
      :submit-text="pageTitle"
      :shop-brand="shopBrand"
      :is-edit="true"
      @on-submit="editShopBrand"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import ShopBrandForm from '@admin/views/shop-brand/_EditForm'
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'
import ShopBrandService from '@admin/services/ShopBrandService'

export default {
  name: 'ShopBrandEdit',
  components: { PlaceholderForm, ShopBrandForm },
  props: {
    name: String,
  },
  data() {
    return {
      pageTitle: '编辑商品品牌',
      shopBrand: null,
    }
  },
  inject: ['historyBack'],
  async created() {
    const { data } = await flatry(ShopBrandService.view(this.$route.params.id))

    if (data) {
      const { shopCategories, ...shopBrand } = data

      shopBrand.shopCategoryIds = []

      if (Array.isArray(shopCategories)) {
        shopCategories.forEach(function (category) {
          const parentIds = []

          if (Array.isArray(category.parents)) {
            category.parents.forEach(function (parent) {
              parentIds.push(parent.id)
            })
          }

          parentIds.push(category.id)

          shopBrand.shopCategoryIds.push(parentIds)
        })
      }

      this.shopBrand = shopBrand
    }
  },
  methods: {
    async editShopBrand(shopBrand, done, fail, always) {
      const { data, error } = await flatry(ShopBrandService.edit(shopBrand))

      if (data) {
        done()

        this.$message.success('商品品牌编辑成功')

        await this.$store.dispatch('tabs/deleteCache', 'ShopBrand')
        await this.historyBack('/shop-brand', false, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
