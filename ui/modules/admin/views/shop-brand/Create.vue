<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <shop-brand-form
      v-if="shopBrand"
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
import ShopBrandService from '@admin/services/ShopBrandService'

export default {
  name: 'ShopBrandCreate',
  components: { PlaceholderForm, ShopBrandForm },
  data() {
    return {
      pageTitle: '新建商品分类',
      shopBrand: null,
    }
  },
  inject: ['historyBack'],
  created() {
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
  methods: {
    async createShopBrand(shopBrand, done, fail, always) {
      const { data, error } = await ShopBrandService.create(shopBrand)

      if (data) {
        done()

        this.$message.success('新建商品分类成功')

        await this.$store.dispatch('tabs/deleteCache', 'ShopBrand')
        await this.historyBack('/shop-brand', true, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
