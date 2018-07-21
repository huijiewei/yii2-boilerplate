<template>
  <el-card shadow="never">
    <div slot="header">{{ pageTitle }}</div>
    <admin-form v-if="admin" :button-text="pageTitle"
                v-loading="loading"
                :admin="admin"
                :all-group="allGroup"
                :is-edit="true"
                @on-submit="formSubmit">
    </admin-form>
  </el-card>
</template>

<script>
  import AdminForm from '@admin/views/admin/_EditForm'

  export default {
    components: { AdminForm },
    data() {
      return {
        loading: true,
        pageTitle: '编辑管理员',
        admin: null,
        allGroup: []
      }
    },
    created() {
      this.getAdmin()
    },
    computed: {
      getAdminId() {
        return this.$router.currentRoute.query.id
      }
    },
    methods: {
      getAdmin() {
        this.$http.get('admin/edit', { id: this.getAdminId }).then(data => {
          this.admin = data.admin
          this.allGroup = data.allGroup
        }).finally(() => {
          this.loading = false
        })
      },
      formSubmit(adminGroup, success, callback) {
        this.$http.put('admin/edit', adminGroup, { id: this.getAdminId }).then(data => {
          this.$message.success(data.message)
          success()
        }).catch(() => {
        }).finally(() => {
          callback()
        })
      }
    }
  }
</script>

