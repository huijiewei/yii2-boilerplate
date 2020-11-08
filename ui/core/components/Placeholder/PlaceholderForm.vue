<template>
  <div class="placeholder-form">
    <div
      v-for="(row, idx) in rowArray"
      :key="idx + '_' + row"
      class="placeholder-form-row"
      :style="{ marginBottom: lineSpacing ? lineSpacing : '22px' }"
    >
      <div class="placeholder-form-label">
        <placeholder-text-row
          :line-spacing="'0'"
          :height="'30px'"
          :width="formLabelWidth + 'px'"
        />
      </div>
      <div
        class="placeholder-form-field"
        style="width: 100%; margin-left: 10px"
      >
        <placeholder-text-row
          :line-spacing="'0'"
          :height="'40px'"
          :width="(rowWidths[idx] ? rowWidths[idx] : '60') + '%'"
        />
      </div>
    </div>
    <div class="placeholder-form-row">
      <div
        class="placeholder-form-field"
        :style="{
          width: '100%',
          marginLeft: formLabelWidth + 10 + 'px',
        }"
      >
        <placeholder-text-row
          :line-spacing="'0'"
          :height="'40px'"
          :width="'120px'"
        />
      </div>
    </div>
  </div>
</template>

<script>
import PlaceholderTextRow from '@core/components/Placeholder/PlaceholderTextRow'

export default {
  name: 'PlaceholderForm',
  components: { PlaceholderTextRow },
  props: {
    rows: {
      type: Number,
      default: 6,
    },
    color: {
      type: String,
      default: '',
    },
    widths: {
      type: Array,
      default: () => {
        return [65, 70, 55, 35, 50, 60]
      },
    },
    labelWidth: {
      type: Number,
      default: 90,
    },
    lineSpacing: {
      type: String,
      default: '22px',
    },
  },
  data() {
    return {
      rowArray: new Array(this.rows || 6),
      rowWidths: this.widths || [65, 70, 55, 35, 50, 60],
      formLabelWidth: this.labelWidth || 90,
    }
  },
}
</script>

<style lang="less">
.placeholder-form {
  display: block;
}

.placeholder-form-row {
  display: flex;
  align-items: center;
}
</style>
