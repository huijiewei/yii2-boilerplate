<template>
  <el-upload
    class="avatar-upload"
    :disabled="uploadOptions.url === ''"
    :action="uploadOptions.url"
    :accept="'image/*'"
    :show-file-list="false"
    :http-request="httpRequest"
    :before-upload="handleBeforeUpload"
    :on-success="handleSuccess"
    :on-error="handleError">
    <img alt="头像" v-if="avatarUrl" :src="avatarUrl" class="avatar">
    <i v-else class="el-icon-plus avatar-upload-icon"></i>
  </el-upload>
</template>

<script>
  import flatry from '@admin/utils/flatry'
  import Request from '@admin/utils/request'

  export default {
    name: 'AvatarUpload',
    props: ['avatar', 'filenameHash'],
    data() {
      return {
        avatarUrl: this.avatar,
        uploadOptions: {
          url: '',
          params: [],
          headers: [],
          dataType: '',
          paramName: '',
          imageProcess: '',
          responseParse: '',
        }
      }
    },
    async mounted() {
      const {data} = await flatry(this.$http.get('site/upload-avatar-options'))

      if (data) {
        this.uploadOptions = data
      }
    },
    methods: {
      httpRequest(option) {
        console.log(option)
        const request = new Request({
          baseUrl: option.action,
          withCredentials: option.withCredentials,
          successHandler: (response) => option.onSuccess(response.data),
          errorHandler: (error) => option.onError(error)
        })

        const headers = this.uploadOptions.headers

        request.httpClient.interceptors.request.use((config) => {
          for (let h in headers) {
            config.headers[h] = headers[h]
          }

          return config
        }, undefined)

        const params = this.uploadOptions.params

        const formData = new FormData()

        for (let k in params) {
          if (params[k].toString().indexOf('${filename}') !== -1) {
            let randomFileName = ''

            if (this.filenameHash === 'original') {
              randomFileName = Math.random().toString(36).slice(-8) + '_' + option.file.name
            } else {
              randomFileName = Math.random().toString(36).substring(2, 16) + '_' + Math.random().toString(36).substring(2, 16) + '.' + option.file.name.split('.').pop()
            }


            formData.append(k, params[k].toString().replace('${filename}', randomFileName))
          } else {
            formData.append(k, params[k])
          }
        }

        formData.append(this.uploadOptions.paramName, option.file, option.file.name)

        request.post(option.action, formData)
      },
      handleBeforeUpload(file) {
        if (file.size > 1024 * 1024) {
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
        let result = ''

        if (this.uploadOptions.dataType === 'xml') {
          result = new DOMParser().parseFromString(response, 'application/xml')
        } else {
          result = response
        }

        const responseParse = new Function('result', this.uploadOptions.responseParse)

        const url = responseParse(result)

        if (url) {
          this.avatarUrl = url + (this.uploadOptions.imageProcess !== '' ? (this.uploadOptions.imageProcess + 'avatar') : '')

          this.$emit('on-upload-success', this.avatarUrl)
        }
      },
      handleError(error) {
        this.$message({
          type: 'error',
          message: error.message,
          duration: 1500
        })
      }
    }
  }
</script>
<style lang="scss">
  .avatar-upload .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 3px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .avatar-upload .el-upload:hover {
    border-color: #409eff;
  }

  .avatar-upload-icon {
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

