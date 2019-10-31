<template>
  <div id="app">
    <login-modal
      v-if="loginModalVisible"
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
    loginModalVisible () {
      return this.$store.getters['auth/isLoginModalVisible']
    }
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
