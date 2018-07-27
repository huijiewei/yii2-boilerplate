<template>
  <el-upload
    class="avatar-uploader"
    :disabled="uploadAction === ''"
    :action="uploadAction"
    :data="uploadData"
    :accept="'image/*'"
    :show-file-list="false"
    :http-request="httpRequest"
    :before-upload="handleBeforeUpload"
    :on-success="handleSuccess"
    :on-error="handleError">
    <img v-if="avatarUrl" :src="avatarUrl" class="avatar">
    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
  </el-upload>
</template>

<script>
  import flatry from '@admin/utils/flatry'
  import httpRequest from './AliyunOssUploaderHttpRequest'

  export default {
    name: 'AliyunOssUploader',
    props: ['avatar'],
    data() {
      return {
        avatarUrl: this.avatar,
        uploadAction: '',
        uploadData: null,
        uploadSizeLimit: 1024000
      }
    },
    async mounted() {
      const { data } = await flatry(this.$http.get('site/aliyun-oss-upload'))

      if (data) {
        this.uploadAction = data.action
        this.uploadData = data.data
        this.uploadSizeLimit = data.sizeLimit
      }
    },
    methods: {
      httpRequest(option) {
        option.data.key = option.data.key + '.' + option.file.name.split('.').pop()
        return httpRequest(option)
      },
      handleBeforeUpload(file) {
        if (file.size > this.uploadSizeLimit) {
          this.$message({
            type: 'error',
            message: '你选择的文件大小超出上传限制',
            duration: 1500
          })

          return false
        }

        return true
      },
      handleSuccess(response) {
        const xml = new DOMParser().parseFromString(response, 'application/xml')
        const url = xml.querySelector('PostResponse > Location').textContent

        if (url) {
          this.avatarUrl = url + '@!avatar'

          this.$emit('on-upload-success', this.avatarUrl)
        }
      },
      handleError(error) {
        const xml = new DOMParser().parseFromString(error.message, 'application/xml')
        const message = xml.querySelector('Error > Message').textContent

        this.$message({
          type: 'error',
          message: message,
          duration: 1500
        })
      }
    }
  }
</script>
<style lang="scss">
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 3px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .avatar-uploader .el-upload:hover {
    border-color: #409eff;
  }

  .avatar-uploader-icon {
    font-size: 16px;
    color: #8c939d;
    width: 90px;
    height: 90px;
    line-height: 90px;
    text-align: center;
  }

  .avatar {
    width: 90px;
    height: 90px;
    display: block;
  }
</style>

