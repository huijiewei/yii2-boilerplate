<template>
  <span class="ag-avatar" :style="sizeStyle">
    <img v-if="src && src.length > 0" :alt="alt || '头像'" :src="src" />
    <img v-else :alt="alt || '头像'" src="../../assets/images/avatar.png" />
  </span>
</template>

<script>
export default {
  name: 'AgAvatar',
  props: {
    src: {
      type: String,
      default: '',
    },
    alt: {
      type: String,
      default: null,
    },
    size: {
      type: Number,
      default: 32,
    },
  },
  computed: {
    sizeStyle() {
      const size = this.size
      return typeof size === 'number'
        ? {
            height: `${size}px`,
            width: `${size}px`,
          }
        : {}
    },
  },
}
</script>

<style lang="less">
.ag-avatar {
  display: inline-block;
  border-radius: 50%;
  overflow: hidden;
  line-height: 0;
  vertical-align: middle;

  img {
    display: block;
    height: 100%;
  }
}
</style>
