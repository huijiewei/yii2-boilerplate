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

let lastLoginAction = ''
let lastErrorMessage = ''

export default {
  name: 'App',
  spinnerTimeoutId: 0,
  components: { LoginModal },
  computed: {
    isErrorMessageVisible () {
      const self = this
      const error = self.$store.state.error

      if (error.message.length > 0 && error.message !== lastErrorMessage) {
        lastErrorMessage = error.message
        self.$alert(
          error.message,
          {
            center: true,
            confirmButtonText: '确定',
            type: 'warning',
            showClose: false,
            callback: () => {
              lastErrorMessage = ''
              self.$store.dispatch('clearError')

              console.log(self.$router.currentRoute)

              if (error.routeBack === true) {
                self.$router.back()
              }
            }
          }
        )
      }

      return false
    },
    isLoginModalVisible () {
      const action = this.$store.getters['auth/getLoginAction']

      if (lastLoginAction === action) {
        return false
      }

      lastLoginAction = action

      if (action === 'direct') {
        const router = this.$router
        const loginUrl = '/login'

        this.$message({
          message: '需要登录才能访问',
          type: 'warning',
          duration: 2000
        })

        if (router.currentRoute.path === loginUrl) {
          router.replace(router.currentRoute.fullPath)
        } else {
          router.replace({ path: loginUrl, query: { direct: router.currentRoute.fullPath } })
        }
      }

      return action === 'modal'
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
