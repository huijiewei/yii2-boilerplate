<template>
  <div class="dynamic-select">
    <el-select v-bind="$attrs" v-on="$listeners">
      <template
        v-for="(_, slotName) in $scopedSlots"
        v-slot:[slotName]="slotProps"
      >
        <slot :name="slotName" v-bind="slotProps"></slot>
      </template>
    </el-select>
    &nbsp;
    <el-button
      :size="buttonSize"
      title="刷新选项数据"
      icon="el-icon-refresh"
      @click="handleClick"
    ></el-button>
  </div>
</template>

<script>
export default {
  name: 'DynamicSelect',
  props: {
    buttonSize: {
      type: String,
      default: 'mini',
    },
  },
  methods: {
    handleClick() {
      this.$emit('refresh')
    },
  },
}
</script>

<style lang="scss"></style>
