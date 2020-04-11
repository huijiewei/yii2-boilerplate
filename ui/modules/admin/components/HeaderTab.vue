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
          >
            <span>{{ tab.title }}</span>
            <i
              class="el-icon-close el-icon--right"
              @click.stop="handleClose(tab)"
            ></i>
          </li>
        </template>
      </ul>
    </div>
    <el-dropdown class="tab-close tab-item">
      <span>
        <i class="el-icon-arrow-down"></i>
      </span>
      <el-dropdown-menu class="tags-nav-menu" slot="dropdown">
        <el-dropdown-item>
          <i class="el-icon-back"></i>
          关闭左侧
        </el-dropdown-item>
        <el-dropdown-item>
          <i class="el-icon-right"></i>
          关闭右侧
        </el-dropdown-item>
        <el-dropdown-item>
          <i class="el-icon-circle-close"></i>
          关闭其他
        </el-dropdown-item>
        <el-dropdown-item>
          <i class="el-icon-error"></i>
          全部关闭
        </el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
  </div>
</template>

<script>
export default {
  name: 'HeaderTab',
  mounted() {
    this.addTab()
  },
  watch: {
    $route() {
      this.addTab()
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
    }
  },
  methods: {
    addTab() {
      const hasTitleRoute = this.$route.matched.reverse().find((route) => {
        const breadcrumb = route.meta.breadcrumb

        return breadcrumb && breadcrumb.title && breadcrumb.title.length > 0
      })

      this.$store.dispatch('tabs/addViewedTab', {
        path: this.$route.path,
        query: this.$route.query,
        title: hasTitleRoute ? hasTitleRoute.meta.breadcrumb.title : '无标题',
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

      &:first-child {
        i {
          display: none;
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
