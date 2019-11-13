<template>
  <span
    class="ag-avatar"
  >
    <img
      v-if="src && src.length > 0"
      :alt="alt || '头像'"
      :src="src"
    >
    <img
      v-else
      :alt="alt || '头像'"
      src="../../assets/images/avatar.png"
    >
  </span>
</template>

<script>
export default {
  name: 'AgAvatar',
  props: {
    src: {
      type: String,
      default: ''
    },
    alt: {
      type: String,
      default: null
    }
  },
  computed: {
    sizeStyle () {
      const size = this.size
      return typeof size === 'number' ? {
        height: `${size}px`,
        width: `${size}px`,
        lineHeight: `${size}px`
      } : {}
    }
  }
}
</script>

<style lang="scss">
  .ag-avatar {
    display: inline-block;
    height: 32px;

    img {
      height: 32px;
      border-radius: 50%;
      vertical-align: middle;
    }
  }
</style>
