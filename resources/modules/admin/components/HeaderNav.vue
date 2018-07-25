<template>
  <nav class="bp-nav">
    <div class="bp-logo" :style="{ width: isCollapsed ? '60px' : '200px'}">
      <router-link to="/">
        <img alt="主页" src="../assets/images/logo.png"><img alt="Boilerplate" src="../assets/images/banner.png">
      </router-link>
    </div>
    <i :class="['anticon','trigger',isCollapsed ? 'anticon-menu-unfold':'anticon-menu-fold']"
       @click="toggleSidebar"></i>
    <ul v-if="getCurrentUser" class="nav nav-right">
      <li class="profile">
        <el-dropdown trigger="click" @command="handleCommand">
          <span class="el-dropdown-link">
            <img class="bp-avatar" v-if="getCurrentUser.avatar" :src="getCurrentUser.avatar">
            <img class="bp-avatar" v-else src="../assets/images/avatar.png">
            {{getCurrentUser.display || getCurrentUser.phone}}
            <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item command="userProfile">
              <bp-icon type="user"></bp-icon>
              个人资料
            </el-dropdown-item>
            <el-dropdown-item command="aclView">
              <bp-icon type="lock"></bp-icon>
              权限查看
            </el-dropdown-item>
            <el-dropdown-item command="aclUpdate">
              <bp-icon type="sync"></bp-icon>
              刷新资料
            </el-dropdown-item>
            <el-dropdown-item command="userLogout" divided>
              <bp-icon type="logout"></bp-icon>
              退出登陆
            </el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </li>
    </ul>
  </nav>
</template>

<script>
  import BpIcon from '@core/components/Icon/index'
  import flatry from '@admin/utils/flatry'

  export default {
    name: 'HeaderNav',
    components: { BpIcon },
    props: ['isCollapsed'],
    computed: {
      getCurrentUser() {
        return this.$store.getters['auth/getCurrentUser']
      }
    },
    methods: {
      async toggleSidebar() {
        await flatry(this.$store.dispatch('toggleSidebar'))
      },
      async handleCommand(command) {
        if (command === 'userLogout') {
          const { data } = await flatry(this.$store.dispatch('auth/logout'))

          if (data) {
            this.$message({
              type: 'success',
              duration: 1000,
              message: data.message,
              onClose: () => {
                this.$router.push({ path: '/login', query: { direct: this.$route.fullPath } })
              }
            })
          }

          return
        }

        if (command === 'userProfile') {

          return
        }

        if (command === 'aclView') {

          return
        }

        if (command === 'aclUpdate') {
          await flatry(this.$store.dispatch('auth/authentication'))
        }
      }
    }
  }
</script>

<style lang="scss">
  .bp-nav {
    i.trigger {
      font-size: 16px;
      line-height: 50px;
      cursor: pointer;
      transition: all 0.3s, padding 0s;
      padding: 0 17px;

      &:hover {
        background: #e6f7ff;
      }
    }

    .bp-logo {
      text-align: center;
      overflow: hidden;
      height: 50px;
      line-height: 50px;
      float: left;
      transition: width 0.2s;

      a {
        text-decoration: none;
      }

      img {
        vertical-align: middle;
        height: 39px;
        display: inline-block;
      }
    }

    .nav {
      display: flex;
      list-style: none;
      margin: 0;
    }

    .nav-right {
      float: right;
      flex-direction: row;
      align-items: center;
      justify-content: end;

      .profile {
        span {
          display: block;
          padding: 9px 16px;
          cursor: pointer;
          transition: color 0.1s linear 0s, background-color 0.1s linear 0s, opacity 0.2s linear 0s !important;

          img {
            height: 32px;
            vertical-align: middle;
            border: none;
            border-radius: 50%;
            margin-right: 6px;
          }
        }
      }
    }
  }
</style>
