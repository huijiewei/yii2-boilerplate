<template>
  <div class="box">
    <admin-group-form :button-text="pageTitle"
                      :api-url="'admin-group/edit'"
                      :api-params="{id: getAdminGroupId }"></admin-group-form>
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
        pageTitle: '编辑管理组'
      }
    },
    computed: {
      getAdminGroupId() {
        return this.$router.currentRoute.query.id
      }
    }
  }
</script>

