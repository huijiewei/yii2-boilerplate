<template>
  <el-row :gutter="0" style="padding: 5px">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <cms-category-form
      v-if="cmsCategory"
      :submit-text="pageTitle"
      :cms-category="cmsCategory"
      :category-tree="categoryTree"
      :category-parents="categoryParents"
      :is-edit="true"
      :can-submit="$can('cms-category/edit')"
      @on-submit="editCmsCategory"
      @on-delete="deleteCmsCategory"
    >
    </cms-category-form>
    <placeholder-form v-else />
  </el-row>
</template>

<script>
import CmsCategoryForm from '@admin/views/cms-category/_EditForm'
import CmsCategoryService from '@admin/services/CmsCategoryService'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'CmsCategoryEdit',
  components: { PlaceholderForm, CmsCategoryForm },
  props: {
    categoryTree: {
      type: Array,
    },
  },
  data() {
    return {
      pageTitle: '编辑内容分类',
      cmsCategory: null,
      categoryParents: [],
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.cmsCategory = null
    next()
    this.getCmsCategory(to.params.id)
  },
  created() {
    this.getCmsCategory(this.$route.params.id)
  },
  methods: {
    async getCmsCategory(id) {
      const { data } = await CmsCategoryService.view(id)

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

        this.cmsCategory = data
      }
    },
    async editCmsCategory(cmsCategory, done, fail, always) {
      const { data, error } = await CmsCategoryService.edit(cmsCategory)

      if (data) {
        done()

        this.$message.success('修改成功')

        await this.$emit('on-updated')

        this.$emit(
          'on-expanded',
          data.parents.map((parent) => parent.id),
          data.id
        )
      }

      if (error) {
        fail(error)
      }

      always()
    },
    async deleteCmsCategory(cmsCategory) {
      this.$deleteDialog({
        message: `删除内容分类 <strong>${cmsCategory.name}</strong>`,
        callback: async () => {
          this.loading = true

          const { data } = await CmsCategoryService.delete(cmsCategory.id)

          if (data) {
            this.$message.success('删除成功')

            await this.$emit('on-updated')

            this.$emit(
              'on-expanded',
              this.categoryParents,
              cmsCategory.parentId
            )

            await this.$router.replace({
              path: '/cms-category',
            })
          }

          this.loading = false
        },
      })
    },
  },
}
</script>
