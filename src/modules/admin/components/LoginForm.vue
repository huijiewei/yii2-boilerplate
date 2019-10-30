<template>
  <el-form
    ref="loginForm"
    :rules="rules"
    :model="loginForm"
    @submit.native.prevent="login('loginForm')"
  >
    <el-form-item prop="account">
      <el-input
        v-model="loginForm.account"
        placeholder="手机号码"
        type="tel"
        auto-complete="off"
      >
        <template slot="prepend">
          <ag-icon type="mobile" />
        </template>
      </el-input>
    </el-form-item>
    <el-form-item prop="password">
      <el-input
        v-model="loginForm.password"
        placeholder="密码"
        type="password"
        auto-complete="off"
      >
        <template slot="prepend">
          <ag-icon type="lock" />
        </template>
      </el-input>
    </el-form-item>
    <el-form-item>
      <el-button
        type="primary"
        :style="{width:'100%'}"
        native-type="submit"
        :loading="submitLoading"
      >
        确 定
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import AgIcon from '@core/components/Icon/index'
import flatry from '@core/utils/flatry'

export default {
  name: 'LoginForm',
  components: { AgIcon },
  props: {
    inModal: {
      type: Boolean
    }
  },
  data () {
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
    login (formName) {
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
