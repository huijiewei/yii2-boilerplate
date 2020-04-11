<template>
  <div class="tags-nav">
    <div class="tags-nav-left tags-nav-tab" @click="handleScroll(220)">
      <i class="el-icon-arrow-left"></i>
    </div>
    <div class="tags-nav-right tags-nav-tab" @click="handleScroll(-200)">
      <i class="el-icon-arrow-right"></i>
    </div>
    <div ref="scrollWrap" class="tags-nav-scroll" @wheel.prevent="handleWheel">
      <ul
        ref="scrollBody"
        class="tags-nav-tabs"
        :style="{ left: tagBodyLeft + 'px' }"
      >
        <template v-for="tab in tabs">
          <li
            class="tags-nav-tab"
            v-bind:key="tab"
            @click="handleClickTab(tab)"
          >
            <span>{{ tab }}</span>
            <i
              class="el-icon-close el-icon--right"
              @click.stop="handleCloseTab(tab)"
            ></i>
          </li>
        </template>
      </ul>
    </div>
    <el-dropdown class="tags-nav-tab tags-nav-close">
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
  name: 'TagsNav',
  data() {
    return {
      tagBodyLeft: 0,
      tabs: [
        '测试',
        '测试1',
        '测试2',
        '测试3',
        '测试4',
        '测试5',
        '测试6',
        '测试7',
        '测试8',
        '测试9',
        '测试11',
        '测试12',
        '测试13',
        '测试15',
        '测试14',
        '测试16',
        '测试17',
        '测试18',
        '测试19',
        '测试29',
        '测试22',
        '测试23',
        '测试34',
        '测试32',
        '测试322',
        '测试322s',
      ],
    }
  },
  methods: {
    handleWheel(e) {
      const delta = e.wheelDelta ? e.wheelDelta : -(e.detail || 0) * 30

      this.handleScroll(delta)
    },
    handleScroll(delta) {
      const wrapWidth = this.$refs.scrollWrap.offsetWidth
      const bodyWidth = this.$refs.scrollBody.offsetWidth

      if (delta > 0) {
        this.tagBodyLeft = Math.min(0, this.tagBodyLeft + delta)
      } else {
        if (wrapWidth < bodyWidth) {
          if (this.tagBodyLeft >= -(bodyWidth - wrapWidth)) {
            this.tagBodyLeft = Math.max(
              this.tagBodyLeft + delta,
              wrapWidth - bodyWidth
            )
          }
        } else {
          this.tagBodyLeft = 0
        }
      }
    },
    handleClickTab(tab) {
      console.log('click')
    },
    handleCloseTab(tab) {
      console.log('close')
    },
  },
}
</script>

<style lang="scss">
.tags-nav {
  font-size: 13px;
  background-color: #f4f8fb;
  padding: 7px 16px;
  height: 21px;
  user-select: none;
  position: relative;

  .tags-nav-scroll {
    overflow-x: hidden;
    white-space: nowrap;
    position: absolute;
    left: 32px;
    right: 64px;
    top: 0;
    bottom: 0;
    padding: 7px 0;
  }

  .tags-nav-tabs {
    position: absolute;
    list-style: none;
    margin: 0;
    padding: 0;
    transition: left 0.5s;

    li {
      display: inline-block;
      cursor: pointer;

      &:hover {
        color: #3a8ee6;
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

  .tags-nav-tab {
    padding: 5px 9px;
    background-color: #ffffff;
    border-radius: 2px;
  }

  .tags-nav-left,
  .tags-nav-right,
  .tags-nav-close {
    cursor: pointer;
    [class^='el-icon-'] {
      font-weight: bolder;
    }
  }

  .tags-nav-left,
  .tags-nav-right {
    background-color: #f4f8fb;
  }

  .tags-nav-left {
    position: absolute;
    left: 0;
  }

  .tags-nav-right {
    position: absolute;
    right: 32px;
  }

  .tags-nav-close {
    position: absolute;
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
