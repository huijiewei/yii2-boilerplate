<template>
  <el-container>
    <el-header>
      <el-radio-group v-model="isCollapse" style="margin-bottom: 20px;">
        <el-radio-button :label="false">展开</el-radio-button>
        <el-radio-button :label="true">收起</el-radio-button>
      </el-radio-group>
    </el-header>
    <el-container>
      <el-aside width="200px">
        <div class="vuebar-element" v-bar="{preventParentScroll: true, scrollThrottle: 30}">
          <div>
            <el-menu default-active="1-1" :collapse="isCollapse">
              <el-submenu index="1">
                <template slot="title">
                  <i class="el-icon-message"></i>
                  <span slot="title">导航一</span>
                </template>
                <el-menu-item index="1-1">选项1</el-menu-item>
                <el-menu-item index="1-2">选项2</el-menu-item>
                <el-menu-item index="1-3">选项3</el-menu-item>
                <el-submenu index="1-4">
                  <template slot="title">选项4</template>
                  <el-menu-item index="1-4-1">选项4-1</el-menu-item>
                </el-submenu>
              </el-submenu>
              <el-submenu index="2">
                <template slot="title">
                  <i class="el-icon-menu"></i>
                  <span slot="title">导航二</span>
                </template>
                <el-menu-item-group>
                  <template slot="title">分组一</template>
                  <el-menu-item index="2-1">选项1</el-menu-item>
                  <el-menu-item index="2-2">选项2</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="分组2">
                  <el-menu-item index="2-3">选项3</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="2-4">
                  <template slot="title">选项4</template>
                  <el-menu-item index="2-4-1">选项4-1</el-menu-item>
                </el-submenu>
              </el-submenu>
              <el-submenu index="3">
                <template slot="title">
                  <i class="el-icon-setting"></i>
                  <span slot="title">导航三</span>
                </template>
                <el-menu-item-group>
                  <template slot="title">分组一</template>
                  <el-menu-item index="3-1">选项1</el-menu-item>
                  <el-menu-item index="3-2">选项2</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="分组2">
                  <el-menu-item index="3-3">选项3</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="3-4">
                  <template slot="title">选项4</template>
                  <el-menu-item index="3-4-1">选项4-1</el-menu-item>
                </el-submenu>
              </el-submenu>
            </el-menu>
          </div>
        </div>
      </el-aside>
      <el-main>
        <router-view></router-view>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
  export default {
    data() {
      return {
        isCollapse: true
      }
    }
  }
</script>

<style lang="css">
  .el-header {
    background-color: #34383c;
    line-height: 50px;
    border-bottom: 1px solid #34383c;
  }

  .el-aside {
    background-color: #fff;
    color: #333;
  }

  .vuebar-element {
    height: calc(100vh - 50px);
  }

  .el-main {
    background-color: #fff;
    color: #333;
  }

  .vb > .vb-dragger {
    z-index: 5;
    width: 9px;
    right: 0;
  }

  .vb > .vb-dragger > .vb-dragger-styler {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: rotate3d(0, 0, 0, 0);
    transform: rotate3d(0, 0, 0, 0);
    -webkit-transition: background-color 100ms ease-out,
    margin 100ms ease-out,
    height 100ms ease-out;
    transition: background-color 100ms ease-out,
    margin 100ms ease-out,
    height 100ms ease-out;
    background-color: #e1e6ea;
    margin: 2px 3px 2px 0;
    border-radius: 1px;
    height: 100%;
    display: block;
  }

  .vb.vb-scrolling-phantom > .vb-dragger > .vb-dragger-styler {
    background-color: #e1e6ea;
  }

  .vb > .vb-dragger:hover > .vb-dragger-styler {
    background-color: #e1e6ea;
  }

  .vb.vb-dragging > .vb-dragger > .vb-dragger-styler {
    background-color: #e1e6ea;
  }

  .vb.vb-dragging-phantom > .vb-dragger > .vb-dragger-styler {
    background-color: #e1e6ea;
  }
</style>
