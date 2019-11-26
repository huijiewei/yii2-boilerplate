<template>
  <el-form
    v-if="formModel"
    :model="formModel"
    ref="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')"
  >
    <el-form-item label="所属分类" prop="parentId">
      <el-col :md="16">
        <el-cascader
          style="width: 100%;"
          placeholder="请选择上级分类"
          :options="getCategoryTree"
          :props="{ value: 'id', label: 'name', checkStrictly: true }"
          v-model="formCategoryParents"
          @change="handleCategoryParentsChange"
        >
        </el-cascader>
      </el-col>
    </el-form-item>
    <el-form-item label="分类名称" prop="name">
      <el-col :md="7">
        <el-input
          v-model.trim="formModel.name"
          :rules="[
            { required: true, message: '请输入商品分类名称', trigger: 'blur' }
          ]"
        />
      </el-col>
    </el-form-item>
    <el-form-item label="分类图标" prop="icon">
      <el-col :md="7">
        <el-input v-model.trim="formModel.icon" />
      </el-col>
    </el-form-item>
    <el-form-item label="图片" prop="image">
      <avatar-uploader
        :avatar="formModel.image"
        @on-upload-success="handleUploadSuccess"
      />
    </el-form-item>
    <el-form-item label="分类介绍" prop="icon">
      <el-col :md="16">
        <el-input
          type="textarea"
          :rows="2"
          autosize
          v-model.trim="formModel.description"
        />
      </el-col>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" native-type="submit" :loading="submitLoading"
        >{{ submitText }}
      </el-button>

      <el-button
        v-if="isEdit"
        :disabled="!$can('shop-category/delete')"
        plain
        type="danger"
        size="small"
        @click.native="handleShopCategoryDelete"
      >
        删除
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import AvatarUploader from '@admin/components/upload/AvatarUpload'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'

export default {
  name: 'ShopCategoryForm',
  components: { AvatarUploader },
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
    shopCategory: {
      type: Object
    },
    categoryTree: {
      type: Array
    },
    categoryParents: {
      type: Array
    }
  },
  data() {
    return {
      submitLoading: false,
      formModel: null,
      formCategoryParents: []
    }
  },
  computed: {
    getCategoryTree() {
      return [...[{ id: 0, name: '根分类' }], ...this.categoryTree]
    }
  },
  async mounted() {
    this.formModel = this.shopCategory
    this.formCategoryParents = this.categoryParents
  },
  methods: {
    handleUploadSuccess(imageUrl) {
      this.formModel.image = imageUrl
    },
    handleCategoryParentsChange(value) {
      this.formModel.parentId = value[value.length - 1]
    },
    handleShopCategoryDelete() {
      this.$emit('on-delete', this.formModel)
    },
    handleFormSubmit(formName) {
      this.$refs[formName].validate(valid => {
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
          error => {
            this.handleViolationError(error, formName)
          },
          () => {
            this.submitLoading = false
          }
        )
      })
    }
  }
}
</script>
