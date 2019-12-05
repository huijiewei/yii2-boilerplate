<template>
  <image-upload
    :multiple="false"
    :value="value"
    :image-style="'avatar'"
    @change="handleChange"
    @on-upload-success="handleUploadSuccess"
  />
</template>

<script>
import ImageUpload from '@admin/components/upload/ImageUpload'

export default {
  name: 'AvatarUpload',
  components: { ImageUpload },
  props: {
    value: {
      type: [Array, String],
      default: null
    }
  },
  model: {
    prop: 'value',
    event: 'change'
  },
  methods: {
    handleChange(files) {
      this.$emit('change', files)
    },

    handleUploadSuccess(file) {
      this.$emit('on-upload-success', file)
    }
  }
}
</script>
