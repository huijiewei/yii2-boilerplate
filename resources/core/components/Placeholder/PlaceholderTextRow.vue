<template>
  <div class="placeholder-text-row placeholder-animation" :style="styles"></div>
</template>

<script>
  export default {
    name: 'PlaceholderTextRow',
    props: ['color', 'width', 'height', 'lineSpacing'],
    data() {
      return {
        styles: {
          width: this.width || '100%',
          height: this.height || '1em',
          backgroundColor: this.color || '#f0f0f0',
          marginTop: this.lineSpacing || '0.7em'
        }
      }
    }
  }
</script>

<style lang="scss">
  @import "animation.scss";

  .placeholder-text-row {
    display: block;
    border-radius: 3px;
  }
</style>
