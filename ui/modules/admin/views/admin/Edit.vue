<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
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
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  components: { PlaceholderForm, AdminForm },
  data() {
    return {
      pageTitle: '编辑管理员',
      admin: null,
    }
  },
  async created() {
    const { data } = await flatry(
      AdminService.view(this.$router.currentRoute.query.id)
    )

    if (data) {
      this.admin = data
    }
  },
  methods: {
    async editAdmin(admin, done, fail, always) {
      const { data, error } = await flatry(AdminService.edit(admin))

      if (data) {
        done()

        this.$message.success('管理员编辑成功')
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
