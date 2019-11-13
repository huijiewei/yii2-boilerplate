<template>
  <el-form
    v-if="formModel"
    ref="formModel"
    :rules="formRules"
    :model="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')"
  >
    <el-form-item
      label="手机号码"
      prop="phone"
    >
      <el-col :md="9">
        <el-input v-model.trim="formModel.phone" />
      </el-col>
    </el-form-item>
    <el-form-item
      label="密码"
      prop="password"
    >
      <el-col :md="6">
        <el-input
          v-model.trim="formModel.password"
          type="password"
          auto-complete="new-password"
        />
      </el-col>
      <el-col
        v-if="isEdit"
        :md="18"
      >
        <span class="form-help form-help-inline">密码留空表示不修改密码</span>
      </el-col>
    </el-form-item>
    <el-form-item
      label="重复密码"
      prop="passwordRepeat"
    >
      <el-col :md="6">
        <el-input
          v-model.trim="formModel.passwordRepeat"
          type="password"
          auto-complete="new-password"
        />
      </el-col>
    </el-form-item>
    <el-form-item
      label="姓名"
      prop="name"
    >
      <el-col :md="3">
        <el-input v-model.trim="formModel.name" />
      </el-col>
    </el-form-item>
    <el-form-item>
      <el-button
        type="primary"
        native-type="submit"
        :loading="submitLoading"
      >
        {{ submitText }}
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'

export default {
  name: 'UserForm',
  components: { },
  mixins: [UnprocessableEntityHttpErrorMixin],
  props: {
    submitText: {
      type: String,
      required: true
    },
    isEdit: {
      type: Boolean,
      default: false
    },
    user: {
      type: Object,
      default: null
    }
  },
  data () {
    const validatePassword = []
    const validatePasswordRepeat = []

    if (!this.isEdit) {
      validatePassword.push({ required: !this.isEdit, message: '请输入密码', trigger: 'blur' })
      validatePasswordRepeat.push({ required: !this.isEdit, message: '请输入重复密码', trigger: 'blur' })
    }

    validatePassword.push({
      validator: (rule, value, callback) => {
        if (this.formModel.passwordRepeat !== '') {
          this.$refs.formModel.validateField('passwordRepeat')
        }
        callback()
      },
      trigger: 'blur'
    })

    validatePasswordRepeat.push({
      validator: (rule, value, callback) => {
        if (value !== this.formModel.password) {
          callback(new Error('两次输入密码不一致!'))
        } else {
          callback()
        }
      },
      trigger: 'blur'
    })

    return {
      submitLoading: false,
      formRules: {
        phone: [
          { required: true, message: '请输入手机号码', trigger: 'blur' }
        ],
        password: validatePassword,
        passwordRepeat: validatePasswordRepeat
      },
      formModel: null
    }
  },
  mounted () {
    this.formModel = Object.assign({ password: '', passwordRepeat: '' }, this.user)
  },
  methods: {
    handleUploadSuccess (avatarUrl) {
      this.formModel.avatar = avatarUrl
    },
    handleFormSubmit (formName) {
      this.$refs[formName].validate((valid) => {
        if (!valid) {
          return false
        }

        this.submitLoading = true

        this.$emit('on-submit', this.formModel, () => {
          this.$refs[formName].clearValidate()
        }, (error) => {
          this.handleViolationError(error, formName)
        }, () => {
          this.submitLoading = false
        })
      })
    }
  }
}
</script>
