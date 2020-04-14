<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <shop-brand-form
      v-if="shopBrand"
      ref="form"
      :submit-text="pageTitle"
      :shop-brand="shopBrand"
      @on-submit="createShopBrand"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'
import ShopBrandForm from '@admin/views/shop-brand/_EditForm'
import flatry from '@core/utils/flatry'
import ShopBrandService from '@admin/services/ShopBrandService'

export default {
  components: { PlaceholderForm, ShopBrandForm },
  data() {
    return {
      pageTitle: '新建商品分类',
      shopBrand: null,
    }
  },
  inject: ['historyBack'],
  created() {
    this.init()
  },
  methods: {
    init() {
      this.shopBrand = {
        name: '',
        icon: '',
        logo: '',
        alias: '',
        website: '',
        description: '',
        shopCategoryIds: [],
      }
    },
    async createShopBrand(shopBrand, done, fail, always) {
      const { data, error } = await flatry(ShopBrandService.create(shopBrand))

      if (data) {
        done()

        this.$message.success('新建商品分类成功')

        this.$refs.form.init()
        this.historyBack(true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>

<style lang="scss"></style>
