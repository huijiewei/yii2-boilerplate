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
            type="text"
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
          @node-contextmenu="handleContextMenu"
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
            <span class="help">右键操作</span>
          </span>
        </el-tree>
        <vue-context ref="contextMenu">
          <template slot-scope="child">
            <li>
              <span
                v-if="$can('shop-category/edit')"
                @click="handleCategoryEdit(child.data)"
                >编辑</span
              >
              <span v-else class="disabled">编辑</span>
            </li>
            <li>
              <span
                v-if="$can('shop-category/create')"
                @click="handleCategoryCreate(child.data.id)"
                >新建子分类</span
              >
              <span v-else class="disabled">新建子分类</span>
            </li>
          </template>
        </vue-context>
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
import VueContext from '@admin/components/ContextMenu'

export default {
  watch: {
    keyword(keyword) {
      this.$refs.categoryTree.filter(keyword)
    }
  },
  components: { AgIcon, VueContext },
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

    handleContextMenu(event, category) {
      this.$refs.contextMenu.open(event, category)
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

  .help {
    font-size: 12px;
    color: #a6a9ad;
  }
}
</style>
