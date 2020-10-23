<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <user-form
      v-if="user"
      :submit-text="pageTitle"
      :user="user"
      :is-edit="true"
      @on-submit="editUser"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'
import UserForm from '@admin/views/user/_EditForm'
import UserService from '@admin/services/UserService'

export default {
  name: 'UserEdit',
  components: { UserForm, PlaceholderForm },
  data() {
    return {
      pageTitle: '用户编辑',
      user: null,
    }
  },
  inject: ['historyBack'],
  created() {
    this.getUser(this.$route.params.id)
  },
  methods: {
    async getUser(id) {
      this.user = null

      const { data } = await UserService.view(id)

      if (data) {
        this.user = data
      }
    },
    async editUser(user, done, fail, always) {
      const { data, error } = await UserService.edit(user)

      if (data) {
        done()

        this.$message.success('用户编辑成功')

        await this.$store.dispatch('tabs/deleteCache', 'User')
        await this.historyBack('/user', false, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
