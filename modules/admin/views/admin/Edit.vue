<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}{{ name }}</h4>
    </div>
    <admin-form
      v-if="admin"
      :submit-text="pageTitle"
      :admin="admin"
      :is-edit="true"
      @on-submit="editAdmin"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import AdminForm from '@admin/views/admin/_EditForm'
import AdminService from '@admin/services/AdminService'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'AdminEdit',
  components: { PlaceholderForm, AdminForm },
  props: {
    name: String,
  },
  data() {
    return {
      pageTitle: '编辑管理员',
      admin: null,
    }
  },
  inject: ['historyBack'],
  async created() {
    const { data } = await AdminService.view(this.$route.params.id)

    if (data) {
      this.admin = data
    }
  },
  methods: {
    async editAdmin(admin, done, fail, always) {
      const { data, error } = await AdminService.edit(admin)

      if (data) {
        done()

        this.$message.success('管理员编辑成功')

        await this.$store.dispatch('tabs/deleteCache', 'Admin')
        await this.historyBack('/admin', false, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
