<template>
  <upload
    ref="upload"
    :value="value"
    :action="'misc/image-upload-option'"
    :multiple="multiple"
    :preview="preview"
    :cropper="cropper"
    :thumbs="thumbs"
    :default-thumb="defaultThumb"
    @change="handleChange"
    @on-upload-success="handleUploadSuccess"
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
      default: null,
    },
    cropper: {
      type: Object,
      default: function () {
        return {
          enable: false,
          aspectRatio: 1,
          size: [200, 200],
        }
      },
    },
    multiple: {
      type: Boolean,
      default: false,
    },
    preview: {
      type: Array,
      default: function () {
        return [88, 88]
      },
    },
    thumbs: {
      type: Array,
      default: null,
    },
    defaultThumb: {
      type: String,
      default: '',
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

    getThumbFile(upload, thumb) {
      return this.$refs.upload.getThumbFile(upload, thumb)
    },
  },
}
</script>
