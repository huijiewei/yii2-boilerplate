<template>
  <div class="box">
    <el-row :gutter="15">
      <el-col :span="6">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>单文件上传</span>
          </div>
          <file-upload :multiple="false" v-model="file" />
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>单图片上传</span>
          </div>
          <image-upload :multiple="false" v-model="file" />
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>缩略图上传</span>
          </div>
          <image-upload
            :multiple="false"
            :thumbs="['200x200', '300x300']"
            :default-thumb="'200x200'"
            v-model="file"
            @on-upload-success="handleChange"
          />
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>单图片上传切割</span>
          </div>
          <image-upload
            :multiple="false"
            :cropper="{ enable: true }"
            v-model="file"
          />
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>单图片上传切割加缩略图</span>
          </div>
          <image-upload
            :multiple="false"
            :thumbs="['200x200', '300x300']"
            :default-thumb="'200x200'"
            :cropper="{ enable: true }"
            v-model="file"
          />
        </el-card>
      </el-col>
    </el-row>
    <hr />
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>多文件上传</span>
      </div>
      <file-upload :multiple="true" v-model="files" />
    </el-card>
    <hr />
    <el-row :gutter="15">
      <el-col :span="12">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>多图片上传</span>
          </div>
          <image-upload
            ref="imageUpload"
            :multiple="true"
            :cropper="{ enable: false }"
            v-model="files"
            @change="handleChange"
          />
        </el-card>
      </el-col>
      <el-col :span="12">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>多图片上传切割</span>
          </div>
          <image-upload
            :multiple="true"
            :cropper="{ enable: true }"
            v-model="files"
          />
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import FileUpload from '@admin/components/upload/FileUpload'
import ImageUpload from '@admin/components/upload/ImageUpload'
export default {
  name: 'Home',
  components: { ImageUpload, FileUpload },
  metaInfo: {
    title: '首页',
  },
  data() {
    return {
      file: '',
      files: [],
      message: '',
    }
  },
  methods: {
    handleChange(value) {
      console.log(value)
    },
  },
}
</script>
