<template>
  <el-container class="bp-layout">
    <el-header height="50px">
      <div class="bp-logo">
        <router-link to="/">
          <img alt="主页" src="../../assets/images/logo.png"><img alt="Boilerplate" src="../../assets/images/banner.png">
        </router-link>
      </div>
    </el-header>
    <el-container>
      <el-aside width="200px">
        <sider></sider>
      </el-aside>
      <el-main>
        <router-view></router-view>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
  import SiderMenu from '@admin/components/SiderMenu'
  import Sider from '@admin/components/Sider'

  export default {
    components: { Sider, SiderMenu }
  }
</script>

<style lang="scss">
  .bp-layout {
    .el-header {
      padding: 0 0 20px 0;
      border-bottom: 1px solid #e4e9f0;
    }
  }

  .bp-logo {
    width: 210px;
    text-align: center;
    overflow: hidden;
    float: left;
  }

  .bp-logo a {
    text-decoration: none;
  }

  .bp-logo strong {
    display: inline-block;
  }

  .bp-logo img {
    vertical-align: middle;
    height: 50px;
    display: inline-block;
  }
</style>
