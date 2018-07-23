<template>
  <el-upload
    class="avatar-uploader"
    :disabled="aliyunOssUpload.action === ''"
    :action="aliyunOssUpload.action"
    :data="aliyunOssUpload.data"
    :show-file-list="false"
    :on-success="handleSuccess">
    <img v-if="avatarUrl" :src="avatarUrl" class="avatar">
    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
  </el-upload>
</template>

<script>
  import flatry from '@admin/utils/flatry'

  export default {
    name: 'AliyunOssUploader',
    props: ['avatar'],
    data() {
      return {
        avatarUrl: this.avatar,
        aliyunOssUpload: {
          action: '',
          data: {}
        }
      }
    },
    async mounted() {
      const { data } = await flatry(this.$http.get('site/aliyun-oss-upload'))

      if (data) {
        this.aliyunOssUpload = data
      }
    },
    methods: {
      handleSuccess(response) {
        const xml = new DOMParser().parseFromString(response, 'application/xml')
        const url = xml.querySelector('PostResponse > Location').textContent

        if (url) {
          this.avatarUrl = url + '@!avatar'

          this.$emit('on-upload-success', this.avatarUrl)
        }
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

