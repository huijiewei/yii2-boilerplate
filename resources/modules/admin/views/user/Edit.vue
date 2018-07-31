<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <user-form v-if="user"
               :submit-text="pageTitle"
               :user="user"
               :is-edit="true"
               @on-submit="editUser">
    </user-form>
    <placeholder-form v-else></placeholder-form>
  </div>
</template>

<script>
  import flatry from '@admin/utils/flatry'
  import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'
  import UserForm from '@admin/views/user/_EditForm'
  import UserService from '@admin/services/UserService'

  export default {
    components: { UserForm, PlaceholderForm },
    data() {
      return {
        pageTitle: '编辑会员',
        user: null
      }
    },
    async created() {
      const { data } = await flatry(UserService.edit(this.getUserId))

      if (data) {
        this.user = data
      }
    },
    computed: {
      getUserId() {
        return this.$router.currentRoute.query.id
      }
    },
    methods: {
      async editUser(user, success, callback) {
        const { data } = await flatry(UserService.edit(this.getUserId, user))

        if (data) {
          this.$message.success(data.message)
          success()
        }

        callback()
      }
    }
  }
</script>

