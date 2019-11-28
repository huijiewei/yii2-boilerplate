<template>
  <upload
    :action="'misc/file-upload-option'"
    :multiple="multiple"
    :files="value"
    @on-success="handleSuccess"
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
      default: null
    },
    multiple: {
      type: Boolean,
      default: false
    }
  },
  model: {
    prop: 'value',
    event: 'change'
  },
  methods: {
    handleSuccess(files) {
      this.$emit('change', files)
    }
  }
}
</script>
