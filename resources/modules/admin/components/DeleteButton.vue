<template>
  <el-button :loading="loading" :title="title" :size="size" :type="type" :plain="plain" @click="handleDelete">
    <slot></slot>
  </el-button>
</template>

<script>
  export default {
    name: 'DeleteButton',
    props: ['apiUrl', 'apiParams', 'title', 'size', 'type', 'plain', 'confirm'],
    data() {
      return {
        loading: false
      }
    },
    methods: {
      handleDelete() {
        this.$confirm(this.confirm, {
          showClose: false,
          confirmButtonText: '删除',
          confirmButtonClass: 'el-button--danger',
          cancelButtonText: '取消',
          type: 'error'
        }).then(() => {
          this.loading = true
          this.$http.delete(this.apiUrl, this.apiParams).then(response => {
            this.loading = false
            this.$emit('on-success')
            this.$message({
              type: 'success',
              message: response.data.message
            })
          }).catch(() => {

          })
        }).catch(() => {
        })
      }
    }
  }
</script>
