<template>
  <el-card shadow="never">
    <div slot="header">{{ pageTitle }}</div>
    <admin-group-form v-if="adminGroup"
                      :submit-text="pageTitle"
                      :admin-group="adminGroup"
                      :all-acl="allAcl"
                      :is-edit="true"
                      @on-submit="editAdminGroup">
    </admin-group-form>
  </el-card>
</template>

<script>
  import AdminGroupForm from '@admin/views/admin-group/_EditForm'
  import AdminGroupService from '@admin/services/AdminGroupService'
  import flatry from '@admin/utils/flatry'

  export default {
    components: { AdminGroupForm },
    data() {
      return {
        pageTitle: '编辑管理组',
        adminGroup: null,
        allAcl: []
      }
    },
    async created() {
      const { data } = await flatry(AdminGroupService.edit(this.getAdminGroupId))

      if (data) {
        this.adminGroup = data.adminGroup
        this.allAcl = data.allAcl
      }
    },
    computed: {
      getAdminGroupId() {
        return this.$router.currentRoute.query.id
      }
    },
    methods: {
      async editAdminGroup(adminGroup, success, callback) {
        const { data } = await flatry(AdminGroupService.edit(this.getAdminGroupId, adminGroup))

        if (data) {
          this.$message.success(data.message)

          success()
        }

        callback()
      }
    }
  }
</script>

