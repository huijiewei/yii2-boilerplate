<template>
  <div class="box">
    <admin-group-form :button-text="pageTitle"
                      v-loading="loading"
                      :admin-group="adminGroup"
                      :all-acl="allAcl"
                      @on-submit="formSubmit">
    </admin-group-form>
  </div>
</template>

<script>
  import AdminGroupForm from '@admin/views/admin-group/_EditForm'

  export default {
    components: { AdminGroupForm },
    data() {
      return {
        loading: true,
        pageTitle: '编辑管理组',
        adminGroup: null,
        allAcl: []
      }
    },
    created() {
      this.getAdminGroup()
    },
    computed: {
      getAdminGroupId() {
        return this.$router.currentRoute.query.id
      }
    },
    methods: {
      getAdminGroup() {
        this.$http.get('admin-group/edit', { id: this.getAdminGroupId }).then(data => {
          this.adminGroup = data.adminGroup
          this.allAcl = data.allAcl
        }).finally(() => {
          this.loading = false
        })
      },
      formSubmit(adminGroup, callback) {
        this.$http.put('admin-group/edit', adminGroup, { id: this.getAdminGroupId }).then(data => {
          this.$message.success(data.message)
        }).catch(() => {
        }).finally(() => {
          callback()
        })
      }
    }
  }
</script>

