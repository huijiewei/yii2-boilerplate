<template>
  <div class="box">
    <admin-group-form :button-text="pageTitle" v-loading="loading"
                      :admin-group="adminGroup" :all-acl="allAcl" @on-submit="formSubmit"></admin-group-form>
  </div>
</template>

<script>
  import AdminGroupForm from '@admin/views/admin-group/_EditForm'

  export default {
    components: { AdminGroupForm },
    metaInfo() {
      return {
        title: this.pageTitle
      }
    },
    data() {
      return {
        loading: true,
        pageTitle: '编辑管理组',
        adminGroup: null,
        allAcl: []
      }
    },
    created() {
      this.$http.get('admin-group/edit', { id: this.getAdminGroupId }).then(response => {
        this.adminGroup = response.data.adminGroup
        this.allAcl = response.data.allAcl
      }).catch(() => {
      }).finally(() => {
        this.loading = false
      })
    },
    computed: {
      getAdminGroupId() {
        return this.$router.currentRoute.query.id
      }
    },
    methods: {
      formSubmit(adminGroup, callback) {
        this.$http.post('admin-group/edit', adminGroup, { id: this.getAdminGroupId }).then(response => {
          this.$message.success(response.data.message)
        }).catch(() => {
        }).finally(() => {
          callback()
        })
      }
    }
  }
</script>

