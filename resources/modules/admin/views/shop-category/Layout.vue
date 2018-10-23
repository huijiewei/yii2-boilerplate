<template>
  <div class="box">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-input
          placeholder="筛选"
          size="small"
          suffix-icon="el-icon-search"
          v-model="keyword">
        </el-input>
        <hr class="spacer-xs">
        <el-tree
          :data="categoryTree"
          :loading="loading"
          :highlight-current="true"
          :expand-on-click-node="false"
          :default-expanded-keys="categoryExpanded"
          :filter-node-method="filterCategoryNode"
          ref="categoryTree"
          node-key="id">
          <span class="category-tree-node" slot-scope="{ node, data }">
            <span>
              <bp-icon v-if="data.icon" :type="data.icon"></bp-icon>
              <bp-icon v-else-if="data.children" type="folder"></bp-icon>
              <bp-icon v-else type="file"></bp-icon>
              {{ data.name }}
            </span>
            <span>
              <router-link :to="{ path: '/shop-category/edit', query: { id: data.id} }">
                  <el-button title="编辑" type="text" size="mini">
                    <bp-icon type="edit"></bp-icon>
                  </el-button>
              </router-link>
              <router-link :to="{ path: '/shop-category/create', query: { id: data.id} }">
                  <el-button title="建子分类" type="text" size="mini">
                    <bp-icon type="file-add"></bp-icon>
                  </el-button>
              </router-link>
            </span>
          </span>
        </el-tree>
      </el-col>
      <el-col :span="18">
        <router-view :category-tree="this.categoryTree"
                     @on-expanded="expandedCategoryTree"
                     @on-updated="updatedCategoryTree"></router-view>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import flatry from '@admin/utils/flatry'
  import BpAvatar from '@admin/components/Avatar'
  import ShopCategoryService from '@admin/services/ShopCategoryService'
  import BpIcon from '@core/components/Icon/index'

  export default {
    watch: {
      keyword(keyword) {
        this.$refs.categoryTree.filter(keyword)
      }
    },
    components: { BpIcon, BpAvatar },
    data() {
      return {
        loading: true,
        keyword: '',
        categoryTree: [],
        categoryExpanded: []
      }
    },
    methods: {
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
        const { data } = await flatry(ShopCategoryService.tree())

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
  }
</style>
