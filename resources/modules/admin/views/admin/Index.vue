<template>
  <div class="box">
    <div class="box-toolbar">
      <router-link
        v-if="$can('admin/create')"
        :to="{ path: '/admin/create' }">
        <el-button type="primary" size="medium">
          新建管理员
        </el-button>
      </router-link>
    </div>
    <el-table v-loading="loading" :stripe="true" :data="admins">
      <el-table-column
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id">
      </el-table-column>
      <el-table-column
        width="150"
        prop="phone"
        class-name="text-mono"
        label="电话号码">
      </el-table-column>
      <el-table-column
        width="150"
        prop="display"
        label="显示名">
      </el-table-column>
      <el-table-column
        width="60"
        align="center"
        label="头像">
        <template slot-scope="scope">
          <bp-avatar :avatar="scope.row.avatar"></bp-avatar>
        </template>
      </el-table-column>
      <el-table-column
        align="center"
        width="100"
        prop="group.name"
        label="所属管理组">
      </el-table-column>
      <el-table-column align="right" label="操作">
        <template slot-scope="scope">
          <router-link
            v-if="$can('admin/edit')"
            :to="{ path: '/admin/edit', query: { id: scope.row.id } }">
            <el-button
              title="编辑"
              type="warning"
              size="mini"
              :plain="true">
              编辑
            </el-button>
          </router-link>
          <el-button
            v-if="$can('admin/delete')"
            title="删除"
            size="mini"
            type="danger"
            :plain="true"
            @click="handleAdminDelete(scope.row)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import AdminService from '@admin/services/AdminService'
  import flatry from '@admin/utils/flatry'
  import BpAvatar from '@admin/components/Avatar'

  export default {
    components: { BpAvatar },
    data() {
      return {
        loading: true,
        admins: []
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
      const { data } = await flatry(AdminService.all())

      if (data) {
        this.admins = data.items
      }

      this.loading = false
    }
  }
</script>
