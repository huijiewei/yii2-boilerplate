<template>
  <div class="login-view">
    <div class="login-wrap">
      <div class="login-form">
        <div class="login-head">
          <div>
            <img alt="Boilerplate" src="../../assets/images/logo.png" />
          </div>
          <h3>管理员登陆</h3>
        </div>
        <login-form @on-success="loginSuccess" />
      </div>
    </div>
  </div>
</template>

<script>
import LoginForm from '@admin/components/LoginForm'

export default {
  name: 'Login',
  components: { LoginForm },
  methods: {
    loginSuccess() {
      if (this.$router.currentRoute.query.direct) {
        this.$router.replace(this.$router.currentRoute.query.direct)
      } else {
        this.$router.replace('/home')
      }
    },
  },
}
</script>
<style lang="less">
.login-view {
  width: 100%;
  height: 100%;
  background: url('../../assets/images/login-bg.jpg') top center;
  background-size: cover;

  .login-wrap {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;

    .login-form {
      border-radius: 2px;
      background: #fff;
      padding: 15px 35px;
      width: 320px;
      box-shadow: 0 4px 23px 0 rgba(0, 0, 0, 0.09);

      .login-head {
        text-align: center;

        div {
          margin-top: 10px;

          img {
            height: 39px;
          }
        }

        h3 {
          margin-top: 10px;
        }
      }
    }
  }
}
</style>
