<template>
  <el-card shadow="never">
    <div slot="header">{{ pageTitle }}</div>
    <admin-form v-if="admin"
                :button-text="pageTitle"
                :admin="admin"
                :all-group="allGroup"
                :is-edit="true"
                @on-submit="formSubmit">
    </admin-form>
  </el-card>
</template>

<script>
  import AdminForm from '@admin/views/admin/_EditForm'

  export default {
    components: { AdminForm },
    data() {
      return {
        loading: true,
        pageTitle: '编辑管理员',
        admin: null,
        allGroup: []
      }
    },
    created() {
      this.$http.get('admin/edit', { id: this.getAdminId }).then(data => {
        this.admin = data.admin
        this.allGroup = data.allGroup
      }).catch(() => {

      })
    },
    computed: {
      getAdminId() {
        return this.$router.currentRoute.query.id
      }
    },
    methods: {
      formSubmit(adminGroup) {
        return this.$http.put('admin/edit', adminGroup, { id: this.getAdminId }).then(data => {
          this.$message.success(data.message)
        }).catch(() => {
        })
      }
    }
  }
</script>

