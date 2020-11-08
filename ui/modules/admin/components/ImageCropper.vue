<template>
  <el-dialog
    width="900"
    :custom-class="'image-cropper-dialog'"
    :visible="true"
    :show-close="false"
    center
    append-to-body
  >
    <vue-cropper
      ref="cropper"
      :src="image"
      :view-mode="2"
      :initial-aspect-ratio="aspectRatio"
      :aspect-ratio="aspectRatio"
      :zoomable="false"
      :rotatable="false"
      :movable="false"
      :check-orientation="false"
      :auto-crop-area="0.6"
      :min-crop-box-width="cropperSize[0] * 2"
      :min-crop-box-height="cropperSize[1] * 2"
      :ready="handleReady"
      :img-style="{ width: '100%' }"
      alt="Source Image"
    />
    <span slot="footer" class="dialog-footer">
      <el-button @click="handleCancel">取 消</el-button>
      <el-button :disabled="buttonDisabled" type="primary" @click="handleSubmit"
        >确 定</el-button
      >
    </span>
  </el-dialog>
</template>

<script>
import VueCropper from 'vue-cropperjs'
import 'cropperjs/dist/cropper.css'
import Request from '@core/utils/request'

export default {
  name: 'ImageCropper',
  components: { VueCropper },
  props: {
    image: {
      type: String,
      default: '',
    },
    aspectRatio: {
      type: Number,
      default: 1,
    },
    cropperSize: {
      type: Array,
      default: function () {
        return [100, 100]
      },
    },
    cropUrl: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      buttonDisabled: true,
    }
  },
  methods: {
    handleReady() {
      this.buttonDisabled = false
    },
    async handleSubmit() {
      this.buttonDisabled = true

      const request = new Request({
        withCredentials: true,
        onSuccess: (response) => {
          this.$emit('on-success', response.data)
        },
        onError: (error) => {
          const message =
            error.response.data.detail ||
            error.response.data.title ||
            error.response.data.message ||
            error.response.statusText ||
            error.message

          this.$message({
            type: 'error',
            message: message,
            duration: 1500,
          })

          this.buttonDisabled = false
        },
      })

      const data = this.$refs.cropper.getData()

      await request.post(this.cropUrl, {
        file: this.image,
        x: data.x,
        y: data.y,
        w: data.width,
        h: data.height,
      })
    },
    handleCancel() {
      this.$emit('on-cancel')
    },
  },
}
</script>

<style lang="less">
.image-cropper-dialog {
  .el-dialog__header {
    display: none;
  }
  .el-dialog__body {
    padding: 15px;
  }
  .el-dialog__footer {
    border-top: 1px solid #e5e5e5;
  }
}
</style>
