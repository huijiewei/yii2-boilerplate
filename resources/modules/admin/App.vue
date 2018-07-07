<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
  export default {
    name: 'App',
    mounted() {
      document.body.classList.add('bp')
    }
  }
</script>

<style lang="css">
  body {
    padding: 0;
    margin: 0 !important;
    color: #647279;
  }
</style>
