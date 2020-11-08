<template>
  <el-form
    v-if="formModel"
    :model="formModel"
    ref="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')"
  >
    <el-form-item label="上级地区" prop="parentId">
      <el-col :md="16">
        <district-cascader
          placeholder="请选择上级地区"
          v-model="formDistrictParents"
          @change="handleDistrictParentsChange"
          :leaf-length="6"
          :disabled-codes="[this.district.code]"
        >
        </district-cascader>
      </el-col>
    </el-form-item>
    <el-form-item
      label="地区名称"
      prop="name"
      :rules="[{ required: true, message: '请输入地区名称', trigger: 'blur' }]"
    >
      <el-col :md="7">
        <el-input v-model.trim="formModel.name" />
      </el-col>
    </el-form-item>
    <el-form-item
      label="地区代码"
      prop="code"
      :rules="[{ required: true, message: '请输入地区代码', trigger: 'blur' }]"
    >
      <el-col :md="7">
        <el-input class="text-mono" v-model.trim="formModel.code" />
      </el-col>
    </el-form-item>
    <el-form-item label="地区邮编" prop="zipCode">
      <el-col :md="7">
        <el-input v-model.trim="formModel.zipCode" />
      </el-col>
    </el-form-item>
    <el-form-item label="电话区号" prop="areaCode">
      <el-col :md="7">
        <el-input v-model.trim="formModel.areaCode" />
      </el-col>
    </el-form-item>
    <el-form-item>
      <el-button
        type="primary"
        :disabled="!canSubmit"
        native-type="submit"
        :loading="submitLoading"
        >{{ submitText }}
      </el-button>

      <el-button
        v-if="isEdit"
        :disabled="!$can('district/delete')"
        plain
        type="danger"
        size="small"
        @click.native="handleDistrictDelete"
      >
        删除
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'
import DistrictCascader from '@admin/components/DistrictCascader'

export default {
  components: { DistrictCascader },
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
    canSubmit: {
      type: Boolean,
      default: false,
    },
    district: {
      type: Object,
    },
    districtParents: {
      type: Array,
    },
  },
  data() {
    return {
      submitLoading: false,
      formModel: null,
      formDistrictParents: [],
    }
  },
  created() {
    this.formModel = Object.assign({}, this.district)
    this.formDistrictParents = this.districtParents
  },
  methods: {
    handleDistrictParentsChange(value) {
      this.formModel.parentId = value[value.length - 1]
    },
    handleDistrictDelete() {
      this.$emit('on-delete', this.formModel)
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
