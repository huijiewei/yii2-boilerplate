<template>
  <admin-group-form :page-title="'新建管理组'"
                    :api-url="'admin-group/create'" :api-params="{}"></admin-group-form>
</template>

<script>
  import AdminGroupForm from '@admin/views/admin-group/_EditForm'

  export default {
    components: { AdminGroupForm }
  }
</script>

