<template>
  <el-form
    :inline="true"
    :model="formModel"
    size="small"
    autocomplete="off"
    @submit.native.stop.prevent="handleFormSubmit()"
    @reset.native.stop.prevent="handleFormReset()"
  >
    <template v-for="(item, index) in getOtherFields">
      <hr v-if="item.type === 'br'" :key="index" class="br" />
      <el-form-item v-else :key="index">
        <el-select
          v-if="item.type === 'select'"
          v-model="formModel[item.field]"
          :multiple="item.multiple"
          :clearable="true"
          :placeholder="item.label"
        >
          <el-option
            v-for="(option, optionIndex) in item.options"
            :key="option.value + '-' + optionIndex"
            :label="option.description"
            :value="option.value.toString()"
          />
        </el-select>
        <el-date-picker
          v-if="item.type === 'date'"
          v-model="formModel[item.field]"
          type="date"
          :style="{ width: '139px' }"
          :editable="false"
          :value-format="'yyyy-MM-dd'"
          :placeholder="item.label"
        />
        <el-date-picker
          v-if="item.type === 'dateTimeRange'"
          v-model="formModel[item.field]"
          :type="item.rangeType"
          :style="{ width: '260px' }"
          :start-placeholder="item.labelStart"
          :end-placeholder="item.labelEnd"
          :editable="false"
          :value-format="'yyyy-MM-dd'"
          :picker-options="pickerOptions[item.field]"
        />
      </el-form-item>
    </template>
    <el-form-item v-if="getKeywordFields.length > 0">
      <el-input v-model="keywordValue" placeholder="请输入内容" clearable>
        <el-select
          slot="prepend"
          v-model="keywordField"
          :style="{ width: '100px' }"
          value=""
        >
          <el-option
            v-for="(item, index) in getKeywordFields"
            :key="index"
            :label="item.label"
            :value="item.field"
          />
        </el-select>
      </el-input>
    </el-form-item>
    <el-form-item>
      <el-button :plain="true" type="default" native-type="submit">
        搜索
      </el-button>
      <el-button :plain="true" type="info" native-type="reset">
        重置
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
export default {
  name: 'SearchForm',
  props: {
    searchFields: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  inject: ['reload'],
  data() {
    return {
      formModel: {},
      formModelInit: false,
      keywordField: '',
      keywordValue: '',
      pickerOptions: {},
      pickerOptionsInit: false
    }
  },
  computed: {
    getKeywordFields() {
      if (this.searchFields === null) {
        return []
      }

      return this.searchFields.filter(item => item.type === 'keyword')
    },
    getOtherFields() {
      if (this.searchFields === null) {
        return []
      }

      return this.searchFields.filter(item => item.type !== 'keyword')
    }
  },
  watch: {
    searchFields: function() {
      this.updateFormModel()
      this.updatePickerOptions()
    },
    '$route.query': 'updateFormModel'
  },
  mounted() {
    if (!this.formModelInit) {
      this.updateFormModel()
    }

    if (!this.pickerOptionsInit) {
      this.updatePickerOptions()
    }
  },
  methods: {
    isPageQuery(query) {
      return query === 'page' || query === 'size'
    },
    updatePickerOptions() {
      const pickerOptions = {}

      for (const otherField of this.getOtherFields) {
        if (otherField.type !== 'dateTimeRange') {
          continue
        }

        if (!otherField.shortcuts || otherField.shortcuts.length === 0) {
          continue
        }

        pickerOptions[otherField.field] = {
          shortcuts: []
        }

        otherField.shortcuts.forEach(shortcut => {
          pickerOptions[otherField.field].shortcuts.push({
            text: shortcut.text,
            onClick(picker) {
              picker.$emit('pick', [shortcut.start, shortcut.end])
            }
          })
        })
      }

      this.pickerOptions = pickerOptions
      this.pickerOptionsInit = true
    },
    updateFormModel() {
      const routeQuery = this.$route.query
      this.formModel = {}
      this.keywordField = ''
      this.keywordValue = ''

      const keywordFields = this.getKeywordFields

      if (this.keywordField === '' && keywordFields.length > 0) {
        this.keywordField = keywordFields[0].field
      }

      for (const field of keywordFields) {
        if (routeQuery.hasOwnProperty(field.field)) {
          this.keywordField = field.field
          this.keywordValue = routeQuery[field.field]
          this.formModel[field.field] = routeQuery[field.field]
        } else {
          this.formModel[field.field] = ''
        }
      }

      const otherFields = this.getOtherFields

      for (const field of otherFields) {
        if (field.type === 'br') {
          continue
        }

        if (field.type === 'select' && field.multiple) {
          if (routeQuery.hasOwnProperty(field.field)) {
            const routeQueryValue = routeQuery[field.field]

            this.formModel[field.field] = Array.isArray(routeQueryValue)
              ? routeQueryValue
              : [routeQueryValue.toString()]
          } else {
            this.formModel[field.field] = []
          }
        } else {
          if (routeQuery.hasOwnProperty(field.field)) {
            this.formModel[field.field] = routeQuery[field.field]
          } else {
            this.formModel[field.field] = ''
          }
        }
      }

      this.formModelInit = true
    },
    getQueryFields() {
      const queryFields = {}

      Object.keys(this.formModel).forEach(key => {
        if (this.formModel[key] !== '') {
          queryFields[key] = this.formModel[key]
        }
      })

      Object.keys(this.$route.query).forEach(key => {
        if (!this.formModel.hasOwnProperty(key) && !this.isPageQuery(key)) {
          queryFields[key] = this.$route.query[key]
        }
      })

      if (this.keywordField !== '') {
        queryFields[this.keywordField] = this.keywordValue
      }

      return queryFields
    },
    getDefaultQuery() {
      const defaultQuery = {}

      Object.keys(this.$route.query).forEach(key => {
        if (!this.formModel.hasOwnProperty(key) && !this.isPageQuery(key)) {
          defaultQuery[key] = this.$route.query[key]
        }
      })

      return defaultQuery
    },
    handleFormSubmit() {
      const queryFields = this.getQueryFields()

      if (JSON.stringify(this.$route.query) === JSON.stringify(queryFields)) {
        this.reload()
      } else {
        this.$router.push({
          path: this.$route.path,
          query: queryFields
        })
      }
    },
    handleFormReset() {
      this.$router.push({
        path: this.$route.path,
        query: this.getDefaultQuery()
      })
    }
  }
}
</script>
