<template>
  <div id="app">
    <login-modal :isVisible="loginModalVisible"></login-modal>
    <transition name="el-fade-in-linear">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
  import LoginModal from '@admin/components/LoginModal'

  export default {
    name: 'App',
    components: { LoginModal },
    computed: {
      loginModalVisible() {
        return this.$store.state.auth.loginModal
      }
    },
    mounted() {
      document.body.classList.add('bp')
    }
  }
</script>

<style lang="scss">
  body {
    padding: 0;
    margin: 0 !important;
    color: #647279;
  }

  .bp {
    .el-dropdown-menu {
      border-radius: 2px;
      padding: 0;
      box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);

      .anticon {
        font-size: 12px;
      }
    }

    .el-dropdown-menu__item {
      line-height: 39px;
      height: 39px;
      font-size: 13px;
    }

    .el-dropdown-menu__item--divided {
      margin-top: 0;
      border-top: 1px solid #f2f2f2;
    }

    .el-dropdown-menu__item--divided::before {
      height: 0;
    }

    .el-popper[x-placement^=bottom] {
      margin-top: 0;
    }

    .el-popper .popper__arrow {
      display: none;
    }
  }
</style>
