<template>
  <div class="tags-nav">
    <div class="tags-nav-main">
      <div class="tags-nav-left tags-nav-tab">
        <i class="el-icon-arrow-left"></i>
      </div>
      <el-scrollbar
        ref="scrollContainer"
        :vertical="false"
        class="tags-nav-scroll"
        @wheel.native.prevent="handleScroll"
      >
        <ul class="tags-nav-tabs"></ul>
      </el-scrollbar>
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
      <div class="tags-nav-right tags-nav-tab">
        <i class="el-icon-arrow-right"></i>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TagsNav',
  methods: {},
}
</script>

<style lang="scss">
@import '../../../core/assets/styles/mixin';
.tags-nav {
  @include clearfix;
  font-size: 13px;
  background-color: #f4f8fb;
  padding: 3px 16px 6px 16px;

  .tags-nav-main {
    position: relative;
    padding: 6px 0;
    user-select: none;
  }

  .tags-nav-tabs {
  }

  .tags-nav-scroll {
    float: left;
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
    float: left;
  }

  .tags-nav-right {
    float: right;
  }

  .tags-nav-close {
    float: right;
    background-color: #ffffff;
    &.el-dropdown {
      font-size: 13px;
    }
  }

  .tags-nav-tab {
    padding: 5px 7px;
  }
}

.tags-nav-menu {
  .el-dropdown-menu__item {
    font-size: 13px;
    padding: 0 20px 0 15px;
  }
}
</style>
