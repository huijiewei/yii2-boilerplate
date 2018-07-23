<template>
  <el-card shadow="never">
    <div slot="header">{{ pageTitle }}</div>
    <admin-group-form v-if="adminGroup"
                      :submit-text="pageTitle"
                      :admin-group="adminGroup"
                      :all-acl="allAcl"
                      @on-submit="formSubmit">
    </admin-group-form>
  </el-card>
</template>

<script>
  import AdminGroupForm from '@admin/views/admin-group/_EditForm'

  export default {
    components: { AdminGroupForm },
    data() {
      return {
        pageTitle: '新建管理组',
        adminGroup: null,
        allAcl: []
      }
    },
    created() {
      this.$http.get('admin-group/create').then(data => {
        this.adminGroup = data.adminGroup
        this.allAcl = data.allAcl
      }).catch(() => {
      })
    },
    methods: {
      formSubmit(adminGroup, success, callback) {
        this.$http.post('admin-group/create', adminGroup).then(data => {
          this.$message.success(data.message)
          this.$router.replace({ path: '/admin-group/edit', query: { id: data.adminGroupId } })

          success()
        }).catch(() => {

        }).finally(() => {
          callback()
        })
      }
    }
  }
</script>

