<template>
  <section :class="['ag-app', isCollapsed ? 'ag-collapsed' : '']">
    <aside class="ag-aside">
      <div class="ag-logo">
        <router-link :to="{ path: '/home' }">
          <img alt="主页" src="../assets/images/logo.png" /><img
            alt="Boilerplate"
            src="../assets/images/banner-white.png"
          />
        </router-link>
      </div>
      <prefect-scrollbar
        :scroll-to="'li.el-menu-item.is-active'"
        :settings="{ suppressScrollX: true }"
        class="ag-scrollbar"
      >
        <sider-menu :is-collapsed="isCollapsed" />
      </prefect-scrollbar>
    </aside>
    <section class="ag-layout">
      <header class="ag-header">
        <header-nav :is-collapsed="isCollapsed" />
        <header-tab></header-tab>
      </header>
      <main class="ag-main">
        <transition name="fade">
          <keep-alive :include="cachedTabs">
            <router-view
              :key="
                $route.meta && $route.meta.parent
                  ? $route.meta.parent.path
                  : $route.path
              "
              v-if="isRouterAlive"
            />
          </keep-alive>
        </transition>
      </main>
    </section>
  </section>
</template>

<script>
import flatry from '@core/utils/flatry'
import PrefectScrollbar from '@core/components/PrefectScrollbar/index'
import HeaderNav from '@admin/components/HeaderNav'
import SiderMenu from '@admin/components/SiderMenu'
import AuthService from '@admin/services/AuthService'
import HeaderTab from '@admin/components/HeaderTab'

export default {
  name: 'AdminLayout',
  components: { HeaderTab, PrefectScrollbar, HeaderNav, SiderMenu },
  computed: {
    isCollapsed() {
      return this.$store.getters['isSidebarCollapsed']
    },
    cachedTabs() {
      return this.$store.getters['tabs/getCached']
    },
  },
  async beforeCreate() {
    if (!this.$store.getters['auth/getCurrentUser']) {
      const { data } = await flatry(AuthService.account())

      if (data) {
        await this.$store.dispatch('auth/account', data)
      }
    }
  },
  provide() {
    return {
      reload: this.reload,
    }
  },
  data() {
    return {
      isRouterAlive: true,
    }
  },
  methods: {
    async reload() {
      const cacheNames = [this.$route.name]

      if (this.$route.meta.parent) {
        cacheNames.push(this.$route.meta.parent.name)
      }

      await this.$store.dispatch('tabs/deleteCache', cacheNames)

      this.isRouterAlive = false

      this.$nextTick(() => {
        this.isRouterAlive = true
        this.$store.dispatch('tabs/updateCache', cacheNames)
      })
    },
  },
}
</script>
<style lang="scss">
@import '../../../core/assets/styles/mixin';
$asideWidth: 220px;
$asideCollapsedWidth: 60px;
$asideBackgroundColor: #2c343f;

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter,
.fade-leave-active {
  opacity: 0;
}

.ag-app {
  display: flex;
  flex: auto;
  flex-direction: row;
  background: #f4f8fb;
  min-height: 100vh;

  &.ag-collapsed {
    .ag-aside {
      width: $asideCollapsedWidth;
    }

    .ag-layout {
      margin-left: $asideCollapsedWidth;
    }

    .ag-header {
      width: calc(100% - #{$asideCollapsedWidth});
    }
  }

  .ag-aside {
    position: fixed;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.01);
    top: 0;
    left: 0;
    width: $asideWidth;
    z-index: 10;
    height: 100vh;
    background-color: $asideBackgroundColor;

    .ag-logo {
      text-align: center;
      height: 50px;
      line-height: 50px;

      a {
        text-decoration: none;
      }

      img {
        vertical-align: middle;
        height: 39px;
        display: inline-block;
      }
    }

    .ag-scrollbar {
      height: calc(100vh - 50px);
    }

    .el-menu {
      background-color: $asideBackgroundColor;

      .el-menu-item,
      .el-submenu__title {
        color: #fff;
        &:hover,
        &:focus {
          background-color: #ffd04b;
        }
      }
    }
  }

  .ag-layout {
    position: relative;
    margin-left: $asideWidth;
    display: flex;
    flex: auto;
    flex-direction: column;
    overflow: hidden;
  }

  .ag-header {
    position: fixed;
    width: calc(100% - #{$asideWidth});
    z-index: 10;
    right: 0;
    overflow-x: hidden;

    .ag-nav {
      background: #fff;
      @include clearfix();
      box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.02);
    }
  }

  .ag-main {
    padding: 92px 16px 20px 16px;

    .box {
      background: #fff;
      min-height: calc(100vh - 152px);
      padding: 20px;
      box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.02);

      .box-header {
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
        padding-bottom: 13px;

        h4 {
          font-size: 14px;
          font-weight: normal;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
          margin: 0;
        }
      }
    }
  }
}
</style>
