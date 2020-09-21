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
      @on-submit="updateProfile"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import AdminForm from '@admin/views/admin/_EditForm'
import AuthService from '@admin/services/AuthService'
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  components: { PlaceholderForm, AdminForm },
  data() {
    return {
      pageTitle: '编辑个人资料',
      admin: null,
    }
  },
  async activated() {
    const { data } = await flatry(AuthService.profile())

    if (data) {
      this.admin = data
    }
  },
  methods: {
    async updateProfile(admin, done, fail, always) {
      const { data, error } = await flatry(AuthService.profile(admin))

      if (data) {
        done()
        this.$message.success('个人资料编辑成功')

        const { data } = await flatry(AuthService.account())

        if (data) {
          await this.$store.dispatch('auth/account', data)
        }
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
