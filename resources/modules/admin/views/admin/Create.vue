<template>
  <el-card shadow="never">
    <div slot="header">{{ pageTitle }}</div>
    <admin-form v-if="admin"
                :submit-text="pageTitle"
                :admin="admin"
                :all-group="allGroup"
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
        pageTitle: '新建管理员',
        admin: null,
        allGroup: []
      }
    },
    created() {
      this.$http.get('admin/create').then(data => {
        this.admin = data.admin
        this.allGroup = data.allGroup
      }).catch(() => {
      })
    },
    methods: {
      formSubmit(admin, success, callback) {
        this.$http.post('admin/create', admin).then(data => {
          this.$message.success(data.message)
          this.$router.replace({ path: '/admin/edit', query: { id: data.adminId } })

          success()
        }).catch(() => {

        }).finally(() => {
          callback()
        })
      }
    }
  }
</script>

