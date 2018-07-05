<template>
  <div id="app">
    <p>
      <router-link to="/">Home</router-link>
      <router-link to="/about">About</router-link>
      <router-link to="/auth/login">Login</router-link>
    </p>
    <router-view></router-view>
  </div>
</template>

<script>
  export default {
    name: 'App'
  }
</script>

<style lang="css">
  body {
    padding: 0;
    margin: 0 !important;
    color: #647279;
  }
</style>
