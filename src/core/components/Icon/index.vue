<template>
  <i :class="['anticon', 'anticon-' + type]" />
</template>

<script>
export default {
  name: 'AgIcon',
  props: {
    type: {
      type: String,
      required: true
    }
  }
}
</script>
<style lang="less">
@import '../../assets/icons/iconfont.less';
</style>
