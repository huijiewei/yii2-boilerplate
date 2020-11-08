<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <user-form
      v-if="userAddress"
      :submit-text="pageTitle"
      :user-address="userAddress"
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
  name: 'UserAddressCreate',
  components: { UserForm, PlaceholderForm },
  data() {
    return {
      pageTitle: '用户新建',
      userAddress: null,
    }
  },
  inject: ['historyBack'],
  created() {
    this.userAddress = { phone: '', alias: '', name: '', address: '' }
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
