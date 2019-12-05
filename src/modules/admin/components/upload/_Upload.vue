<template>
  <div
    class="upload-widget"
    :class="preview ? 'upload-widget-preview' : 'upload-widget-general'"
  >
    <ul class="el-upload-list el-upload-list--picture-card">
      <template v-if="multiple">
        <li
          class="el-upload-list__item is-ready"
          v-if="uploadFiles.length === 0"
          :style="{
            width: box.width,
            minWidth: box.height,
            height: box.height
          }"
        >
          <div class="blank">
            <i
              :class="preview ? 'el-icon-picture-outline' : 'el-icon-document'"
            />
          </div>
        </li>
        <li
          class="el-upload-list__item is-ready"
          v-else
          :style="{ width: box.width, height: box.height }"
          v-for="file of uploadFiles"
          v-bind:key="file.name"
        >
          <img
            class="preview"
            v-if="preview"
            :alt="file.name"
            :src="file.url"
          />
          <span class="generate" v-else>{{ file.name }}</span>
          <span class="el-upload-list__item-actions">
            <span
              v-if="preview"
              class="el-upload-list__item-preview"
              @click="handlePreview(file)"
            >
              <i class="el-icon-zoom-in" />
            </span>
            <span
              class="el-upload-list__item-delete"
              @click="handleRemove(file)"
            >
              <i class="el-icon-delete" />
            </span>
          </span>
        </li>
      </template>
      <template v-else>
        <li
          class="el-upload-list__item is-ready"
          v-if="uploadFiles.url.length === 0"
          :style="{
            width: box.width,
            minWidth: box.height,
            height: box.height
          }"
        >
          <div class="blank">
            <i
              :class="preview ? 'el-icon-picture-outline' : 'el-icon-document'"
            />
          </div>
        </li>
        <li
          class="el-upload-list__item is-ready"
          v-else
          :style="{ width: box.width, height: box.height }"
        >
          <img
            class="preview"
            v-if="preview"
            :alt="uploadFiles.name"
            :src="uploadFiles.url"
          />
          <span class="generate" v-else>{{ uploadFiles.name }}</span>
          <span class="el-upload-list__item-actions">
            <span
              v-if="preview"
              class="el-upload-list__item-preview"
              @click="handlePreview(uploadFiles)"
            >
              <i class="el-icon-zoom-in" />
            </span>
            <span
              class="el-upload-list__item-delete"
              @click="handleRemove(uploadFiles)"
            >
              <i class="el-icon-delete" />
            </span>
          </span>
        </li>
      </template>
    </ul>
    <el-upload
      :disabled="buttonDisabled"
      :action="option.url"
      :accept="option.typesLimit.map(type => '.' + type).join(', ')"
      :multiple="false"
      :show-file-list="false"
      :http-request="getHttpRequest"
      :before-upload="handleBeforeUpload"
      :on-success="handleSuccess"
      :on-error="handleError"
    >
      <el-button
        :disabled="buttonDisabled"
        size="mini"
        plain
        icon="el-icon-upload"
        >点击上传</el-button
      >
    </el-upload>
    <el-dialog :visible.sync="dialogVisible">
      <img width="100%" :src="dialogImageUrl" alt="" />
    </el-dialog>
    <image-cropper
      v-if="cropperImage"
      :image="cropperImage"
      :crop-url="option.cropUrl"
      :aspect-ratio="1"
      :cropper-size="[200, 200]"
      @on-cancel="handleImageCropperCancel"
      @on-success="handleImageCropperSuccess"
    />
  </div>
</template>

<script>
import Request from '@core/utils/request'
import flatry from '@core/utils/flatry'
import ImageCropper from '@admin/components/ImageCropper'

