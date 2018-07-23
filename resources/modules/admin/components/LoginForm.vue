<template>
  <el-form :rules="rules" :model="loginForm"
           ref="loginForm"
           @submit.native.prevent="login('loginForm')">
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
  import flatry from '@admin/utils/flatry'

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
      login(formName) {
        this.$refs[formName].validate(async (valid) => {
          if (!valid) {
            return false
          }

          this.submitLoading = true

          const { data } = await flatry(this.$store.dispatch('auth/login', this.loginForm))

          if (data) {
            this.$notify.success({
              title: data.message,
              message: '欢迎光临 Boilerplate 管理系统',
              duration: 2000
            })

            this.$emit('on-success')
          }

          this.submitLoading = false
        })
      }
    }
  }
</script>
