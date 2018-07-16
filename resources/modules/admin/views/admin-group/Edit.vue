<template>
  <admin-group-form :page-title="'编辑管理组'"
                    :api-url="'admin-group/edit'" :api-params="{id: $router.currentRoute.query.id }"></admin-group-form>
</template>

<script>
  import AdminGroupForm from '@admin/views/admin-group/_EditForm'

  export default {
    components: { AdminGroupForm }
  }
</script>

