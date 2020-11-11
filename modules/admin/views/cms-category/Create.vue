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
      :is-edit="false"
      :can-submit="$can('cms-category/create')"
      @on-submit="createCmsCategory"
    >
    </cms-category-form>
    <placeholder-form v-else></placeholder-form>
  </el-row>
</template>

<script>
import CmsCategoryForm from '@admin/views/cms-category/_EditForm'
import CmsCategoryService from '@admin/services/CmsCategoryService'
import MiscService from '@admin/services/MiscService'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'CmsCategoryCreate',
  components: { PlaceholderForm, CmsCategoryForm },
  props: {
    categoryTree: {
      type: Array,
    },
  },
  data() {
    return {
      pageTitle: '新建内容分类',
      cmsCategory: null,
      categoryParents: [],
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.cmsCategory = null
    next()
    this.getCmsCategoryPath(to.params.id)
  },
  created() {
    this.getCmsCategoryPath(this.$route.params.id)
  },
  methods: {
    async getCmsCategoryPath(id) {
      let parents = [0]

      if (id > 0) {
        const { data } = await MiscService.cmsCategoryPath(id)

        if (data && Array.isArray(data)) {
          parents = data.map((parent) => parent.id)
        }
      }

      this.categoryParents = parents

      this.$emit('on-expanded', parents, id)

      this.cmsCategory = {
        parentId: id,
        name: '',
        slug: '',
        icon: '',
        image: '',
        description: '',
      }
    },
    async createCmsCategory(cmsCategory, done, fail, always) {
      const { data, error } = await CmsCategoryService.create(cmsCategory)

      if (data) {
        done()

        this.$message.success('新建内容分类成功')

        await this.$emit('on-updated')

        await this.$router.replace({
          path: `/cms-category/edit/${data.id}`,
        })
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
