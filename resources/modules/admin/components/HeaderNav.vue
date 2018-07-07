<template>
  <nav class="bp-nav">
    <div class="bp-logo" :style="{ width: isCollapsed ? '60px' : '210px'}">
      <router-link to="/">
        <img alt="主页" src="../assets/images/logo.png"><img alt="Boilerplate" src="../assets/images/banner.png">
      </router-link>
    </div>
    <i :class="['anticon','trigger',isCollapsed ? 'anticon-menu-unfold':'anticon-menu-fold']"
       @click="toggleSideMenu"></i>
  </nav>
</template>

<script>
  export default {
    name: 'HeaderNav',
    props: ['isCollapsed'],
    methods: {
      toggleSideMenu() {
        this.$store.dispatch('toggleSideMenu').then()
      }
    }
  }
</script>

<style lang="scss">
  .bp-nav {
    i.trigger {
      font-size: 19px;
      line-height: 49px;
      cursor: pointer;
      transition: all 0.3s, padding 0s;
      padding: 0 15px;

      &:hover {
        background: #e6f7ff;
      }
    }

    .bp-logo {
      text-align: center;
      overflow: hidden;
      height: 50px;
      line-height: 50px;
      float: left;
      transition: width 0.2s;

      a {
        text-decoration: none;
      }

      img {
        vertical-align: middle;
        height: 39px;
        display: inline-block;
      }
    }
  }
</style>
