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
        v-model="formModel.keyword"
        placeholder="请输入内容"
      >
        <el-select
          slot="prepend"
          v-model="formModel.field"
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
  data () {
    return {
      formInit: false,
      formModel: {}
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

      return this.searchFields.filter(item => (item.type !== 'keyword' && item.type !== 'hidden'))
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
    updateFormModel () {
      const routeQuery = this.$route.query
      const formModel = {}

      if (this.getKeywordFields.length > 0) {
        formModel.field = routeQuery.field || this.getKeywordFields[0].field
        formModel.keyword = routeQuery.keyword || ''
      }

      if (this.getOtherFields.length > 0) {
        this.getOtherFields.forEach((item) => {
          if (item.type !== 'br') {
            if (routeQuery[item.field]) {
              formModel[item.field] = item.multiple && typeof (routeQuery[item.field]) === 'string'
                ? [routeQuery[item.field]]
                : routeQuery[item.field]
            } else {
              formModel[item.field] = item.multiple ? [] : ''
            }
          }
        })
      }

      this.formInit = true
      this.formModel = formModel
    },
    getQueryFields () {
      const queryFields = {}

      Object.keys(this.formModel).forEach((key) => {
        if (key !== 'field' && this.formModel[key] && this.formModel[key].length > 0) { queryFields[key] = this.formModel[key] }
      })

      if (queryFields['keyword'] && queryFields['keyword'].length > 0) {
        queryFields['field'] = this.formModel['field']
      }

      Object.keys(this.$route.query).forEach((key) => {
        if (!Object.prototype.hasOwnProperty.call(this.formModel, key) && key !== 'page') {
          queryFields[key] = this.$route.query[key]
        }
      })

      return queryFields
    },
    getDefaultQuery () {
      const defaultQuery = {}

      Object.keys(this.$route.query).forEach((key) => {
        if (!Object.prototype.hasOwnProperty.call(this.formModel, key) && key !== 'page') {
          defaultQuery[key] = this.$route.query[key]
        }
      })

      return defaultQuery
    },
    handleFormSubmit () {
      const queryFields = this.getQueryFields()

      if (JSON.stringify(this.$route.query) === JSON.stringify(queryFields)) {
        this.$router.replace({
          path: this.$route.path,
          query: queryFields
        })
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
