<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <admin-form v-if="admin"
                :submit-text="pageTitle"
                :admin="admin"
                :all-group="allGroup"
                @on-submit="createAdmin">
    </admin-form>
  </div>
</template>

<script>
  import AdminForm from '@admin/views/admin/_EditForm'
  import AdminService from '@admin/services/AdminService'
  import flatry from '@admin/utils/flatry'

  export default {
    components: { AdminForm },
    data() {
      return {
        pageTitle: '新建管理员',
        admin: null,
        allGroup: []
      }
    },
    async created() {
      const { data } = await flatry(AdminService.create())

      if (data) {
        this.admin = data.admin
        this.allGroup = data.allGroup
      }
    },
    methods: {
      async createAdmin(admin, success, callback) {
        const { data } = await flatry(AdminService.create(admin))

        if (data) {
          this.$message.success(data.message)
          this.$router.replace({ path: '/admin/edit', query: { id: data.adminId } })

          success()
        }

        callback()
      }
    }
  }
</script>

