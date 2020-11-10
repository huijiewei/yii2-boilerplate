<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-button">
        <el-button
          :disabled="!$can('admin-group/create')"
          type="primary"
          size="medium"
          @click.native="handleAdminGroupCreate()"
        >
          新建管理组
        </el-button>
      </div>
    </div>
    <el-table v-loading="loading" :data="adminGroups">
      <el-table-column width="90" class-name="text-mono" prop="id" label="Id" />
      <el-table-column prop="name" label="名称" />
      <el-table-column width="130" fixed="right" label="操作" align="right">
        <template slot-scope="scope">
          <el-button
            :disabled="!$can('admin-group/edit')"
            plain
            type="primary"
            size="mini"
            @click="handleAdminGroupEdit(scope.row)"
          >
            编辑
          </el-button>
          <el-button
            :disabled="!$can('admin-group/delete')"
            plain
            type="danger"
            size="mini"
            @click="handleAdminGroupDelete(scope.row)"
          >
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import AdminGroupService from '@admin/services/AdminGroupService'

export default {
  name: 'AdminGroup',
  data() {
    return {
      loading: true,
      adminGroups: [],
    }
  },
  async created() {
    const { data } = await AdminGroupService.all()

    if (data) {
      this.adminGroups = Object.freeze(data.items)
    }

    this.loading = false
  },
  methods: {
    handleAdminGroupCreate() {
      this.$router.push({ path: '/admin-group/create' })
    },
    handleAdminGroupEdit(adminGroup) {
      this.$router.push({
        path: `/admin-group/edit/${adminGroup.id}`,
      })
    },
    handleAdminGroupDelete(adminGroup) {
      this.$deleteDialog({
        message: `删除管理组 <strong>${adminGroup.name}</strong>`,
        callback: async () => {
          this.loading = true

          const { data } = await AdminGroupService.delete(adminGroup.id)

          if (data) {
            this.adminGroups = Object.freeze(
              this.adminGroups.filter((item) => item.id !== adminGroup.id)
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
