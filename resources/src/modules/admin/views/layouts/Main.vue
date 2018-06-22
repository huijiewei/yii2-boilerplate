<template>
  <el-container>
    <el-header style="background-color: #34383c; border-bottom: 1px solid #34383c;" height="50px">
      <aside width="200px"></aside>
      <el-radio-group v-model="isCollapse">
        <el-radio-button :label="false">展开</el-radio-button>
        <el-radio-button :label="true">收起</el-radio-button>
      </el-radio-group>
    </el-header>
    <el-container>
      <el-aside width="auto">
        <el-scrollbar wrap-style="overflow-x:auto;"
                      style="height: calc(100vh - 50px);"
                      :native="false">
          <el-menu default-active="1-1" :collapse="isCollapse" style="min-height: calc(100vh - 50px);">
            <el-submenu index="1">
              <template slot="title">
                <i aria-label="导航一" title="导航一" class="el-icon-message"></i>
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
        </el-scrollbar>
      </el-aside>
      <el-main style="padding: 0 0 1px 0;">
        <el-container>
          <el-header height="auto" style="padding: 15px 20px 15px 20px; border-bottom: 1px solid #e6e6e6;">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
              <el-breadcrumb-item><a href="/">活动管理</a></el-breadcrumb-item>
              <el-breadcrumb-item>活动列表</el-breadcrumb-item>
              <el-breadcrumb-item>活动详情</el-breadcrumb-item>
            </el-breadcrumb>
          </el-header>
          <el-main style="padding: 0 1px 0 0;">
            <el-scrollbar wrap-style="overflow-x:auto;" style="height: calc(100vh - 96px);" :native="false">
              <div style="padding: 15px 20px;">
                <router-view></router-view>
              </div>
            </el-scrollbar>
          </el-main>
        </el-container>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
  export default {
    data() {
      return {
        isCollapse: false,
        menus: {}
      }
    }
  }
</script>

<style lang="css" scoped>

</style>
