<template>
  <el-row :gutter="0" style="padding: 5px;">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <shop-category-form
      v-if="shopCategory"
      :submit-text="pageTitle"
      :shop-category="shopCategory"
      :category-tree="categoryTree"
      :category-parents="categoryParents"
      :is-edit="true"
      @on-submit="createShopCategory"
    >
    </shop-category-form>
    <placeholder-form v-else></placeholder-form>
  </el-row>
</template>

<script>
import ShopCategoryForm from '@admin/views/shop-category/_EditForm'
import ShopCategoryService from '@admin/services/ShopCategoryService'
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  components: { PlaceholderForm, ShopCategoryForm },
  props: {
    categoryTree: {
      type: Array
    }
  },
  data() {
    return {
      pageTitle: '新建商品分类',
      shopCategory: null,
      categoryParents: []
    }
  },
  async beforeRouteUpdate(to, from, next) {
    this.shopCategory = null
    await this.getShopCategory(to.query.id)
    next()
  },
  async created() {
    await this.getShopCategory(this.$router.currentRoute.query.id)
  },
  methods: {
    async getShopCategory(id) {
      const { data } = await flatry(ShopCategoryService.create(null, id))

      if (data) {
        if (data.ancestor && Array.isArray(data.ancestor)) {
          const ancestor = []
          data.ancestor.forEach(function(item) {
            ancestor.push(item.id)
          })
          this.categoryParents = ancestor

          this.$emit('on-expanded', ancestor, data.id)
        }

        this.shopCategory = data
      }
    },
    async createShopCategory(shopCategory, success, callback) {
      const { data } = await flatry(ShopCategoryService.create(shopCategory))

      if (data) {
        this.$message.success('新建商品分类成功')
        await this.$router.replace({
          path: '/shop-category/edit',
          query: { id: data.categoryId }
        })
        this.$emit('on-updated', data.categoryId)
        success()
      }

      callback()
    }
  }
}
</script>
