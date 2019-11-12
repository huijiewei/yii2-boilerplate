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
      <hr
        v-if="item.type==='br'"
        :key="index"
        class="br"
      >
      <el-form-item
        v-else
        :key="index"
      >
        <el-select
          v-if="item.type==='select'"
          v-model="formModel[item.field]"
          :multiple="item.multiple"
          :clearable="true"
          :placeholder="item.label"
          value=""
        >
          <template v-for="(optionLabel, optionValue, optionIndex) in item.options">
            <el-option
              :key="index + '-' + optionIndex"
              :label="optionLabel"
              :value="optionValue"
            />
          </template>
        </el-select>
        <el-date-picker
          v-if="item.type==='date'"
          v-model="formModel[item.field]"
          type="date"
          :style="{width:'139px'}"
          :editable="false"
          :value-format="'yyyy-MM-dd'"
          :placeholder="item.label"
        />
        <el-date-picker
          v-if="item.type==='dateRange'"
          v-model="formModel[item.field]"
          type="daterange"
          :style="{width:'260px'}"
          :start-placeholder="item.labelStart"
          :end-placeholder="item.labelEnd"
          :editable="false"
          :value-format="'yyyy-MM-dd'"
        />
      </el-form-item>
    </template>
    <el-form-item v-if="getKeywordFields.length > 0">
      <el-input
        v-model="keywordValue"
        placeholder="请输入内容"
        clearable
      >
        <el-select
          slot="prepend"
          v-model="keywordField"
          :style="{width: '100px'}"
          value=""
        >
          <template v-for="(item, index) in getKeywordFields">
            <el-option
              :key="index"
              :label="item.label"
              :value="item.field"
            />
          </template>
        </el-select>
      </el-input>
    </el-form-item>
    <el-form-item>
      <el-button
        :plain="true"
        type="default"
        native-type="submit"
      >
        搜索
      </el-button>
    </el-form-item>
    <el-form-item>
      <el-button
        :plain="true"
        type="info"
        native-type="reset"
      >
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
  data () {
    return {
      formInit: false,
      formModel: {},
      keywordField: '',
      keywordValue: ''
    }
  },
  computed: {
    getKeywordFields () {
      if (this.searchFields === null) {
        return []
      }

      return this.searchFields.filter(item => item.type === 'keyword')
    },
    getOtherFields () {
      if (this.searchFields === null) {
        return []
      }

      return this.searchFields.filter(item => item.type !== 'keyword')
    }
  },
  watch: {
    'searchFields': 'updateFormModel',
    '$route.query': 'updateFormModel'
  },
  mounted () {
    if (!this.formInit) {
      this.updateFormModel()
    }
  },
  methods: {
    isPageQuery (query) {
      return query !== 'page' && query !== 'size'
    },
    updateFormModel () {
      const routeQuery = this.$route.query
      const formModel = {}

      const keywordFields = this.getKeywordFields

      if (this.keywordField === '' && keywordFields.length > 0) {
        this.keywordField = keywordFields[0].field
      }

      Object.keys(routeQuery).every((item) => {
        const field = item
        const value = routeQuery[field]

        if (keywordFields.some((keyField) => {
          return keyField.field === field
        })) {
          this.keywordField = field
          this.keywordValue = value

          return true
        }

        if (this.getOtherFields.length === 0) {
          return true
        }

        this.getOtherFields.every((otherField) => {
          if (otherField.type === 'br') {
            return true
          }

          formModel[field] = otherField.multiple && typeof Array.isArray(value) ? value : [value + '']
        })

        return true
      })

      this.formInit = true
      this.formModel = formModel
    },
    getQueryFields () {
      const queryFields = {}

      Object.keys(this.formModel).forEach((key) => {
        if (this.formModel[key] && this.formModel[key].length > 0) {
          queryFields[key] = this.formModel[key]
        }
      })

      Object.keys(this.$route.query).forEach((key) => {
        if (!Object.prototype.hasOwnProperty.call(this.formModel, key) && !this.isPageQuery(key)) {
          queryFields[key] = this.$route.query[key]
        }
      })

      if (this.keywordField !== '' && this.keywordValue !== '') {
        queryFields[this.keywordField] = this.keywordValue
      }

      return queryFields
    },
    getDefaultQuery () {
      const defaultQuery = {}

      Object.keys(this.$route.query).forEach((key) => {
        if (!Object.prototype.hasOwnProperty.call(this.formModel, key) && !this.isPageQuery(key)) {
          defaultQuery[key] = this.$route.query[key]
        }
      })

      return defaultQuery
    },
    handleFormSubmit () {
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
    handleFormReset () {
      this.updateFormModel()

      this.$router.push({
        path: this.$route.path,
        query: this.getDefaultQuery()
      })
    }
  }
}
</script>
