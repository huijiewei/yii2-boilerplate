<template>
  <nav class="bp-nav">
    <div class="bp-logo" :style="{ width: isCollapsed ? '60px' : '210px'}">
      <router-link to="/">
        <img alt="主页" src="../assets/images/logo.png"><img alt="Boilerplate" src="../assets/images/banner.png">
      </router-link>
    </div>
    <i :class="['anticon','trigger',isCollapsed ? 'anticon-menu-unfold':'anticon-menu-fold']"
       @click="toggleSidebar"></i>
    <ul class="nav nav-right">
      <li class="profile">
        <el-dropdown trigger="click" @command="handleCommand">
          <span class="el-dropdown-link">
            {{getUser.displayName}}
            <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item command="userLogout">退出登陆</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </li>
    </ul>
  </nav>
</template>

<script>
  export default {
    name: 'HeaderNav',
    props: ['isCollapsed'],
    mounted() {
      if (this.getUser.init === false) {
        this.$http.get('auth/user')
          .then(response => {
            this.$store.dispatch('updateUser', response.data)
          })
          .catch(() => {
          })
      }
    },
    computed: {
      getUser() {
        return this.$store.state.user
      }
    },
    methods: {
      toggleSidebar() {
        this.$store.dispatch('toggleSidebar')
      },
      handleCommand(command) {
        if (command === 'userLogout') {
          let nav = this

          nav.$http.get('auth/logout').then(response => {
            nav.$message({
              type: 'success',
              duration: 2000,
              message: response.data.message,
              onClose() {
                nav.$store.dispatch('updateAccessToken', '')
                nav.$store.dispatch('updateUser', null)

                nav.$router.push('/login')
              }
            })
          }).catch(error => {
            console.log(error)
          })
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
    }

    .nav-right {
      float: right;
      flex-direction: row;
      align-items: center;
      justify-content: end;

      .profile {
        span {
          padding: 8px 15px;
          cursor: pointer;
        }
      }
    }
  }
</style>
