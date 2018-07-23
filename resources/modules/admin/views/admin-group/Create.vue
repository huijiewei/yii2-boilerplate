<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <admin-group-form v-if="adminGroup"
                      :submit-text="pageTitle"
                      :admin-group="adminGroup"
                      :all-acl="allAcl"
                      @on-submit="createAdminGroup">
    </admin-group-form>
  </div>
</template>

<script>
  import AdminGroupForm from '@admin/views/admin-group/_EditForm'
  import AdminGroupService from '@admin/services/AdminGroupService'
  import flatry from '@admin/utils/flatry'

  export default {
    components: { AdminGroupForm },
    data() {
      return {
        pageTitle: '新建管理组',
        adminGroup: null,
        allAcl: []
      }
    },
    async created() {
      const { data } = await flatry(AdminGroupService.create())

      if (data) {
        this.adminGroup = data.adminGroup
        this.allAcl = data.allAcl
      }
    },
    methods: {
      async createAdminGroup(adminGroup, success, callback) {
        const { data } = await flatry(AdminGroupService.create(adminGroup))

        if (data) {
          this.$message.success(data.message)
          this.$router.replace({ path: '/admin-group/edit', query: { id: data.adminGroupId } })

          success()
        }

        callback()
      }
    }
  }
</script>

