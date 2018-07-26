<template>
  <el-form :inline="true"
           :model="formModel"
           size="small"
           @submit.native.stop.prevent="handleSearchFormSubmit()">
    <el-form-item v-if="searchFields && searchFields.length > 0">
      <el-input placeholder="请输入内容" v-model="formModel.keyword">
        <el-select v-model="formModel.field" slot="prepend" :style="{width: '90px'}">
          <template v-for="(item, index) in searchFields">
            <el-option :key="index" :label="item.label" :value="item.field"></el-option>
          </template>
        </el-select>
      </el-input>
    </el-form-item>
    <el-form-item>
      <el-button :plain="true" type="info" native-type="submit">查询</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  export default {
    name: 'SearchForm',
    props: ['searchFields'],
    data() {
      return {
        formModel: {
          field: this.$route.query.field || null,
          keyword: this.$route.query.keyword || ''
        }
      }
    },
    watch: {
      'searchFields': 'updateDefaultField'
    },
    mounted() {
      this.updateDefaultField()
    },
    methods: {
      updateDefaultField() {
        if (this.formModel.field === null && this.searchFields && this.searchFields.length > 0) {
          this.formModel.field = this.searchFields[0].field
        }
      },
      handleSearchFormSubmit() {
        this.$router.push({
          path: this.$route.fullPath,
          query: {
            field: this.formModel.field,
            keyword: this.formModel.keyword,
            page: null
          }
        })
      }
    }
  }
</script>
