<template>
  <upload
    :action="'misc/image-upload-option'"
    :multiple="multiple"
    :preview="preview"
    :files="value"
    :cropper="cropper"
    @on-success="handleSuccess"
  />
</template>

<script>
import Upload from '@admin/components/upload/_Upload'

export default {
  name: 'ImageUpload',
  components: { Upload },
  props: {
    value: {
      type: [Array, String],
      default: null
    },
    cropper: {
      type: Object,
      default: function() {
        return {
          enable: true,
          aspectRatio: 1,
          size: [200, 200]
        }
      }
    },
    multiple: {
      type: Boolean,
      default: false
    },
    preview: {
      type: Array,
      default: function() {
        return [90, 90]
      }
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
