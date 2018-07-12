<template>
  <el-table :stripe="true" :data="adminGroups">
    <el-table-column
      prop="id"
      label="Id"
      width="180">
    </el-table-column>
    <el-table-column
      prop="name"
      label="名称"
      width="180">
    </el-table-column>
  </el-table>
</template>

<script>
  export default {
    meta: {
      title: '管理组'
    },
    data() {
      return {
        adminGroups: []
      }
    },
    mounted() {
      this.$http.get('admin-groups').then((response) => {
        this.adminGroups = response.data.items
      }).catch(() => {
      })
    }
  }
</script>
