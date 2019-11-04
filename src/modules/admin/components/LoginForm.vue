<template>
  <el-form
    ref="loginForm"
    :model="loginForm"
    @submit.native.prevent="login('loginForm')"
  >
    <el-form-item
      prop="account"
      :error="getFieldErrorMessage('account')"
      :rules="[
        { required: true, message: '请输入手机号码', trigger: 'blur' }
      ]"
    >
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
    <el-form-item
      prop="password"
      :error="getFieldErrorMessage('password')"
      :rules="[
        { required: true, message: '请输入密码', trigger: 'blur' }
      ]"
    >
      <el-input
        v-model="loginForm.password"
        placeholder="密码"
        type="password"
        auto-complete="off"
        show-password
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
import AuthService from '@admin/services/AuthService'
import UnauthorizedHttpCodeMixin from '@core/mixins/UnauthorizedHttpCodeMixin'

export default {
  name: 'LoginForm',
  components: { AgIcon },
  mixins: [UnauthorizedHttpCodeMixin],
  props: {
    inModal: {
      type: Boolean
    }
  },
  data () {
    return {
      submitLoading: false,
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

        this.handleError(error)

        this.submitLoading = false
      })
    }
  }
}
</script>
