<template>
  <el-card shadow="never">
    <div slot="header">{{ pageTitle }}</div>
    <admin-group-form v-if="adminGroup"
                      :submit-text="pageTitle"
                      :admin-group="adminGroup"
                      :all-acl="allAcl"
                      :is-edit="true"
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
        pageTitle: '编辑管理组',
        adminGroup: null,
        allAcl: []
      }
    },
    created() {
      this.$http.get('admin-group/edit', { id: this.getAdminGroupId }).then(data => {
        this.adminGroup = data.adminGroup
        this.allAcl = data.allAcl
      }).catch(() => {

      })
    },
    computed: {
      getAdminGroupId() {
        return this.$router.currentRoute.query.id
      }
    },
    methods: {
      formSubmit(adminGroup, success, callback) {
        this.$http.put('admin-group/edit', adminGroup, { id: this.getAdminGroupId }).then(data => {
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

