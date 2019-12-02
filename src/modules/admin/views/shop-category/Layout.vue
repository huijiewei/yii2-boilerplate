<template>
  <div class="box">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-input
          placeholder="筛选"
          size="small"
          suffix-icon="el-icon-search"
          v-model="keyword"
        >
        </el-input>
        <hr class="spacer-xs" />
        <div class="text-right">
          <el-button
            :disabled="!$can('shop-category/create')"
            title="创建根分类"
            size="mini"
            @click.native="handleCategoryCreate(0)"
          >
            <ag-icon type="file-add" />
            创建根分类
          </el-button>
        </div>
        <hr class="spacer-xs" />
        <el-tree
          :data="categoryTree"
          :loading="loading"
          :highlight-current="true"
          :default-expanded-keys="categoryExpanded"
          :filter-node-method="filterCategoryNode"
          ref="categoryTree"
          node-key="id"
        >
          <span class="category-tree-node" slot-scope="{ node, data }">
            <span>
              <ag-icon v-if="data.icon" :type="data.icon" />
              <ag-icon v-else-if="data.children" type="folder" />
              <ag-icon v-else type="file" />
              {{ data.name }}
            </span>
            <el-button-group class="operate">
              <el-button
                size="mini"
                @click.stop="handleCategoryEdit(data)"
                :disabled="!$can('shop-category/view')"
                icon="el-icon-edit-outline"
                title="查看编辑"
              />
              <el-button
                size="mini"
                @click.stop="handleCategoryCreate(data.id)"
                :disabled="!$can('shop-category/create')"
                icon="el-icon-folder-add"
                title="新建子分类"
              />
            </el-button-group>
          </span>
        </el-tree>
      </el-col>
      <el-col :span="18">
        <router-view
          :category-tree="this.categoryTree"
          @on-expanded="expandedCategoryTree"
          @on-updated="updatedCategoryTree"
        />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import flatry from '@core/utils/flatry'
import MiscService from '@admin/services/MiscService'
import AgIcon from '@core/components/Icon'

export default {
  watch: {
    keyword(keyword) {
      this.$refs.categoryTree.filter(keyword)
    }
  },
  components: { AgIcon },
  data() {
    return {
      loading: true,
      keyword: '',
      categoryTree: [],
      categoryExpanded: []
    }
  },
  methods: {
    handleCategoryCreate(parentId) {
      this.$router.push({
        path: '/shop-category/create',
        query: { parentId: parentId }
      })
    },

    handleCategoryEdit(category) {
      this.$router.push({
        path: '/shop-category/edit',
        query: { id: category.id }
      })
    },

    filterCategoryNode(value, data) {
      if (!value) return true
      return data.name.indexOf(value) !== -1
    },

    expandedCategoryTree(expanded, currentId) {
      this.categoryExpanded = expanded
      this.$refs.categoryTree.setCurrentKey(currentId)
    },

    async updatedCategoryTree(currentId) {
      this.loading = true
      await this.loadCategoryTree()
      this.loading = false
      this.$refs.categoryTree.setCurrentKey(currentId)
    },

    async loadCategoryTree() {
      const { data } = await flatry(MiscService.shopCategoryTree())

      if (data) {
        this.categoryTree = data
      }
    }
  },
  async created() {
    await this.loadCategoryTree()

    this.loading = false
  }
}
</script>
<style lang="scss">
.category-tree-node {
  font-size: 14px;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-right: 7px;

  &:hover {
    .operate {
      display: inline-block;
    }
  }

  .operate {
    display: none;
    font-size: 12px;
    color: #a6a9ad;

    .el-button {
      padding: 3px 5px 2px 5px;
    }
  }
}
</style>
