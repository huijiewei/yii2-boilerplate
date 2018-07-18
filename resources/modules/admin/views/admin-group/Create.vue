<template>
  <div class="box" v-if="adminGroup">
    <admin-group-form :button-text="pageTitle" v-loading="loading"
                      :admin-group="adminGroup" :all-acl="allAcl"
                      @on-success="onSuccess"></admin-group-form>
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
        pageTitle: '新建管理组',
        adminGroup: null,
        allAcl: []
      }
    },
    created() {
      this.$http.get('admin-group/create').then(response => {
        this.adminGroup = response.data.adminGroup
        this.allAcl = response.data.allAcl
      }).catch(() => {
      }).finally(() => {
        this.loading = false
      })
    },
    methods: {
      onSuccess(data) {
        this.$router.replace({ name: 'admin-group-edit', query: { id: data.adminGroupId } })
      }
    }
  }
</script>

