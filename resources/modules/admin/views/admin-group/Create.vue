<template>
  <div class="box">
    <admin-group-form :button-text="pageTitle"
                      :api-url="'admin-group/create'" :api-params="{}"
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
        pageTitle: '新建管理组'
      }
    },
    methods: {
      onSuccess(data) {
        this.$router.replace({ name: 'admin-group-edit', query: { id: data.adminGroupId } })
      }
    }
  }
</script>

