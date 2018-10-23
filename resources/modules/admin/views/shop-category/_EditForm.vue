<template>
  <el-form
    v-if="formModel"
    :rules="formRules"
    :model="formModel"
    ref="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')">
    <el-form-item label="所属分类" prop="parentId">
      <el-col :md="9">

      </el-col>
    </el-form-item>
    <el-form-item label="分类名称" prop="name">
      <el-col :md="6">
        <el-input v-model.trim="formModel.name"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="图片" prop="displayIcon">
      <aliyun-oss-uploader :avatar="formModel.image"
                           @on-upload-success="handleUploadSuccess"></aliyun-oss-uploader>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" native-type="submit" :loading="submitLoading">{{ submitText }}</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  import AliyunOssUploader from '@admin/components/uploaders/AliyunOssUploader'

  export default {
    name: 'ShopCategoryForm',
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
      shopCategory: {
        type: Object
      }
    },
    data() {
      return {
        submitLoading: false,
        formRules: {
          name: [
            { required: true, message: '请输入商品分类名称', trigger: 'blur' }
          ]
        },
        formModel: null
      }
    },
    mounted() {
      this.formModel = this.shopCategory
    },
    methods: {
      handleUploadSuccess(imageUrl) {
        this.formModel.image = imageUrl
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
