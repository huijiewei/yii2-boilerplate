<template>
  <div class="box">
    <div class="box-toolbar">
      <router-link
        v-if="$can('admin-group/create')"
        :to="{ path: '/admin-group/create' }">
        <el-button type="primary" size="medium">
          新建管理组
        </el-button>
      </router-link>
    </div>
    <el-table v-loading="loading" :stripe="true" :data="adminGroups">
      <el-table-column
        class-name="text-mono"
        prop="id"
        label="Id">
      </el-table-column>
      <el-table-column
        prop="name"
        label="名称">
      </el-table-column>
      <el-table-column align="right" label="操作">
        <template slot-scope="scope">
          <router-link
            v-if="$can('admin-group/edit')"
            :to="{ path: '/admin-group/edit', query: { id: scope.row.id } }">
            <el-button
              title="编辑"
              type="warning"
              size="mini"
              :plain="true">
              编辑
            </el-button>
          </router-link>
          <el-button
            v-if="$can('admin-group/delete')"
            title="删除"
            size="mini"
            type="danger"
            :plain="true"
            @click="deleteAdminGroup(scope.row)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import AdminGroupService from '@admin/services/AdminGroupService'
  import flatry from '@admin/utils/flatry'

  export default {
    data() {
      return {
        loading: true,
        adminGroups: []
      }
    },
    methods: {
      deleteAdminGroup(group) {
        this.$confirm(`你确定要删除 ${group.name} 吗？`, {
          showClose: false,
          confirmButtonText: '删除',
          confirmButtonClass: 'el-button--danger',
          cancelButtonText: '取消',
          type: 'error',
          callback: async (action) => {
            if (action === 'confirm') {
              this.loading = true

              const { data } = await flatry(AdminGroupService.delete(group.id))

              if (data) {
                this.adminGroups.forEach((item, index) => {
                  if (item.id === group.id) {
                    this.adminGroups.splice(index, 1)
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
      const { data } = await flatry(AdminGroupService.all())

      if (data) {
        this.adminGroups = data.items
      }

      this.loading = false
    }
  }
</script>
