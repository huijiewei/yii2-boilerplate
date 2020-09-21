<template>
  <el-row :gutter="0" style="padding: 5px">
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
      :can-submit="$can('shop-category/edit')"
      @on-submit="editShopCategory"
      @on-delete="deleteShopCategory"
    >
    </shop-category-form>
    <placeholder-form v-else />
  </el-row>
</template>

<script>
import ShopCategoryForm from '@admin/views/shop-category/_EditForm'
import ShopCategoryService from '@admin/services/ShopCategoryService'
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'ShopCategoryEdit',
  components: { PlaceholderForm, ShopCategoryForm },
  props: {
    categoryTree: {
      type: Array,
    },
  },
  data() {
    return {
      pageTitle: '编辑商品分类',
      shopCategory: null,
      categoryParents: [],
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.shopCategory = null
    next()
    this.getShopCategory(to.params.id)
  },
  created() {
    this.getShopCategory(this.$route.params.id)
  },
  methods: {
    async getShopCategory(id) {
      const { data } = await flatry(ShopCategoryService.view(id))

      if (data) {
        let parents = [0]

        if (
          data.parents &&
          Array.isArray(data.parents) &&
          data.parents.length > 0
        ) {
          parents = data.parents.map((parent) => parent.id)
        }

        this.categoryParents = parents

        this.$emit('on-expanded', parents, data.id)

        this.shopCategory = data
      }
    },
    async editShopCategory(shopCategory, done, fail, always) {
      const { data, error } = await flatry(
        ShopCategoryService.edit(shopCategory)
      )

      if (data) {
        done()

        this.$message.success('修改成功')

        this.$emit('on-updated', shopCategory.id)
      }

      if (error) {
        fail(error)
      }

      always()
    },
    async deleteShopCategory(shopCategory) {
      this.$deleteDialog({
        message: `删除商品分类 <strong>${shopCategory.name}</strong>`,
        callback: async () => {
          this.loading = true

          const { data } = await flatry(
            ShopCategoryService.delete(shopCategory.id)
          )

          if (data) {
            this.$message.success('删除成功')

            this.$emit('on-updated', shopCategory.parentId)

            await this.$router.replace({
              path: '/shop-category',
            })
          }

          this.loading = false
        },
      })
    },
  },
}
</script>
