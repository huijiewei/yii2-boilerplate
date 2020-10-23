<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <admin-form
      v-if="admin"
      :submit-text="pageTitle"
      :admin="admin"
      @on-submit="createAdmin"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import AdminForm from '@admin/views/admin/_EditForm'
import AdminService from '@admin/services/AdminService'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'AdminCreate',
  components: { PlaceholderForm, AdminForm },
  data() {
    return {
      pageTitle: '新建管理员',
      admin: null,
    }
  },
  inject: ['historyBack'],
  created() {
    this.admin = {
      phone: '',
      email: '',
      name: '',
      avatar: '',
      adminGroup: { id: null },
    }
  },
  methods: {
    async createAdmin(admin, done, fail, always) {
      const { data, error } = await AdminService.create(admin)

      if (data) {
        done()

        this.$message.success('新建管理员成功')

        await this.$store.dispatch('tabs/deleteCache', 'Admin')
        await this.historyBack('/admin', true, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
