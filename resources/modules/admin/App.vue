<template>
  <div id="app">
    <login-modal :isVisible="loginModalVisible"></login-modal>
    <router-view></router-view>
  </div>
</template>

<script>
  import LoginModal from '@admin/components/LoginModal'

  export default {
    name: 'App',
    components: { LoginModal },
    computed: {
      loginModalVisible() {
        return this.$store.state.auth.loginModal
      }
    },
    mounted() {
      document.body.classList.add('bp')
    }
  }
</script>

<style lang="scss">
  body {
    padding: 0;
    margin: 0 !important;
    color: #647279;
  }
</style>
