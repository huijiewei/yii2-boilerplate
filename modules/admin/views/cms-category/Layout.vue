<template>
  <div class="box">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-input
          placeholder="筛选"
          size="small"
          suffix-icon="el-icon-search"
          v-model="keyword"
          :clearable="true"
        >
        </el-input>
        <hr class="spacer-xs" />
        <div class="text-right">
          <el-button
            :disabled="!$can('cms-category/create')"
            title="创建根分类"
            size="mini"
            @click.native="handleCategoryCreate(0)"
            icon="el-icon-folder-add"
          >
            创建根分类
          </el-button>
        </div>
        <hr class="spacer-xs" />
        <el-tree
          v-loading="loading"
          :data="categoryTree"
          :loading="loading"
          :highlight-current="true"
          :default-expanded-keys="categoryExpanded"
          :filter-node-method="filterCategoryNode"
          ref="categoryTree"
          node-key="id"
        >
          <div class="category-tree-node" slot-scope="{ data }">
            <div class="category-tree-icon">
              <ag-icon v-if="data.icon" :path="data.icon" />
              <i v-else-if="data.children" class="el-icon-folder" />
              <i v-else class="el-icon-document" />
              <span>{{ data.name }}</span>
            </div>
            <el-button-group class="operate">
              <el-button
                size="mini"
                @click.stop="handleCategoryEdit(data)"
                :disabled="!$can('cms-category/view')"
                icon="el-icon-edit-outline"
                title="查看编辑"
              />
              <el-button
                size="mini"
                @click.stop="handleCategoryCreate(data.id)"
                :disabled="!$can('cms-category/create')"
                icon="el-icon-folder-add"
                title="新建子分类"
              />
            </el-button-group>
          </div>
        </el-tree>
      </el-col>
      <el-col :span="18">
        <router-view
          :category-tree="this.categoryTree"
          @on-expanded="handleCategoryTreeExpanded"
          @on-updated="handleCategoryTreeUpdated"
        />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import MiscService from '@admin/services/MiscService'
import AgIcon from '@core/components/Icon'

export default {
  name: 'CmsCategory',
  watch: {
    keyword(keyword) {
      if (!keyword) {
        this.setAllExpand(false)
      }

      this.$refs.categoryTree.filter(keyword)
    },
  },
  components: { AgIcon },
  data() {
    return {
      loading: true,
      keyword: '',
      categoryTree: [],
      categoryExpanded: [],
    }
  },
  methods: {
    setAllExpand(state) {
      const nodes = this.$refs.categoryTree.store.nodesMap

      for (const key in nodes) {
        if (nodes.hasOwnProperty(key)) {
          nodes[key].expanded = state
        }
      }
    },

    handleCategoryCreate(parentId) {
      this.$router.push({
        path: `/cms-category/create/${parentId}`,
      })
    },

    handleCategoryEdit(category) {
      this.$router.push({
        path: `/cms-category/edit/${category.id}`,
      })
    },

    filterCategoryNode(value, data) {
      if (!value) {
        return true
      }

      return data.name.indexOf(value) !== -1
    },

    handleCategoryTreeExpanded(expanded, currentId) {
      this.categoryExpanded = expanded
      this.$refs.categoryTree.setCurrentKey(currentId)
    },

    async handleCategoryTreeUpdated() {
      await this.loadCategoryTree()
    },

    async loadCategoryTree() {
      this.loading = true

      const { data } = await MiscService.cmsCategoryTree()

      if (data) {
        this.categoryTree = Object.freeze(data)
      }

      this.loading = false
    },
  },
  created() {
    this.loadCategoryTree()
  },
}
</script>
