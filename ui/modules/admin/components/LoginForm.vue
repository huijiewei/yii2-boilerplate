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
        v-model.trim="loginForm.account"
        placeholder="手机号码或者电子邮箱"
        type="text"
        prefix-icon="el-icon-user"
      />
    </el-form-item>
    <el-form-item
      prop="password"
      :rules="[{ required: true, message: '请输入密码', trigger: 'blur' }]"
    >
      <el-input
        v-model.trim="loginForm.password"
        placeholder="密码"
        type="password"
        prefix-icon="el-icon-lock"
      />
    </el-form-item>
    <el-form-item
      v-if="captcha"
      prop="captcha"
      :rules="[{ required: true, message: '请输入验证码', trigger: 'blur' }]"
    >
      <el-input
        class="uppercase"
        v-model.trim="loginForm.captcha"
        placeholder="验证码"
        type="text"
        auto-complete="off"
        prefix-icon="el-icon-view"
      >
        <template slot="append">
          <img
            style="cursor: pointer; vertical-align: middle"
            @click="updateCaptcha"
            alt="点击更新验证码"
            title="点击更新验证码"
            :src="captcha.image"
          />
        </template>
      </el-input>
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
import AuthService from '@admin/services/AuthService'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'
import OpenService from '@admin/services/OpenService'

export default {
  name: 'LoginForm',
  mixins: [UnprocessableEntityHttpErrorMixin],
  props: {
    inModal: {
      type: Boolean,
    },
  },
  data() {
    return {
      submitLoading: false,
      loginForm: {
        account: '',
        password: '',
        captcha: '',
      },
      captcha: null,
    }
  },
  methods: {
    async updateCaptcha() {
      const { data } = await OpenService.captcha()

      this.captcha = data
      this.loginForm.captcha = ''
    },
    removeCaptcha() {
      this.captcha = null
      this.loginForm.captcha = ''
    },
    login(formName) {
      this.$refs[formName].validate(async (valid) => {
        if (!valid) {
          return false
        }

        this.submitLoading = true

        let loginForm

        if (this.captcha) {
          // eslint-disable-next-line no-new-func
          const captchaProcess = new Function('captcha', this.captcha.process)

          loginForm = Object.assign({}, this.loginForm, {
            captcha: captchaProcess(this.loginForm.captcha),
          })
        } else {
          loginForm = this.loginForm
        }

        const { data, error } = await AuthService.login(loginForm)

        if (data) {
          await this.$store.dispatch('auth/login', data)

          this.$notify.success({
            title: data.message,
            message: '欢迎光临 Agile 管理系统',
            duration: 2000,
          })

          this.$emit('on-success')
        }

        if (error) {
          if (
            error &&
            error.response &&
            error.response.status &&
            error.response.status === 422
          ) {
            let violations

            if (Array.isArray(error.response.data.violations)) {
              violations = error.response.data.violations
            }

            if (Array.isArray(error.response.data)) {
              violations = error.response.data
            }

            const violationCaptcha = violations.find((violation) => {
              return violation.field.split('.').pop() === 'captcha'
            })

            if (violationCaptcha) {
              await this.updateCaptcha()
            } else {
              this.removeCaptcha()
            }
          }

          this.handleViolationError(error, formName)
        }

        this.submitLoading = false
      })
    },
  },
}
</script>
