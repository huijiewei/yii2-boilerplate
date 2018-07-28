<template>
  <div id="app">
    <login-modal v-if="loginModalVisible" :visible="true"></login-modal>
    <router-view></router-view>
  </div>
</template>

<script>
  import LoginModal from '@admin/components/LoginModal'

  export default {
    name: 'App',
    spinnerTimeoutId: null,
    components: { LoginModal },
    computed: {
      loginModalVisible() {
        return this.$store.getters['auth/isLoginModalVisible']
      }
    },
    beforeCreate() {
      this.$store.dispatch('auth/initClientId').then()
    },
    mounted() {
      document.body.classList.add('bp')

      this.spinnerTimeoutId = setTimeout(
        () => {
          const spinner = document.getElementById('spinner')

          if (spinner) {
            spinner.remove()
          }
        },
        1000
      )
    },
    destroyed() {
      if (this.spinnerTimeoutId) {
        clearTimeout(this.spinnerTimeoutId)
      }
    }
  }
</script>

<style lang="scss">
  body {
    color: #647279;
    font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif;
  }

  @import "./assets/styles/style.scss";
</style>
