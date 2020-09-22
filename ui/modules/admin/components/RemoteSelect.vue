<template>
  <div v-show="options">
    <el-select
      :disabled="disabled"
      :value="value"
      v-bind="$attrs"
      v-on="$listeners"
    >
      <el-option
        v-for="option in options"
        :key="option[optionValue]"
        :label="option[optionLabel]"
        :value="option[optionValue]"
      />
    </el-select>
    &nbsp;
    <el-button
      :disabled="disabled"
      size="mini"
      :title="refreshButtonTitle || '刷新选项数据'"
      icon="el-icon-refresh"
      @click="loadOptions"
    ></el-button>
  </div>
</template>

<script>
export default {
  name: 'RemoteSelect',
  props: {
    value: {
      required: true,
    },
    disabled: Boolean,
    remoteMethod: {
      type: Function,
      required: true,
    },
    refreshButtonTitle: String,
    optionValue: {
      required: true,
    },
    optionLabel: {
      required: true,
    },
  },
  data() {
    return {
      options: null,
    }
  },
  created() {
    this.loadOptions()
  },
  methods: {
    loadOptions() {
      this.remoteMethod((options) => {
        this.options = options
      })
    },
  },
}
</script>

<style scoped></style>
