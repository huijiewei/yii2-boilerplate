<template>
  <i :class="['anticon','anticon-' +type]"></i>
</template>

<script>
  export default {
    name: 'BpIcon',
    props: ['type']
  }
</script>
<style lang="less">
  @import '../../assets/icons/iconfont.less';
</style>
