<template>
  <div id="app">
    <div
      v-if="isErrorMessageVisible"
      id="errorMessage"
    />
    <login-modal
      v-if="isLoginModalVisible"
      :visible="true"
    />
    <router-view />
  </div>
</template>

<script>
import LoginModal from '@admin/components/LoginModal'

export default {
  name: 'App',
  spinnerTimeoutId: 0,
  components: { LoginModal },
  computed: {
    isErrorMessageVisible () {
      const self = this
      const error = self.$store.state.error

      if (error.message.length > 0) {
        self.$alert(
          error.message,
          {
            dangerouslyUseHTMLString: true,
            center: true,
            confirmButtonText: '确定',
            type: 'warning',
            showClose: false,
            callback: () => {
              if (error.routeBack === true) {
                self.$router.back()
              }
            }
          }
        )
      }

      self.$store.dispatch('clearErrorMessage')

      return false
    },
    isLoginModalVisible () {
      const self = this
      const router = self.$router

      const direct = this.$store.getters['auth/getDirectLogin']

      if (direct === 'direct') {
        const loginUrl = '/login'
        if (router.currentRoute.path === loginUrl) {
          router.replace(router.currentRoute.fullPath)
        } else {
          router.replace({ path: loginUrl, query: { direct: router.currentRoute.fullPath } })
        }
      }

      return direct === 'modal'
    }
  },
  beforeCreate () {
    this.$store.dispatch('auth/initClientId')
  },
  mounted () {
    document.body.classList.add('ag')

    this.spinnerTimeoutId = setTimeout(
      () => {
        const spinner = document.getElementById('spinner')

        if (spinner) {
          spinner.remove()
        }
      },
      900
    )
  },
  destroyed () {
    if (this.spinnerTimeoutId > 0) {
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

  @import "../../core/assets/styles/base.scss";
  @import "./assets/styles/style.scss";
</style>
