<template>
  <div class="ag-tab">
    <div class="tab-left tab-item" @click="handleScroll(220)">
      <i class="el-icon-arrow-left"></i>
    </div>
    <div class="tab-right tab-item" @click="handleScroll(-200)">
      <i class="el-icon-arrow-right"></i>
    </div>
    <div ref="tabScroll" class="tab-scroll" @wheel.prevent="handleWheel">
      <ul
        ref="tabContent"
        class="tab-list"
        :style="{ left: tabContentLeft + 'px' }"
      >
        <li
          v-for="(tab, index) in viewedTabs"
          :ref="'tabs-' + index"
          class="tab-item"
          :class="isActive(tab) ? 'active' : ''"
          :key="tab.path"
          @click="openTab(tab)"
          @contextmenu.prevent="handleContextMenu(tab, $event)"
        >
          <span>{{ tab.parent ? tab.parent.title : tab.title }}</span>
          <i
            v-if="!tab.affix"
            class="el-icon-close el-icon--right"
            @click.stop="closeTab(tab)"
          ></i>
        </li>
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
      v-transform-dom
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
      <li @click="handleCloseOther">
        <i class="el-icon-circle-close"></i>
        关闭其他
      </li>
      <li @click="handleCloseAll">
        <i class="el-icon-error"></i>
        全部关闭
      </li>
    </ul>
  </div>
</template>

<script>
import TransformDom from '@core/directives/TransformDom'

export default {
  name: 'HeaderTab',
  created() {
    this.initTabs()
    this.addTab(this.$route)
    this.moveToCurrentTab()
  },
  directives: {
    transformDom: TransformDom,
  },
  inject: ['reload'],
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
      return this.$store.getters['tabs/getViewed']
    },
    currentTab() {
      return this.$store.getters['tabs/getCurrent']
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
    }
  },
  methods: {
    filterAffixTabs(routes, basePath = '') {
      let tabs = []

      routes.forEach((route) => {
        if (route.meta && route.meta.affix) {
          tabs.push({
            name: route.name,
            path: route.path,
            query: basePath + '/' + route.query,
            title: route.meta.title,
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
      const affixTabs = (this.affixTabs = this.filterAffixTabs(
        this.$router.options.routes
      ))

      for (const tab of affixTabs) {
        this.$store.dispatch('tabs/open', tab)
      }
    },
    moveToCurrentTab() {
      this.$nextTick(() => {
        this.viewedTabs.forEach((tab, index) => {
          if (this.isActive(tab)) {
            const elem = this.$refs['tabs-' + index][0]

            const scrollWidth = this.$refs.tabScroll.offsetWidth
            const contentWidth = this.$refs.tabContent.offsetWidth

            if (contentWidth < scrollWidth) {
              this.tabContentLeft = 0
            } else if (elem.offsetLeft < -this.tabContentLeft) {
              // 标签在可视区域左侧
              this.tabContentLeft = -elem.offsetLeft
            } else if (
              elem.offsetLeft > -this.tabContentLeft &&
              elem.offsetLeft + elem.offsetWidth <
                -this.tabContentLeft + scrollWidth
            ) {
              // 标签在可视区域
              this.tabContentLeft = Math.min(
                0,
                scrollWidth - elem.offsetWidth - elem.offsetLeft
              )
            } else {
              // 标签在可视区域右侧
              this.tabContentLeft = -(
                elem.offsetLeft -
                (scrollWidth - elem.offsetWidth)
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
    handleTabRefresh() {
      this.reload()
    },
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
        name: route.name,
        path: route.path,
        query: route.query,
        title: route.meta.title,
        affix: route.meta && route.meta.affix,
        parent: route.meta && route.meta.parent,
      }

      this.$store.dispatch('tabs/open', tab)
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
    },
    handleCloseOther() {
      const tab = this.contextMenuTab ? this.contextMenuTab : this.currentTab

      this.$store.dispatch('tabs/closeOther', tab)

      this.openTab(tab)
    },
    async handleCloseAll() {
      const next = await this.$store.dispatch('tabs/closeAll')

      if (next !== null) {
        this.openTab(next)
      }
    },
    openTab(tab) {
      this.$store.dispatch('tabs/current', tab)

      this.$router.push({
        path: tab.path,
        query: tab.query,
      })
    },
    async closeTab(tab) {
      const next = await this.$store.dispatch('tabs/close', tab)

      if (this.isActive(tab)) {
        this.openTab(next)
      }
    },
  },
}
</script>

<style lang="less">
.context-menu {
  position: absolute;
  margin: 0;
  background: #fff;
  z-index: 2003;
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

.ag-tab {
  font-size: 13px;
  background-color: #f4f8fb;
  padding: 7px 16px;
  height: 27px;
  user-select: none;
  position: relative;

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

    .tab-item {
      cursor: pointer;
      border: none;
      color: #6f727d;
      display: inline-block;

      &:hover {
        color: #409eff;
      }

      &.active {
        background: #3a8ee6;
        color: #ffffff;

        &:hover {
          span {
            color: #ebeef5;
          }
        }

        i {
          border-radius: 50%;

          &:hover {
            background-color: #3a98f0;
          }
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
</style>
