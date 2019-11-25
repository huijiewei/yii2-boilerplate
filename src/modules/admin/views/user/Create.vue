<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <user-form
      v-if="user"
      :submit-text="pageTitle"
      :user="user"
      @on-submit="createUser"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'
import UserForm from '@admin/views/user/_EditForm'
import UserService from '@admin/services/UserService'

export default {
  components: { UserForm, PlaceholderForm },
  data() {
    return {
      pageTitle: '新建会员',
      user: null
    }
  },
  created() {
    this.user = {}
  },
  methods: {
    async createUser(user, done, fail, always) {
      const { data, error } = await flatry(UserService.create(user))

      if (data) {
        done()

        this.$message.success(data.message)

        await this.$router.push({ path: '/user/index' })
      }

      if (error) {
        fail(error)
      }

      always()
    }
  }
}
</script>
