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
    <placeholder-form v-else :rows="3" />
  </div>
</template>

<script>
import AdminGroupForm from '@admin/views/admin-group/_EditForm'
import AdminGroupService from '@admin/services/AdminGroupService'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'AdminGroupCreate',
  components: { PlaceholderForm, AdminGroupForm },
  data() {
    return {
      pageTitle: '新建管理组',
      adminGroup: null,
    }
  },
  created() {
    this.adminGroup = {
      name: '',
      permissions: [],
    }
  },
  inject: ['historyBack'],
  methods: {
    async createAdminGroup(adminGroup, done, fail, always) {
      const { data, error } = await AdminGroupService.create(adminGroup)

      if (data) {
        done()

        this.$message.success('新建管理组成功')

        await this.$store.dispatch('tabs/deleteCache', 'AdminGroup')
        await this.historyBack('/admin-group', true, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
