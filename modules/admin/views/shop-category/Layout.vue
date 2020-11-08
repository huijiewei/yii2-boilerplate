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
            :disabled="!$can('shop-category/create')"
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
  name: 'ShopCategory',
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
        path: `/shop-category/create/${parentId}`,
      })
    },

    handleCategoryEdit(category) {
      this.$router.push({
        path: `/shop-category/edit/${category.id}`,
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

      const { data } = await MiscService.shopCategoryTree()

      if (data) {
        this.categoryTree = data
      }

      this.loading = false
    },
  },
  created() {
    this.loadCategoryTree()
  },
}
</script>
<style lang="less">
.category-tree-node {
  font-size: 14px;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-right: 7px;

  .category-tree-icon {
    [class^='el-icon-'] {
      margin-right: 3px;
    }
  }

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
