<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <admin-group-form
      v-if="adminGroup"
      :submit-text="pageTitle"
      :admin-group="adminGroup"
      @on-submit="createAdminGroup"
    />
    <placeholder-form
      v-else
      :rows="3"
    />
  </div>
</template>

<script>
import AdminGroupForm from '@admin/views/admin-group/_EditForm'
import AdminGroupService from '@admin/services/AdminGroupService'
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  components: { PlaceholderForm, AdminGroupForm },
  data () {
    return {
      pageTitle: '新建管理组',
      adminGroup: null
    }
  },
  async created () {
    const { data } = await flatry(AdminGroupService.create())

    if (data) {
      this.adminGroup = data
    }
  },
  methods: {
    async createAdminGroup (adminGroup, success, callback) {
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
