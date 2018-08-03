<template>
  <div class="box">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-tree
          v-if="true"
          :data="tree"
          :loading="loading"
          :highlight-current="true"
          :expand-on-click-node="false"
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
  import AdminService from '@admin/services/AdminService'
  import flatry from '@admin/utils/flatry'
  import BpAvatar from '@admin/components/Avatar'
  import ShopCategoryService from '@admin/services/ShopCategoryService'
  import BpIcon from '@core/components/Icon/index'

  export default {
    components: { BpIcon, BpAvatar },
    data() {
      return {
        loading: true,
        tree: []
      }
    },
    methods: {
      handleAdminDelete(admin) {
        this.$confirm(`你确定要删除 ${admin.display || admin.phone} 吗？`, {
          showClose: false,
          confirmButtonText: '删除',
          confirmButtonClass: 'el-button--danger',
          cancelButtonText: '取消',
          type: 'error',
          callback: async (action) => {
            if (action === 'confirm') {
              this.loading = true

              const { data } = await flatry(AdminService.delete(admin.id))

              if (data) {
                this.admins.forEach((item, index) => {
                  if (item.id === admin.id) {
                    this.admins.splice(index, 1)
                  }
                })

                this.$message({
                  type: 'success',
                  message: data.message
                })
              }

              this.loading = false
            }
          }
        })
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
