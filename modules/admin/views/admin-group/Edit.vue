<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <admin-group-form
      v-if="adminGroup"
      :submit-text="pageTitle"
      :admin-group="adminGroup"
      :is-edit="true"
      @on-submit="edit"
    />
    <placeholder-form v-else :rows="3" />
  </div>
</template>

<script>
import AdminGroupForm from '@admin/views/admin-group/_EditForm'
import AdminGroupService from '@admin/services/AdminGroupService'
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'AdminGroupEdit',
  components: { PlaceholderForm, AdminGroupForm },
  data() {
    return {
      pageTitle: '编辑管理组',
      adminGroup: null,
    }
  },
  inject: ['historyBack'],
  async created() {
    await this.view(this.$route.params.id)
  },
  methods: {
    async view(id) {
      this.adminGroup = null

      const { data } = await flatry(AdminGroupService.view(id))

      if (data) {
        this.adminGroup = data
      }
    },
    async edit(adminGroup, done, fail, always) {
      const { data, error } = await flatry(AdminGroupService.edit(adminGroup))

      if (data) {
        done()

        this.$message.success('管理组编辑成功')

        await this.$store.dispatch('tabs/deleteCache', 'AdminGroup')
        await this.historyBack('/admin-group', false, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
