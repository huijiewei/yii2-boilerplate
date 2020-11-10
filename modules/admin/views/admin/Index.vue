<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-button">
        <el-button
          :disabled="!$can('admin/create')"
          type="primary"
          size="medium"
          @click.native="handleAdminCreate()"
        >
          新建管理员
        </el-button>
      </div>
    </div>
    <el-table v-loading="loading" :data="admins">
      <el-table-column
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
        fixed
      />
      <el-table-column
        width="130"
        prop="phone"
        class-name="text-mono"
        label="手机号码"
      />
      <el-table-column
        width="300"
        prop="email"
        class-name="text-mono"
        label="电子邮箱"
      />
      <el-table-column width="120" prop="name" label="名称" />
      <el-table-column width="55" align="center" label="头像">
        <template slot-scope="scope">
          <ag-avatar :src="scope.row.avatar" />
        </template>
      </el-table-column>
      <el-table-column
        align="center"
        width="120"
        prop="adminGroup.name"
        label="所属管理组"
      />
      <el-table-column prop="createdAt" label="创建时间" min-width="160" />
      <el-table-column width="135" fixed="right" label="操作" align="right">
        <template slot-scope="scope">
          <el-button
            :disabled="!$can('admin/edit')"
            plain
            type="primary"
            size="mini"
            @click="handleAdminEdit(scope.row)"
          >
            编辑
          </el-button>
          <el-button
            :disabled="!$can('admin/delete')"
            plain
            type="danger"
            size="mini"
            @click="handleAdminDelete(scope.row)"
          >
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import AdminService from '@admin/services/AdminService'
import AgAvatar from '@core/components/Avatar'

export default {
  name: 'Admin',
  components: { AgAvatar },
  data() {
    return {
      loading: true,
      admins: [],
    }
  },
  async created() {
    const { data } = await AdminService.all()

    if (data) {
      this.admins = Object.freeze(data.items)
    }

    this.loading = false
  },
  methods: {
    handleAdminCreate() {
      this.$router.push({
        path: '/admin/create',
      })
    },
    handleAdminEdit(admin) {
      this.$router.push({
        path: `/admin/edit/${admin.id}`,
      })
    },
    handleAdminDelete(admin) {
      this.$deleteDialog({
        message: `输入管理员电话 <strong>${admin.phone}</strong> 以确认删除`,
        promptLabel: '管理员电话',
        promptValue: admin.phone,
        callback: async () => {
          this.loading = true

          const { data } = await AdminService.delete(admin.id)

          if (data) {
            this.admins = Object.freeze(
              this.admins.filter((item) => item.id !== admin.id)
            )

            this.$message({
              type: 'success',
              message: data.message,
            })
          }

          this.loading = false
        },
      })
    },
  },
}
</script>
