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
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  components: { PlaceholderForm, AdminForm },
  data () {
    return {
      pageTitle: '新建管理员',
      admin: null
    }
  },
  created () {
    this.admin = { adminGroup: { id: null } }
  },
  methods: {
    async createAdmin (admin, done, fail, always) {
      const { data, error } = await flatry(AdminService.create(admin))

      if (data) {
        this.$message.success('新建管理员成功')
        done()

        await this.$router.replace({ path: '/admin' })
      }

      if (error) {
        fail(error)
      }

      always()
    }
  }
}
</script>
