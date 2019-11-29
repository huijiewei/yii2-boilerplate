<template>
  <image-upload
    :multiple="false"
    :value="value"
    :process="'avatar'"
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
    }
  }
}
</script>
