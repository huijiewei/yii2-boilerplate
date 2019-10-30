<template>
  <div id="app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  spinnerTimeoutId: 0,
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
</style>
