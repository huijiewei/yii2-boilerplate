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

  .bp-layout {
    .bp-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      padding: 0 0 20px 0;
      background: #fff;
      box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.02);
    }

    .bp-wrap {
      padding-top: 50px;
    }

    .bp-aside {
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.01);
      transition: width 0.2s;
      min-height: calc(100vh - 50px);
    }

    .bp-main {
      background: #f3f3f3;
    }
  }
</style>
