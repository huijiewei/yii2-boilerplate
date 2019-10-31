<template>
  <div class="box">
    <div class="box-toolbar">
      <router-link
        v-if="$can('admin/create')"
        :to="{ path: '/admin/create' }"
      >
        <el-button
          type="primary"
          size="medium"
        >
          新建管理员
        </el-button>
      </router-link>
    </div>
    <el-table
      v-loading="loading"
      :stripe="true"
      :data="admins"
    >
      <el-table-column
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
      />
      <el-table-column
        width="150"
        prop="phone"
        class-name="text-mono"
        label="电话号码"
      />
      <el-table-column
        width="150"
        prop="display"
        label="显示名"
      />
      <el-table-column
        width="60"
        align="center"
        label="头像"
      >
        <template slot-scope="scope">
          <ag-avatar :avatar="scope.row.avatar" />
        </template>
      </el-table-column>
      <el-table-column
        align="center"
        width="100"
        prop="group.name"
        label="所属管理组"
      />
      <el-table-column
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        fixed="right"
        label="操作"
        align="right"
      >
        <template slot-scope="scope">
          <el-button-group>
            <el-button
              v-if="$can('admin/edit')"
              plain
              type="primary"
              size="mini"
              @click.native="handleAdminEdit(scope.row)"
            >
              编辑
            </el-button>
            <el-button
              v-if="$can('admin/delete')"
              plain
              type="warning"
              size="mini"
              @click.native="handleAdminDelete(scope.row)"
            >
              删除
            </el-button>
          </el-button-group>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import AdminService from '@admin/services/AdminService'
import flatry from '@core/utils/flatry'
import AgAvatar from '@core/components/Avatar'

export default {
  components: { AgAvatar },
  data () {
    return {
      loading: true,
      admins: []
    }
  },
  async created () {
    const { data } = await flatry(AdminService.all())

    if (data) {
      this.admins = data.items
    }

    this.loading = false
  },
  methods: {
    handleAdminEdit (admin) {
      this.$router.push({ path: '/admin/edit', query: { id: admin.id } })
    },
    handleAdminDelete (admin) {
      this.$deleteDialog(
        `管理员 ${admin.display || admin.phone}`,
        async (action) => {
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
        },
        admin.phone,
        '请输入管理员电话'
      )
    }
  }
}
</script>
