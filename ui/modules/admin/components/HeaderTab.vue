<template>
  <div class="ag-tab">
    <div class="tab-left tab-item" @click="handleScroll(220)">
      <i class="el-icon-arrow-left"></i>
    </div>
    <div class="tab-right tab-item" @click="handleScroll(-200)">
      <i class="el-icon-arrow-right"></i>
    </div>
    <div ref="tabScroll" class="tab-scroll" @wheel.prevent="handleWheel">
      <ul ref="tabList" class="tab-list" :style="{ left: tabBodyLeft + 'px' }">
        <template v-for="tab in viewedTabs">
          <li
            class="tab-item"
            :class="isActive(tab) ? 'active' : ''"
            v-bind:key="tab.path"
            @click="handleClick(tab)"
            @contextmenu.prevent="handleContextMenu(tab, $event)"
          >
            <span>{{ tab.title }}</span>
            <i
              v-if="!tab.affix"
              class="el-icon-close el-icon--right"
              @click.stop="handleClose(tab)"
            ></i>
          </li>
        </template>
      </ul>
    </div>
    <div
      class="tab-close tab-item"
      @click.stop="handleContextMenu('CLOSED', $event)"
      @contextmenu.prevent="handleContextMenu('CLOSED', $event)"
    >
      <i class="el-icon-arrow-down"></i>
    </div>
    <ul
      ref="contextMenu"
      :style="{ left: contextMenuLeft + 'px', top: contextMenuTop + 'px' }"
      v-show="contextMenuShow"
      class="context-menu"
    >
      <li v-if="selectedTab" @click="handleTabRefresh">
        <i class="el-icon-refresh-right"></i>
        刷新页面
      </li>
      <li v-if="selectedTab" @click="handleTabClose">
        <i class="el-icon-close"></i>
        关闭页面
      </li>
      <li>
        <i class="el-icon-back"></i>
        关闭左侧
      </li>
      <li>
        <i class="el-icon-right"></i>
        关闭右侧
      </li>
      <li @click="handleCloseOther">
        <i class="el-icon-circle-close"></i>
        关闭其他
      </li>
      <li>
        <i class="el-icon-error"></i>
        全部关闭
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'HeaderTab',
  created() {
    this.addTab()
  },
  watch: {
    $route() {
      this.addTab()
    },
    contextMenuShow(show) {
      if (show) {
        document.body.addEventListener('click', this.closeContextMenu)
      } else {
        document.body.removeEventListener('click', this.closeContextMenu)
      }
    },
  },
  computed: {
    viewedTabs() {
      return this.$store.state.tabs.viewed
    },
  },
  data() {
    return {
      tabBodyLeft: 0,
      contextMenuShow: false,
      contextMenuLeft: 0,
      contextMenuTop: 0,
      selectedTab: null,
    }
  },
  methods: {
    handleTabClose() {
      if (this.selectedTab) {
        this.closeTab(this.selectedTab)
      }
    },
    handleTabRefresh() {},
    handleContextMenu(tab, event) {
      const max =
        this.$el.offsetWidth + this.$el.getBoundingClientRect().left - 100
      const left = event.clientX

      this.contextMenuLeft = left > max ? max : left
      this.contextMenuTop = event.clientY + 12

      this.selectedTab = tab !== 'CLOSED' ? tab : null

      this.contextMenuShow = true
    },
    closeContextMenu() {
      this.contextMenuShow = false
    },
    addTab() {
      let routeTitle = '无标题'

      const route = this.$route

      for (let i = route.matched.length - 1; i >= 0; i--) {
        const breadcrumb = route.matched[i].meta.breadcrumb

        if (breadcrumb && breadcrumb.title && breadcrumb.title.length > 0) {
          routeTitle = breadcrumb.title
          break
        }
      }

      this.$store.dispatch('tabs/addViewedTab', {
        path: route.path,
        query: route.query,
        title: routeTitle,
        affix: route.meta && route.meta.affix,
      })
    },
    isActive(tab) {
      return tab.path === this.$route.path
    },
    handleWheel(e) {
      const delta = e.wheelDelta ? e.wheelDelta : -(e.detail || 0) * 30

      this.handleScroll(delta)
    },
    handleScroll(delta) {
      const scrollWidth = this.$refs.tabScroll.offsetWidth
      const listWidth = this.$refs.tabList.offsetWidth

      if (delta > 0) {
        this.tabBodyLeft = Math.min(0, this.tabBodyLeft + delta)
      } else {
        if (scrollWidth < listWidth) {
          if (this.tabBodyLeft >= -(listWidth - scrollWidth)) {
            this.tabBodyLeft = Math.max(
              this.tabBodyLeft + delta,
              scrollWidth - listWidth
            )
          }
        } else {
          this.tabBodyLeft = 0
        }
      }
    },
    handleClick(tab) {
      this.$router.push({
        path: tab.path,
        query: tab.query,
      })
    },
    handleClose(tab) {
      this.closeTab(tab)
    },
    handleCloseOther() {},
    closeTab(tab) {
      this.$store.dispatch('tabs/delViewedTab', tab).then((next) => {
        if (this.isActive(tab)) {
          if (next !== null) {
            this.$router.push({
              path: next.path,
              query: next.query,
            })
          }
        }
      })
    },
  },
}
</script>

<style lang="scss">
.ag-tab {
  font-size: 13px;
  background-color: #f4f8fb;
  padding: 7px 16px;
  height: 27px;
  user-select: none;
  position: relative;

  .context-menu {
    position: fixed;
    margin: 0;
    background: #fff;
    z-index: 1000;
    list-style-type: none;
    padding: 0;
    border-radius: 2px;
    box-shadow: 2px 2px 3px 0 rgba(0, 0, 0, 0.3);

    li {
      margin: 0;
      padding: 7px 15px 7px 13px;
      font-size: 12px;
      cursor: pointer;
      &:hover {
        background: #ecf5ff;
        color: #3a8ee6;
      }
    }
  }

  .tab-scroll {
    overflow-x: hidden;
    white-space: nowrap;
    position: absolute;
    left: 32px;
    right: 64px;
    top: 0;
    bottom: 0;
    padding: 7px 0;
  }

  .tab-list {
    position: absolute;
    list-style: none;
    margin: 0;
    padding: 0;
    transition: left 0.5s;

    li {
      display: inline-block;
      cursor: pointer;

      &.active {
        background: #3a8ee6;
        color: #ffffff;

        &:hover {
          span {
            color: #ebeef5;
          }
        }

        i {
          &:hover {
            background-color: #3a98f0;
          }
        }
      }

      &:hover {
        span {
          color: #3a8ee6;
        }
      }

      i {
        &:hover {
          background-color: #f4f8fb;
        }
      }

      &:not(:first-child) {
        margin-left: 6px;
      }
    }
  }

  .tab-item {
    padding: 5px 9px;
    background-color: #ffffff;
    border-radius: 2px;
  }

  .tab-left,
  .tab-right,
  .tab-close {
    position: absolute;
    cursor: pointer;
    [class^='el-icon-'] {
      font-weight: bolder;
    }
  }

  .tab-left,
  .tab-right {
    background-color: #f4f8fb;
  }

  .tab-left {
    left: 0;
  }

  .tab-right {
    right: 32px;
  }

  .tab-close {
    right: 0;
    background-color: #ffffff;
    &.el-dropdown {
      font-size: 13px;
    }
  }
}

.tags-nav-menu {
  .el-dropdown-menu__item {
    font-size: 13px;
    padding: 0 20px 0 15px;
  }
}
</style>
