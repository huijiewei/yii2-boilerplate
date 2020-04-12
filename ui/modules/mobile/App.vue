<template>
  <div id="app">
    <router-view />
    <div v-if="isShow">SHOW TEXT</div>
  </div>
</template>

<script>
export default {
  name: 'App',
  spinnerTimeout: null,
  mounted() {
    this.spinnerTimeout = setTimeout(() => {
      const spinner = document.getElementById('spinner')

      if (spinner) {
        spinner.remove()
      }
    }, 900)
  },
  computed: {
    isShow: function () {
      return this.$store.getters['isShow']
    },
  },
  destroyed() {
    if (this.spinnerTimeout) {
      clearTimeout(this.spinnerTimeout)
    }
  },
}
</script>

<style lang="scss">
@import '../../core/assets/styles/base.scss';
</style>
