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
      label="名称"
      prop="name"
      :rules="[
        {
          required: true,
          message: '请输入品牌名称',
          trigger: 'blur',
        },
      ]"
    >
      <el-col :md="10">
        <el-input v-model.trim="formModel.name" />
      </el-col>
    </el-form-item>
    <el-form-item
      label="别名"
      prop="alias"
      :rules="[
        {
          required: true,
          message: '请输入品牌别名',
          trigger: 'blur',
        },
      ]"
    >
      <el-col :md="6">
        <el-input v-model.trim="formModel.alias" />
      </el-col>
    </el-form-item>
    <el-form-item label="LOGO" prop="logo">
      <el-col :md="10">
        <image-upload
          v-model="formModel.logo"
          :preview="[176, 62]"
          :multiple="false"
        />
      </el-col>
    </el-form-item>
    <el-form-item label="网站" prop="website">
      <el-col :md="12">
        <el-input v-model.trim="formModel.website" />
      </el-col>
    </el-form-item>
    <el-form-item label="介绍" prop="description">
      <el-col :md="20">
        <el-input
          type="textarea"
          :autosize="{ minRows: 3, maxRows: 6 }"
          v-model.trim="formModel.description"
        />
      </el-col>
    </el-form-item>
    <el-form-item label="分类" prop="shopCategoryIds">
      <el-col :md="20">
        <el-cascader
          style="width: 90%"
          placeholder="品牌绑定分类"
          v-model="formModel.shopCategoryIds"
          :options="categoryTree"
          :props="{
            value: 'id',
            label: 'name',
            multiple: true,
            checkStrictly: true,
          }"
        >
        </el-cascader>
        &nbsp;
        <el-button
          size="mini"
          title="刷新选项数据"
          icon="el-icon-refresh"
          @click="loadCategoryTree"
        ></el-button>
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
import ImageUpload from '@admin/components/upload/ImageUpload'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'
import MiscService from '@admin/services/MiscService'

export default {
  components: { ImageUpload },
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
    shopBrand: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      submitLoading: false,
      formModel: null,
      categoryTree: null,
    }
  },
  async created() {
    await this.loadCategoryTree()
    this.formModel = Object.assign({}, this.shopBrand)
  },
  methods: {
    async loadCategoryTree() {
      const { data } = await MiscService.shopCategoryTree()

      if (data) {
        this.categoryTree = data
      }
    },
    handleFormSubmit(formName) {
      this.$refs[formName].validate(async (valid) => {
        if (!valid) {
          return false
        }

        this.submitLoading = true

        const shopBrand = Object.assign({}, this.formModel)

        if (Array.isArray(this.formModel.shopCategoryIds)) {
          const shopCategoryIds = []

          this.formModel.shopCategoryIds.forEach(function (ids) {
            if (Array.isArray(ids)) {
              shopCategoryIds.push(ids[ids.length - 1])
            }
          })
          if (shopCategoryIds.length > 0) {
            shopBrand.shopCategoryIds = shopCategoryIds
          } else {
            shopBrand.shopCategoryIds = []
          }
        }

        this.$emit(
          'on-submit',
          shopBrand,
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
