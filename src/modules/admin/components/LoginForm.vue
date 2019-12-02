<template>
  <el-form
    ref="loginForm"
    :model="loginForm"
    @submit.native.prevent="login('loginForm')"
  >
    <el-form-item
      prop="account"
      :rules="[{ required: true, message: '请输入帐号', trigger: 'blur' }]"
    >
      <el-input
        v-model="loginForm.account"
        placeholder="手机号码或者电子邮箱"
        type="tel"
        auto-complete="off"
        prefix-icon="el-icon-user"
      />
    </el-form-item>
    <el-form-item
      prop="password"
      :rules="[{ required: true, message: '请输入密码', trigger: 'blur' }]"
    >
      <el-input
        v-model="loginForm.password"
        placeholder="密码"
        type="password"
        auto-complete="off"
        show-password
        prefix-icon="el-icon-lock"
      />
    </el-form-item>
    <el-form-item>
      <el-button
        type="primary"
        :style="{ width: '100%' }"
        native-type="submit"
        :loading="submitLoading"
      >
        确 定
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import flatry from '@core/utils/flatry'
import AuthService from '@admin/services/AuthService'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'

export default {
  name: 'LoginForm',
  mixins: [UnprocessableEntityHttpErrorMixin],
  props: {
    inModal: {
      type: Boolean
    }
  },
  data() {
    return {
      submitLoading: false,
      loginForm: {
        account: '',
        password: ''
      }
    }
  },
  methods: {
    login(formName) {
      this.$refs[formName].validate(async valid => {
        if (!valid) {
          return false
        }

        this.submitLoading = true

        const { data, error } = await flatry(AuthService.login(this.loginForm))

        if (data) {
          await this.$store.dispatch('auth/login', data)

          this.$notify.success({
            title: data.message,
            message: '欢迎光临 Agile 管理系统',
            duration: 2000
          })

          this.$emit('on-success')
        }

        if (error) {
          this.handleViolationError(error, formName)
        }

        this.submitLoading = false
      })
    }
  }
}
</script>
