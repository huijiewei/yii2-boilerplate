<template>
  <div id="app">
    <router-view></router-view>
    <login-modal v-if="loginModalShowed"></login-modal>
  </div>
</template>

<script>
import LoginModal from '@admin/components/LoginModal'

let lastErrorMessage = ''
let lastLoginAction = ''

export default {
  name: 'App',
  components: { LoginModal },
  storeSubscribe: null,
  spinnerTimeout: null,
  computed: {
    loginModalShowed: function () {
      return !this.isLogin
    },
  },
  beforeCreate() {
    this.$store.dispatch('auth/init')
    this.$store.dispatch('tabs/init')
  },
  data() {
    return {
      isLogin: true,
    }
  },
  methods: {
    showLoginModal(action) {
      if (lastLoginAction === action) {
        return
      }

      lastLoginAction = action

      if (action === 'modal') {
        this.isLogin = false
        return
      }

      this.isLogin = true

      if (action === 'direct') {
        const router = this.$router
        const loginUrl = '/login'

        this.$message({
          message: '需要登录才能访问',
          type: 'warning',
          duration: 2000,
        })

        if (router.currentRoute.path === loginUrl) {
          router.replace(router.currentRoute.fullPath)
        } else {
          router.replace({
            path: loginUrl,
            query: { direct: router.currentRoute.fullPath },
          })
        }
      }
    },
    showErrorMessage(error) {
      if (error.message.length > 0 && error.message !== lastErrorMessage) {
        lastErrorMessage = error.message

        const currentPath = this.$router.currentRoute.path
        const isHome = currentPath === '/' || currentPath === '/home'

        this.$alert(error.message, {
          center: true,
          confirmButtonText: error.historyBack ? '返回' : '确定',
          type: 'warning',
          showClose: false,
          callback: () => {
            lastErrorMessage = ''
            this.$store.dispatch('clearError')

            if (error.historyBack === true && !isHome) {
              this.historyBack(null, false, true)
            }
          },
        })
      }
    },
    async historyBack(route = null, force = false, closeTab = false) {
      if (closeTab) {
        const next = await this.$store.dispatch('tabs/close', {
          name: this.$route.name,
          path: this.$route.path,
        })

        this.routerBack(route ? route : next, force)
      } else {
        this.routerBack(route, force)
      }
    },
    routerBack(route = null, force = false) {
      if ((!force || route === null) && this.$routerHistory.hasPrevious()) {
        this.$router.replace(this.$routerHistory.previous())
      } else {
        if (route == null) {
          route = { path: '/home' }
        } else if (typeof route === 'string') {
          route = { path: route }
        }

        this.$router.replace(route)
      }
    },
  },
  provide() {
    return {
      historyBack: this.historyBack,
    }
  },
  mounted() {
    document.body.classList.add('ag')

    this.spinnerTimeout = setTimeout(() => {
      const spinner = document.getElementById('spinner')

      if (spinner) {
        spinner.remove()
      }
    }, 500)

    this.storeSubscribe = this.$store.subscribe((mutation) => {
      if (mutation.type === 'TOGGLE_ERROR') {
        this.showErrorMessage(mutation.payload)
      }

      if (mutation.type === 'auth/TOGGLE_LOGIN_ACTION') {
        this.showLoginModal(mutation.payload)
      }
    })
  },
  destroyed() {
    if (this.spinnerTimeout) {
      clearTimeout(this.spinnerTimeout)
    }

    if (this.storeSubscribe) {
      this.storeSubscribe()
    }
  },
}
</script>

<style lang="scss">
@import '../../core/assets/styles/base.scss';
@import './assets/styles/style.scss';
</style>
