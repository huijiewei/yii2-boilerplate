<template>
  <div id="app">
    <login-modal v-if="loginModalVisible" :visible="true"></login-modal>
    <router-view></router-view>
  </div>
</template>

<script>
  import LoginModal from '@admin/components/LoginModal'

  const currentTitle = document.title

  export default {
    name: 'App',
    metaInfo: {
      title: null,
      titleTemplate: (titleChunk) => {
        return titleChunk ? `${titleChunk} - ${currentTitle}` : currentTitle
      },
      bodyAttrs: {
        class: 'bp'
      }
    },
    timeoutId: null,
    components: { LoginModal },
    computed: {
      loginModalVisible() {
        return this.$store.state.auth.loginModal
      }
    },
    mounted() {
      this.timeoutId = setTimeout(
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
      if (this.timeoutId) {
        clearTimeout(this.timeoutId)
      }
    }
  }
</script>

<style lang="scss">
  body {
    color: #647279;
  }
</style>
