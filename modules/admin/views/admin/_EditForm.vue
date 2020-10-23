<template>
  <el-form
    v-if="formModel"
    ref="formModel"
    :model="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')"
  >
    <el-form-item
      label="手机号码"
      prop="phone"
      :rules="[{ required: true, message: '请输入手机号码', trigger: 'blur' }]"
    >
      <el-col :md="9">
        <el-input v-model.trim="formModel.phone" />
      </el-col>
    </el-form-item>
    <el-form-item
      label="电子邮箱"
      prop="email"
      :rules="[{ required: true, message: '请输入电子邮箱', trigger: 'blur' }]"
    >
      <el-col :md="9">
        <el-input v-model.trim="formModel.email" />
      </el-col>
    </el-form-item>
    <el-form-item label="密码" prop="password" :rules="validatePassword">
      <el-col :md="6">
        <el-input
          v-model.trim="formModel.password"
          type="password"
          autocomplete="new-password"
          show-password
        />
      </el-col>
      <el-col v-if="isEdit" :md="18">
        <span class="form-help form-help-inline">密码留空表示不修改密码</span>
      </el-col>
    </el-form-item>
    <el-form-item
      label="密码确认"
      prop="passwordConfirm"
      :rules="validatePasswordConfirm"
    >
      <el-col :md="6">
        <el-input
          v-model.trim="formModel.passwordConfirm"
          type="password"
          autocomplete="new-password"
          show-password
        />
      </el-col>
    </el-form-item>
    <el-form-item label="姓名" prop="name">
      <el-col :md="3">
        <el-input v-model.trim="formModel.name" />
      </el-col>
    </el-form-item>
    <el-form-item label="头像" prop="avatar">
      <avatar-upload v-model.trim="formModel.avatar" />
    </el-form-item>
    <el-form-item
      label="管理组"
      prop="adminGroupId"
      :rules="[
        {
          required: true,
          message: '请选择所属管理组',
          trigger: 'change',
        },
      ]"
    >
      <el-col :md="5">
        <remote-select
          v-model="formModel.adminGroupId"
          :disabled="getCurrentUserId === formModel.id"
          placeholder="所属管理组"
          option-value="id"
          option-label="name"
          :remote-method="loadAdminGroups"
        ></remote-select>
      </el-col>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" native-type="submit" :loading="submitLoading">
        {{ submitText }}
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import MiscService from '@admin/services/MiscService'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'
import AvatarUpload from '@admin/components/upload/AvatarUpload'
import RemoteSelect from '@admin/components/RemoteSelect'

export default {
  components: { RemoteSelect, AvatarUpload },
  mixins: [UnprocessableEntityHttpErrorMixin],
  props: {
    submitText: {
      type: String,
      required: true,
    },
    isEdit: {
      type: Boolean,
      default: false,
    },
    admin: {
      type: Object,
      default: null,
    },
  },
  data() {
    const validatePassword = []
    const validatePasswordConfirm = []

    if (!this.isEdit) {
      validatePassword.push({
        required: !this.isEdit,
        message: '请输入密码',
        trigger: 'blur',
      })
      validatePasswordConfirm.push({
        required: !this.isEdit,
        message: '请输入密码确认',
        trigger: 'blur',
      })
    }

    validatePassword.push({
      validator: (rule, value, callback) => {
        if (this.formModel.passwordConfirm !== '') {
          this.$refs.formModel.validateField('passwordConfirm')
        }
        callback()
      },
      trigger: 'blur',
    })

    validatePasswordConfirm.push({
      validator: (rule, value, callback) => {
        if (value !== this.formModel.password) {
          callback(new Error('密码与密码确认不一致!'))
        } else {
          callback()
        }
      },
      trigger: 'blur',
    })

    return {
      submitLoading: false,
      validatePassword: validatePassword,
      validatePasswordConfirm: validatePasswordConfirm,
      formModel: null,
      adminGroups: {},
    }
  },
  computed: {
    getCurrentUserId() {
      return this.$store.getters['auth/getCurrentUser']
        ? this.$store.getters['auth/getCurrentUser'].id
        : 0
    },
  },
  async created() {
    this.formModel = Object.assign(
      { password: '', passwordConfirm: '' },
      this.admin
    )
  },
  methods: {
    async loadAdminGroups(callback) {
      const { data } = await MiscService.adminGroups()

      callback(data)
    },
    handleFormSubmit(formName) {
      this.$refs[formName].validate((valid) => {
        if (!valid) {
          return false
        }

        this.submitLoading = true

        this.$emit(
          'on-submit',
          this.formModel,
          () => {
            this.$refs[formName].clearValidate()
          },
          (error) => {
            this.handleViolationError(error, formName)
          },
          () => {
            this.submitLoading = false
          }
        )
      })
    },
  },
}
</script>
