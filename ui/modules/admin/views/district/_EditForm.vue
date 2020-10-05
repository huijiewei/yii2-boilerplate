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
        <el-cascader
          style="width: 100%"
          placeholder="请选择上级地区"
          :props="{
            value: 'id',
            label: 'name',
            checkStrictly: true,
            lazy: true,
            lazyLoad: loadDistricts,
            leaf: 'leaf',
          }"
          v-model="formDistrictParents"
          @change="handleDistrictParentsChange"
        >
        </el-cascader>
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
import flatry from '@core/utils/flatry'
import MiscService from '@admin/services/MiscService'

export default {
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

    async loadDistricts(node, resolve) {
      if (node.data && node.data.leaf) {
        resolve([])
        return
      }

      const parentId = (node.data && node.data.id) || 0

      this.loading = true

      const { data } = await flatry(MiscService.districts(parentId))

      if (data) {
        const districts =
          parentId === 0
            ? [...[{ id: 0, name: '全国', code: '000000' }], ...data]
            : data

        districts.forEach((item) => {
          item.leaf = item.code.length === 6
        })

        resolve(districts)
      }

      this.loading = false
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