export default {
  name: 'Upload',
  components: { ImageCropper },
  props: {
    files: {
      type: [Array, String],
      default: null
    },
    filenameHash: {
      type: String,
      default: 'random'
    },
    action: {
      type: String,
      default: ''
    },
    multiple: {
      type: Boolean,
      default: false
    },
    preview: {
      type: Array,
      default: null
    },
    cropper: {
      type: Object,
      default: function() {
        return {
          enable: false,
          aspectRatio: 1,
          size: [200, 200]
        }
      }
    },
    imageStyle: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      box: { width: 'auto', height: '32px' },
      timer: null,
      option: {
        url: '',
        cropUrl: '',
        timeout: 0,
        params: [],
        headers: [],
        dataType: '',
        paramName: '',
        imageProcess: '',
        responseParse: '',
        sizeLimit: 0,
        typesLimit: []
      },
      buttonDisabled: true,
      uploadFiles: this.multiple ? [] : { name: '', url: '' },
      cropperImage: null,
      dialogVisible: false,
      dialogImageUrl: ''
    }
  },
  async mounted() {
    if (this.preview) {
      this.box = {
        width: this.preview[0] - 2 + 'px',
        height: this.preview[1] - 2 + 'px'
      }
    }

    if (this.files) {
      if (this.multiple) {
        this.uploadFiles = this.files.map(url => {
          return {
            name: this.getFilename(url),
            url: url
          }
        })
      } else {
        this.uploadFiles = {
          name: this.getFilename(this.files),
          url: this.files
        }
      }
    }

    await this.updateOption()
  },
  beforeDestroy() {
    if (this.timer != null) {
      clearTimeout(this.timer)
    }
  },
  methods: {
    async updateOption() {
      this.buttonDisabled = true

      const { data } = await flatry(this.$http.get(this.action))

      if (data) {
        this.option = data
        this.buttonDisabled = false

        if (data.timeout && data.timeout > 0) {
          this.timer = setTimeout(this.updateOption, data.timeout * 1000)
        }
      }
    },

    getFilename(url) {
      return url
        .split('/')
        .pop()
        .split('#')
        .shift()
        .split('?')
        .shift()
    },

    updateFiles(url) {
      const file = { name: this.getFilename(url), url: url }

      if (this.multiple) {
        this.uploadFiles.push(file)
      } else {
        this.uploadFiles = file
      }

      this.$emit('on-upload-success', file)

      this.updateValue()
    },

    updateValue() {
      if (this.multiple) {
        this.$emit(
          'on-success',
          this.uploadFiles.map(file => file.url)
        )
      } else {
        this.$emit('on-success', this.uploadFiles.url)
      }
    },

    getHttpRequest(option) {
      const request = new Request({
        baseUrl: option.action,
        withCredentials: option.withCredentials,
        onSuccess: response => option.onSuccess(response.data),
        onError: error => option.onError(error)
      })

      const headers = this.option.headers

      if (headers && Array.isArray(headers)) {
        request.httpClient.interceptors.request.use(config => {
          for (let key in headers) {
            config.headers[key] = headers[key]
          }

          return config
        }, undefined)
      }

      const params = this.option.params

      const formData = new FormData()

      if (params) {
        for (let key in params) {
          const value = params[key]
          // eslint-disable-next-line no-template-curly-in-string
          if (value.toString().indexOf('${filename}') !== -1) {
            let randomFileName = ''

            if (this.filenameHash === 'original') {
              randomFileName =
                Math.random()
                  .toString(36)
                  .slice(-8) +
                '_' +
                option.file.name
            } else {
              randomFileName =
                Math.random()
                  .toString(36)
                  .substring(3, 15) +
                Math.random()
                  .toString(36)
                  .substring(3, 15) +
                '.' +
                option.file.name.split('.').pop()
            }

            // eslint-disable-next-line no-template-curly-in-string
            formData.append(
              key,
              value.toString().replace('${filename}', randomFileName)
            )
          } else {
            formData.append(key, value)
          }
        }
      }

      formData.append(this.option.paramName, option.file, option.file.name)

      this.buttonDisabled = true

      request.post(option.action, formData)
    },

    humanFileSize(size) {
      const i = Math.floor(Math.log(size) / Math.log(1024))
      return (
        (size / Math.pow(1024, i)).toFixed(2) * 1 +
        ' ' +
        ['B', 'kB', 'MB', 'GB', 'TB'][i]
      )
    },

    handleBeforeUpload(file) {
      const sizeLimit = this.option.sizeLimit
      if (file.size > sizeLimit) {
        this.$message({
          type: 'error',
          message:
            '你选择的文件大小超出上传限制:' + this.humanFileSize(sizeLimit),
          duration: 1500
        })

        return false
      }

      return true
    },

    appendImageStyle(url, imageStyle) {
      if (imageStyle.length === 0 || this.option.imageProcess.length === 0) {
        return url
      }

      const imageProcess = new Function(
        'url',
        'imageStyle',
        this.option.imageProcess
      )

      return imageProcess(url, imageStyle)
    },

    handleSuccess(response) {
      this.buttonDisabled = false

      const result =
        this.option.dataType === 'xml'
          ? new DOMParser().parseFromString(response, 'application/xml')
          : response

      // eslint-disable-next-line no-new-func
      const responseParse = new Function('result', this.option.responseParse)

      let url = responseParse(result)

      if (url) {
        if (
          this.cropper.enable &&
          this.option.cropUrl &&
          this.option.cropUrl.length > 0
        ) {
          this.cropperImage = url
        } else {
          this.updateFiles(this.appendImageStyle(url, this.imageStyle))
        }
      }
    },

    handleError(error) {
      this.buttonDisabled = false

      const message =
        error.response.data.detail ||
        error.response.data.title ||
        error.response.data.message ||
        error.response.statusText ||
        error.message

      this.$message({
        type: 'error',
        message: message,
        duration: 1500
      })
    },

    handleRemove(file) {
      if (Array.isArray(this.uploadFiles)) {
        this.uploadFiles = this.uploadFiles.filter(uploadFile => {
          return uploadFile.url !== file.url
        })
      } else {
        this.uploadFiles = { name: '', url: '' }
      }

      this.updateValue()
    },

    handlePreview(file) {
      this.dialogImageUrl = file.url
      this.dialogVisible = true
    },

    handleImageCropperSuccess(url) {
      this.cropperImage = null
      this.updateFiles(this.appendImageStyle(url, this.imageStyle))
    },

    handleImageCropperCancel() {
      this.cropperImage = null
    }
  }
}
</script>
<style lang="scss">
@import '../../../../core/assets/styles/mixin.scss';
.upload-widget {
  line-height: 1em;

  .el-upload-list--picture-card .el-upload-list__item-actions {
    font-size: 16px;
  }
  .el-upload-list--picture-card .el-upload-list__item {
    border-radius: 2px;
    margin: 0 6px 6px 0;
    border: none;
    background: #f5f7fa;

    .blank {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: 100%;
      background: #f5f7fa;
      color: #909399;
    }

    .generate {
      line-height: 32px;
      padding: 0 6px;
    }

    .preview {
      width: 100%;
      height: 100%;
    }
  }
  &.upload-widget-general {
  }
  &.upload-widget-preview {
    .blank {
      i {
        font-size: 39px;
      }
    }
  }
}
</style>
