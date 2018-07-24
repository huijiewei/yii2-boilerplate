<template>
  <div class="box">
    {{message}}, 你好
  </div>
</template>

<script>
  export default {
    metaInfo: {
      title: '首页'
    },
    data() {
      return {
        message: ''
      }
    },
    created() {
      this.$http.get('site/index').then((data) => {
        this.message = data.message
      }).catch(() => {
      })
    }
  }
</script>
