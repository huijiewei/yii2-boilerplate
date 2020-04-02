<template>
  <upload
    :action="'misc/file-upload-option'"
    :multiple="multiple"
    :value="value"
    @change="handleChange"
    @on-upload-success="handleUploadSuccess"
  />
</template>

<script>
import Upload from '@admin/components/upload/_Upload'

export default {
  name: 'FileUpload',
  components: { Upload },
  props: {
    value: {
      type: [Array, String],
      default: null,
    },
    multiple: {
      type: Boolean,
      default: false,
    },
  },
  model: {
    prop: 'value',
    event: 'change',
  },
  methods: {
    handleChange(value) {
      this.$emit('change', value)
    },

    handleUploadSuccess(upload) {
      this.$emit('on-upload-success', upload)
    },
  },
}
</script>
