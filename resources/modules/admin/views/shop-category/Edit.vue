<template>
  <el-row :gutter="0" style="padding: 5px;">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <shop-category-form v-if="shopCategory"
                        :submit-text="pageTitle"
                        :shop-category="shopCategory"
                        :category-tree="categoryTree"
                        :category-ancestor="categoryAncestor"
                        :is-edit="true"
                        @on-submit="editShopCategory">
    </shop-category-form>
    <placeholder-form v-else></placeholder-form>
  </el-row>
</template>

<script>
  import ShopCategoryForm from '@admin/views/shop-category/_EditForm'
  import ShopCategoryService from '@admin/services/ShopCategoryService'
  import flatry from '@admin/utils/flatry'
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
        pageTitle: '编辑商品分类',
        shopCategory: null,
        categoryAncestor: []
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
        const { data } = await flatry(ShopCategoryService.edit(id))

        if (data) {
          if (data.ancestor && Array.isArray(data.ancestor)) {
            const ancestor = []
            data.ancestor.forEach(function(item) {
              ancestor.push(item.id)
            })
            this.categoryAncestor = ancestor

            this.$emit('on-expanded', ancestor, data.id)
          }

          this.shopCategory = data
        }
      },
      async editShopCategory(shopCategory, success, callback) {
        const { data } = await flatry(ShopCategoryService.edit(shopCategory.id, shopCategory))

        if (data) {
          this.$message.success(data.message)
          success()
          this.$emit('on-updated', shopCategory.id)
        }

        callback()
      }
    }
  }
</script>
