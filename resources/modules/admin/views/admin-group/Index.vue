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
      <el-table-column width="90" label="操作">
        <template slot-scope="scope">
          <el-dropdown trigger="click">
            <el-button plain size="mini" type="primary">
              操作<i class="el-icon-arrow-down el-icon--right"></i>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item v-if="$can('admin-group/edit')" @click.native="handleAdminGroupEdit(scope.row)">
                编辑
              </el-dropdown-item>
              <el-dropdown-item v-if="$can('admin-group/delete')" @click.native="handleAdminGroupDelete(scope.row)">
                删除
              </el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </template>
      </el-table-column>
      <el-table-column
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id">
      </el-table-column>
      <el-table-column
        prop="name"
        label="名称">
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
      handleAdminGroupEdit(adminGroup) {
        this.$router.push({ path: '/admin-group/edit', query: { id: adminGroup.id } })
      },
      handleAdminGroupDelete(adminGroup) {
        this.$deleteDialog(`管理组 ${ adminGroup.name }`, async (action) => {
          if (action === 'confirm') {
            this.loading = true

            const { data } = await flatry(AdminGroupService.delete(adminGroup.id))

            if (data) {
              this.adminGroups.forEach((item, index) => {
                if (item.id === adminGroup.id) {
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
