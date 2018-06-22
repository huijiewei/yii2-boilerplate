<template>
  <div id="app">
    <transition name="el-fade-in-linear">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
  export default {
    name: 'adminApp'
  }
</script>

<style lang="css">
  body {
    padding: 0;
    margin: 0 !important;
    color: #647279;
  }
</style>
