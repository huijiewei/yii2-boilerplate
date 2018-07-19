<template>
  <div class="box">
    <admin-group-form :button-text="pageTitle" v-loading="loading" v-if="adminGroup"
                      :admin-group="adminGroup" :all-acl="allAcl"></admin-group-form>
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
    }
  }
</script>

