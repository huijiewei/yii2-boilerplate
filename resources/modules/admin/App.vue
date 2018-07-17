<template>
  <div id="app">
    <login-modal v-if="loginModalVisible" :visible="true"></login-modal>
    <transition name="el-fade-in-linear">
      <router-view></router-view>
    </transition>
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
    components: { LoginModal },
    computed: {
      loginModalVisible() {
        return this.$store.state.auth.loginModal
      }
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
