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
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'
import UserForm from '@admin/views/user/_EditForm'
import UserService from '@admin/services/UserService'

export default {
  name: 'UserCreate',
  components: { UserForm, PlaceholderForm },
  data() {
    return {
      pageTitle: '用户新建',
      user: null,
    }
  },
  inject: ['historyBack'],
  created() {
    this.user = { phone: '', email: '', name: '', avatar: '' }
  },
  methods: {
    async createUser(user, done, fail, always) {
      const { data, error } = await UserService.create(user)

      if (data) {
        done()

        this.$message.success('用户新建成功')

        await this.$store.dispatch('tabs/deleteCache', 'User')
        await this.historyBack('/user', true, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
