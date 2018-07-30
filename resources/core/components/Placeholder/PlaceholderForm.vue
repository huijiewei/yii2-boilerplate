<template>
  <div class="placeholder-form">
    <div class="placeholder-form-row"
         :style="{ marginBottom: lineSpacing ? lineSpacing : '22px'}"
         :key="idx + '_' + row" v-for="(row, idx) in rowArray">
      <div class="placeholder-form-label">
        <placeholder-text-row
          :line-spacing="'0'"
          :height="'30px'"
          :width="formLabelWidth + 'px'"></placeholder-text-row>
      </div>
      <div class="placeholder-form-field" style="width: 100%; margin-left: 10px;">
        <placeholder-text-row
          :line-spacing="'0'"
          :height="'40px'"
          :width="(rowWidths[idx] ? rowWidths[idx] : '60') + '%'"></placeholder-text-row>
      </div>
    </div>
    <div class="placeholder-form-row">
      <div class="placeholder-form-field" :style="{width: '100%', marginLeft: (formLabelWidth + 10) + 'px'}">
        <placeholder-text-row
          :line-spacing="'0'"
          :height="'40px'"
          :width="'120px'"></placeholder-text-row>
      </div>
    </div>
  </div>
</template>

<script>
  import PlaceholderTextRow from '@core/components/Placeholder/PlaceholderTextRow'

  export default {
    name: 'PlaceholderForm',
    components: { PlaceholderTextRow },
    props: ['rows', 'color', 'widths', 'labelWidth', 'lineSpacing'],
    data() {
      return {
        rowArray: new Array(this.rows || 6),
        rowWidths: this.widths || [65, 70, 55, 35, 50, 60],
        formLabelWidth: this.labelWidth || 90
      }
    }
  }
</script>

<style lang="scss">
  .placeholder-form {
    display: block;
  }

  .placeholder-form-row {
    display: flex;
    align-items: center;
  }
</style>
