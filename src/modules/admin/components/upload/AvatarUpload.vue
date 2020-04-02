<template>
  <image-upload
    :multiple="false"
    :value="value"
    :thumbs="['200x200']"
    :default-thumb="'200x200'"
    :cropper="{ enable: true }"
    @change="handleChange"
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
      default: null,
    },
  },
  model: {
    prop: 'value',
    event: 'change',
  },
  methods: {
    handleChange(files) {
      this.$emit('change', files)
    },
  },
}
</script>
