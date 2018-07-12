<template>
  <div>
    <div>{{message}}</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
    <div>siteIndex</div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        message: ''
      }
    },
    mounted() {
      this.$http.get('site/index')
        .then((response) => {
          this.message = response.data.message
        })
        .catch(() => {
        })
    }
  }
</script>
