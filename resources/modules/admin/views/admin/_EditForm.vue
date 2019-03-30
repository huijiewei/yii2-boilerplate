<template>
  <el-form
    v-if="formModel"
    :rules="formRules"
    :model="formModel"
    ref="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')">
    <el-form-item label="电话号码" prop="phone">
      <el-col :md="9">
        <el-input v-model.trim="formModel.phone"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="密码" prop="password">
      <el-col :md="6">
        <el-input type="password" auto-complete="new-password" v-model.trim="formModel.password"></el-input>
      </el-col>
      <el-col v-if="isEdit" :md="18">
        <span class="form-help form-help-inline">密码留空表示不修改密码</span>
      </el-col>
    </el-form-item>
    <el-form-item label="重复密码" prop="passwordRepeat">
      <el-col :md="6">
        <el-input type="password" auto-complete="new-password" v-model.trim="formModel.passwordRepeat"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="显示名" prop="display">
      <el-col :md="3">
        <el-input v-model.trim="formModel.display"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="头像" prop="displayIcon">
      <aliyun-oss-uploader :avatar="formModel.avatar"
                           @on-upload-success="handleUploadSuccess"></aliyun-oss-uploader>
    </el-form-item>
    <el-form-item label="管理组" prop="groupId">
      <el-col :md="5">
        <el-select v-model="formModel.groupId"
                   :disabled="getCurrentUserId === formModel.id"
                   placeholder="所属管理组">
          <el-option
            v-for="item in adminGroups"
            :key="item.id"
            :label="item.name"
            :value="item.id">
          </el-option>
        </el-select>
      </el-col>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" native-type="submit" :loading="submitLoading">{{ submitText }}</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  import AdminService from '@admin/services/AdminService'
  import flatry from '@admin/utils/flatry'
  import AliyunOssUploader from '@admin/components/upload/AvatarUpload'

  export default {
    name: 'AdminForm',
    components: { AliyunOssUploader },
    props: {
      submitText: {
        type: String,
        required: true
      },
      isEdit: {
        type: Boolean,
        default: false
      },
      admin: {
        type: Object
      }
    },
    computed: {
      getCurrentUserId() {
        return this.$store.getters['auth/getCurrentUser'] ? this.$store.getters['auth/getCurrentUser'].id : 0
      }
    },
    data() {
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
        }, trigger: 'blur'
      })

      validatePasswordRepeat.push({
        validator: (rule, value, callback) => {
          if (value !== this.formModel.password) {
            callback(new Error('两次输入密码不一致!'))
          } else {
            callback()
          }
        }, trigger: 'blur'
      })

      return {
        submitLoading: false,
        formRules: {
          phone: [
            { required: true, message: '请输入电话号码', trigger: 'blur' }
          ],
          password: validatePassword,
          passwordRepeat: validatePasswordRepeat,
          groupId: [
            { required: true, message: '请选择所属管理组', trigger: 'change' }
          ]
        },
        formModel: null,
        adminGroups: []
      }
    },
    async mounted() {
      this.formModel = Object.assign({ password: '', passwordRepeat: '' }, this.admin)

      const { data } = await flatry(AdminService.groups())

      if (data) {
        this.adminGroups = data
      }
    },
    methods: {
      handleUploadSuccess(avatarUrl) {
        this.formModel.avatar = avatarUrl
      },
      handleFormSubmit(formName) {
        this.$refs[formName].validate((valid) => {
          if (!valid) {
            return false
          }

          this.submitLoading = true

          this.$emit('on-submit', this.formModel, () => {
            this.$refs[formName].clearValidate()
          }, () => {
            this.submitLoading = false
          })
        })
      }
    }
  }
</script>
