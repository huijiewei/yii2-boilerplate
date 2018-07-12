<template>
  <el-form :rules="rules" :model="loginForm"
           ref="loginForm"
           @submit.native.prevent="submitLoginForm('loginForm')">
    <el-form-item prop="account">
      <el-input placeholder="手机号码" type="tel" v-model="loginForm.account" auto-complete="off">
        <template slot="prepend">
          <bp-icon type="mobile"></bp-icon>
        </template>
      </el-input>
    </el-form-item>
    <el-form-item prop="password">
      <el-input placeholder="密码" type="password" v-model="loginForm.password" auto-complete="off">
        <template slot="prepend">
          <bp-icon type="lock"></bp-icon>
        </template>
      </el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" :style="{width:'100%'}" native-type="submit" :loading="submitLoading">确 定</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  import BpIcon from '@core/components/Icon/index'

  export default {
    name: 'LoginForm',
    props: ['inModal'],
    components: { BpIcon },
    data() {
      return {
        submitLoading: false,
        rules: {
          account: [
            { required: true, message: '请输入手机号码', trigger: 'blur' }
          ],
          password: [
            { required: true, message: '请输入密码', trigger: 'blur' }
          ]
        },
        loginForm: {
          account: '',
          password: ''
        }
      }
    },
    methods: {
      submitLoginForm(formName) {
        this.$refs[formName].validate((valid) => {
          if (!valid) {
            return false
          }

          this.submitLoading = true

          this.$http.post('auth/login', this.loginForm).then(response => {
            this.$store.dispatch('updateAccessToken', response.data.accessToken)
            this.$store.dispatch('updateUser', response.data.user)

            this.$notify.success({
              title: '登陆成功',
              message: '欢迎光临 Boilerplate 管理系统',
              duration: 2000
            })

            if (this.inModal) {
              this.$store.dispatch('toggleLoginModal')
            } else {
              if (this.$router.currentRoute.query.direct) {
                this.$router.replace(this.$router.currentRoute.query.direct)
              } else {
                this.$router.replace('/')
              }
            }
          }).catch(() => {
          }).finally(() => {
            this.submitLoading = false
          })
        })
      }
    }
  }
</script>
