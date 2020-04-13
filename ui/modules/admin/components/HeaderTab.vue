<template>
  <div class="ag-tab">
    <div class="tab-left tab-item" @click="handleScroll(220)">
      <i class="el-icon-arrow-left"></i>
    </div>
    <div class="tab-right tab-item" @click="handleScroll(-200)">
      <i class="el-icon-arrow-right"></i>
    </div>
    <div ref="tabScroll" class="tab-scroll" @wheel.prevent="handleWheel">
      <div
        ref="tabContent"
        class="tab-list"
        :style="{ left: tabContentLeft + 'px' }"
      >
        <el-tag
          ref="tabs"
          :data-tab="tab"
          v-for="(tab, index) in viewedTabs"
          :key="'tab-' + index"
          @click="handleClick(tab)"
          :closable="!tab.affix"
          size="medium"
          @close="closeTab(tab)"
          :effect="isActive(tab) ? 'dark' : 'plain'"
          :disable-transitions="true"
          @contextmenu.prevent="handleContextMenu(tab, $event)"
        >
          {{ tab.title }}
        </el-tag>
      </div>
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
      <li v-if="contextMenuTab" @click="handleTabRefresh">
        <i class="el-icon-refresh-right"></i>
        重载页面
      </li>
      <li
        v-if="contextMenuTab && !contextMenuTab.affix"
        @click="handleTabClose"
      >
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
import path from 'path'

export default {
  name: 'HeaderTab',
  created() {
    this.initTabs()
    this.addTab(this.$route)
    this.moveToCurrentTab()
  },
  watch: {
    $route(to) {
      this.addTab(to)
      this.moveToCurrentTab()
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
      tabContentLeft: 0,
      contextMenuShow: false,
      contextMenuLeft: 0,
      contextMenuTop: 0,
      contextMenuTab: null,
      affixTabs: [],
      currentTab: null,
    }
  },
  methods: {
    getRouteTitle(route) {
      let title = '无标题'

      for (let i = route.matched.length - 1; i >= 0; i--) {
        const breadcrumb = route.matched[i].meta.breadcrumb

        if (breadcrumb && breadcrumb.title && breadcrumb.title.length > 0) {
          title = breadcrumb.title
          break
        }
      }

      return title
    },
    filterAffixTabs(routes, basePath = '/') {
      let tabs = []

      routes.forEach((route) => {
        if (route.meta && route.meta.affix) {
          tabs.push({
            path: path.resolve(basePath, route.path),
            query: route.query,
            title: route.meta.breadcrumb.title,
            affix: true,
          })
        }

        if (route.children) {
          const tab = this.filterAffixTabs(route.children, route.path)

          if (tab.length >= 1) {
            tabs = [...tabs, ...tab]
          }
        }
      })
      return tabs
    },
    initTabs() {
      const affixTabs = (this.affixTags = this.filterAffixTabs(
        this.$router.options.routes
      ))

      for (const tab of affixTabs) {
        this.$store.dispatch('tabs/addViewedTab', tab)
      }
    },
    moveToCurrentTab() {
      this.$nextTick(() => {
        this.$refs.tabs.forEach((tab, index) => {
          if (this.isActive(tab.$attrs['data-tab'])) {
            const tabElem = tab.$el

            const scrollWidth = this.$refs.tabScroll.offsetWidth
            const contentWidth = this.$refs.tabContent.offsetWidth

            if (contentWidth < scrollWidth) {
              this.tabContentLeft = 0
            } else if (tabElem.offsetLeft < -this.tabContentLeft) {
              this.tabContentLeft = -tabElem.offsetLeft + 12
            } else if (
              tabElem.offsetLeft > -this.tabContentLeft &&
              tabElem.offsetLeft + tabElem.offsetWidth <
                -this.tabContentLeft + scrollWidth - 12
            ) {
              this.tabContentLeft = Math.min(
                0,
                scrollWidth - tabElem.offsetWidth - tabElem.offsetLeft - 12
              )
            } else {
              this.tabContentLeft = -(
                tabElem.offsetLeft -
                (scrollWidth - tabElem.offsetWidth) +
                12
              )
            }
          }
        })
      })
    },
    handleTabClose() {
      if (this.contextMenuTab) {
        this.closeTab(this.contextMenuTab)
      }
    },
    handleTabRefresh() {},
    handleContextMenu(tab, event) {
      const max =
        this.$el.offsetWidth + this.$el.getBoundingClientRect().left - 100
      const left = event.clientX

      this.contextMenuLeft = left > max ? max : left
      this.contextMenuTop = event.clientY + 12

      this.contextMenuTab = tab !== 'CLOSED' ? tab : null

      this.contextMenuShow = true
    },
    closeContextMenu() {
      this.contextMenuShow = false
    },
    addTab(route) {
      const tab = {
        path: route.path,
        query: route.query,
        title: this.getRouteTitle(route),
        affix: route.meta && route.meta.affix,
      }

      this.currentTab = tab

      this.$store.dispatch('tabs/addViewedTab', tab)
    },
    isActive(tab) {
      return tab.path === this.currentTab.path
    },
    handleWheel(e) {
      const delta = e.wheelDelta ? e.wheelDelta : -(e.detail || 0) * 30

      this.handleScroll(delta)
    },
    handleScroll(delta) {
      const scrollWidth = this.$refs.tabScroll.offsetWidth
      const contentWidth = this.$refs.tabContent.offsetWidth

      if (delta > 0) {
        this.tabContentLeft = Math.min(0, this.tabContentLeft + delta)
      } else {
        if (scrollWidth < contentWidth) {
          if (this.tabContentLeft >= -(contentWidth - scrollWidth)) {
            this.tabContentLeft = Math.max(
              this.tabContentLeft + delta,
              scrollWidth - contentWidth
            )
          }
        } else {
          this.tabContentLeft = 0
        }
      }

      console.log(this.tabContentLeft)
    },
    handleCloseOther() {},
    handleClick(tab) {
      this.currentTab = tab

      this.$router.push({
        path: tab.path,
        query: tab.query,
      })
    },
    closeTab(tab) {
      this.$store.dispatch('tabs/delViewedTab', tab).then((next) => {
        if (this.isActive(tab)) {
          if (next !== null) {
            this.currentTab = next

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

    .el-tag {
      cursor: pointer;
      border: none;
      font-size: 13px;
      line-height: 28px;
      color: #6f727d;

      &:hover {
        color: #409eff;
      }

      &.el-tag--dark {
        color: #ffffff;

        &:hover {
          color: #ecf5ff;
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
