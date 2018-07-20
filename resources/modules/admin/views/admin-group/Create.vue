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
      }).finally(() => {
        this.loading = false
      })
    },
    methods: {
      formSubmit(adminGroup, callback) {
        this.$http.post('admin-group/create', adminGroup).then(data => {
          this.$message.success(data.message)
          this.$router.replace({ name: 'admin-group-edit', query: { id: data.adminGroupId } })
        }).finally(() => {
          callback()
        })
      }
    }
  }
</script>

