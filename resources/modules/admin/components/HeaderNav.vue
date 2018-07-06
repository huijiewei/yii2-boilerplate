<template>
  <nav>
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
        this.$store.dispatch('toggleSideMenu')
      }
    }
  }
</script>

<style lang="scss">
  .bp-layout {
    .el-header {
      width: 100%;
      padding: 0 0 20px 0;
      border-bottom: 1px solid #e4e9f0;

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
    }
  }

  .bp-logo {
    text-align: center;
    overflow: hidden;
    float: left;
    transition: width 0.2s;
  }

  .bp-logo a {
    text-decoration: none;
  }

  .bp-logo strong {
    display: inline-block;
  }

  .bp-logo img {
    vertical-align: middle;
    height: 50px;
    display: inline-block;
  }
</style>
