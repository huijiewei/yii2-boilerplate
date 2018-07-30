<template>
  <div class="placeholder-text-block">
    <placeholder-text-row
      v-for="(row, idx) in rowArray"
      :key="idx + '_' + row"
      :color="color"
      :width="(rowWidths[idx] ? rowWidths[idx] : '100') + '%'"
      :line-spacing="idx === 0 ? '0' : rowLineSpacing">
    </placeholder-text-row>
  </div>
</template>

<script>
  import PlaceholderTextRow from '@core/components/Placeholder/PlaceholderTextRow'

  export default {
    name: 'PlaceholderTextBlock',
    components: { PlaceholderTextRow },
    props: ['rows', 'color', 'widths', 'lineSpacing'],
    data() {
      return {
        rowArray: new Array(this.rows || 6),
        rowWidths: this.widths || [95, 100, 90, 95, 80, 85, 50],
        rowLineSpacing: this.lineSpacing || '0.7em'
      }
    }
  }
</script>

<style lang="scss">
  .placeholder-text-block {
    display: block;
  }
</style>
