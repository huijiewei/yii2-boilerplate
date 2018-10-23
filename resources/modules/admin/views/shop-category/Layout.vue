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
          :data="tree"
          :loading="loading"
          :highlight-current="true"
          :expand-on-click-node="false"
          :default-checked-keys="[178]"
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
                <el-button type="text" size="mini">
                  <bp-icon type="edit"></bp-icon>
                  编辑
                </el-button>
              </router-link>
            </span>
          </span>
        </el-tree>
      </el-col>
      <el-col :span="18">
        <router-view></router-view>
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
        tree: []
      }
    },
    methods: {
      filterCategoryNode(value, data) {
        if (!value) return true
        return data.name.indexOf(value) !== -1
      }
    },
    async created() {
      const { data } = await flatry(ShopCategoryService.tree())

      if (data) {
        this.tree = data
      }

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
