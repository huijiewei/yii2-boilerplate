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
      <el-col :md="16">
        <el-cascader
          style="width: 100%;"
          placeholder="请选择上级分类"
          :options="categoryTree"
          :props="{ value:'id', label: 'name'}"
          v-model="formCategoryAncestor"
          :change-on-select="true"
          @change="handleCategoryAncestorChange">
        </el-cascader>
      </el-col>
    </el-form-item>
    <el-form-item label="分类名称" prop="name">
      <el-col :md="7">
        <el-input v-model.trim="formModel.name"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="分类图标" prop="icon">
      <el-col :md="7">
        <el-input v-model.trim="formModel.icon"></el-input>
      </el-col>
    </el-form-item>
    <el-form-item label="图片" prop="image">
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
      },
      categoryTree: {
        type: Array
      },
      categoryAncestor: {
        type: Array
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
        formModel: null,
        formCategoryAncestor: []
      }
    },
    async mounted() {
      this.formModel = this.shopCategory
      this.formCategoryAncestor = this.categoryAncestor
    },
    methods: {
      handleUploadSuccess(imageUrl) {
        this.formModel.image = imageUrl
      },
      handleCategoryAncestorChange(value) {
        this.formModel.parentId = value[value.length - 1]
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
