<template>
  <div class="box">
    <div class="box-header">
      <h4>管理组</h4>
    </div>
  </div>
</template>

<script>
  import BpIcon from '@core/components/Icon'

  export default {
    components: { BpIcon },
    meta: {
      title: '管理组'
    },
    data() {
      return {
        adminGroup: []
      }
    },
    methods: {
      handleRoute(action) {
        this.$router.push(action)
      },
      handleDelete(index, row) {
        console.log(index, row)
      },
      fetchData() {

      }
    },
    created() {
      this.$http.get('admin-group/view', { id: this.$route.query.id }).then((response) => {
        this.adminGroup = response.data
      }).catch(() => {
      })
    }
  }
</script>
