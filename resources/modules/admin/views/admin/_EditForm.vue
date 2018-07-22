<template>
  <el-form :rules="formRules" :model="formModel" label-width="100px"
           ref="formModel"
           label-suffix="："
           @submit.native.stop.prevent="submitForm('formModel')">
    <el-form-item label="电话号码" prop="phone">
      <el-col :md="9">
        <el-input v-model.trim="formModel.phone"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="密码" prop="password">
      <el-col :md="6">
        <el-input type="password" v-model.trim="formModel.password"></el-input>
      </el-col>
      <el-col v-if="isEdit" :md="18">
        <span class="form-help form-help-inline">密码留空表示不修改密码</span>
      </el-col>
    </el-form-item>
    <el-form-item label="重复密码" prop="passwordRepeat">
      <el-col :md="6">
        <el-input type="password" v-model.trim="formModel.passwordRepeat"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="显示名" prop="displayName">
      <el-col :md="3">
        <el-input v-model.trim="formModel.displayName"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="头像" prop="displayIcon">
      <el-upload
        class="avatar-uploader"
        action="https://jsonplaceholder.typicode.com/posts/"
        :show-file-list="false">
        <img v-if="formModel.displayIcon" :src="formModel.displayIcon" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
      </el-upload>

    </el-form-item>
    <el-form-item label="管理组" prop="groupId">
      <el-col :md="5">
        <el-select v-model="formModel.groupId" :disabled="$store.getters['auth/getCurrentUser'].id === formModel.id"
                   placeholder="所属管理组">
          <el-option
            v-for="item in allGroup"
            :key="item.id"
            :label="item.name"
            :value="item.id">
          </el-option>
        </el-select>
      </el-col>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" native-type="submit" :loading="submitLoading">{{ buttonText }}</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  export default {
    name: 'AdminForm',
    props: {
      buttonText: {
        type: String,
        required: true
      },
      isEdit: {
        type: Boolean,
        default: false
      },
      admin: {
        type: Object
      },
      allGroup: {
        type: Array
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
        formModel: null
      }
    },
    watch: {
      'admin': function() {
        this.update()
      }
    },
    methods: {
      update() {
        this.formModel = Object.assign({ password: '', passwordRepeat: '' }, this.admin)
      },
      submitForm(formName) {
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

<style lang="scss">
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 3px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .avatar-uploader .el-upload:hover {
    border-color: #409eff;
  }

  .avatar-uploader-icon {
    font-size: 16px;
    color: #8c939d;
    width: 90px;
    height: 90px;
    line-height: 90px;
    text-align: center;
  }

  .avatar {
    width: 90px;
    height: 90px;
    display: block;
  }
</style>
