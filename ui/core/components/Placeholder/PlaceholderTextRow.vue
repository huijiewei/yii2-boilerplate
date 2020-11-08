<template>
  <div class="placeholder-text-row placeholder-animation" :style="styles" />
</template>

<script>
export default {
  name: 'PlaceholderTextRow',
  props: {
    color: {
      type: String,
      default: '',
    },
    width: {
      type: [String, Number],
      default: '100%',
    },
    height: {
      type: [String, Number],
      default: '100%',
    },
    lineSpacing: {
      type: String,
      default: '0.7em',
    },
  },
  data() {
    return {
      styles: {
        width: this.width || '100%',
        height: this.height || '1em',
        backgroundColor: this.color || '#f3f3f3',
        marginTop: this.lineSpacing || '0.7em',
      },
    }
  },
}
</script>

<style lang="less">
@import 'animation.less';

.placeholder-text-row {
  display: block;
  border-radius: 3px;
}
</style>
