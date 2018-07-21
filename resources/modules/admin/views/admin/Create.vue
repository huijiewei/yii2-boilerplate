<template>
  <el-card shadow="never">
    <div slot="header">{{ pageTitle }}</div>
    <admin-form v-if="admin" :button-text="pageTitle"
                v-loading="loading"
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
        loading: true,
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
      }).finally(() => {
        this.loading = false
      })
    },
    methods: {
      formSubmit(admin, success, always) {
        this.$http.post('admin/create', admin).then(data => {
          this.$message.success(data.message)
          this.$router.replace({ name: 'admin-edit', query: { id: data.adminId } })
        }).catch(() => {
        }).finally(() => {
          always()
        })
      }
    }
  }
</script>

