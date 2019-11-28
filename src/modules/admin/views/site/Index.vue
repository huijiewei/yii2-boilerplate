<template>
  <div class="box">
    <h4>特点</h4>
    <ol>
      <li>
        <p>基于 VUE CLI</p>
      </li>
      <li>
        <p>自带 Mock 服务器</p>
      </li>
      <li>
        <p>使用 .env 配置环境变量</p>
      </li>
    </ol>
    <p>
      <a href="https://github.com/huijiewei/agile-ui" target="_blank"
        >访问 Github 项目地址</a
      >
    </p>
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>单文件上传</span>
      </div>
      <p><file-upload :multiple="false" v-model="file" /></p>
    </el-card>
    <hr />
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>多文件上传</span>
      </div>
      <p><file-upload :multiple="true" v-model="files" /></p>
    </el-card>
    <hr />
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>单图片上传</span>
      </div>
      <p>
        <image-upload
          :multiple="false"
          :cropper="{ enable: false }"
          v-model="file"
        />
      </p>
    </el-card>
    <hr />
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>多图片上传</span>
      </div>
      <p>
        <image-upload
          :multiple="true"
          :cropper="{ enable: false }"
          v-model="files"
        />
      </p>
    </el-card>
    <hr />
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>单图片上传切割</span>
      </div>
      <p>
        <image-upload
          :multiple="false"
          :cropper="{ enable: true }"
          v-model="file"
        />
      </p>
    </el-card>
    <hr />
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>多图片上传切割</span>
      </div>
      <p>
        <image-upload
          :multiple="true"
          :cropper="{ enable: true }"
          v-model="files"
        />
      </p>
    </el-card>
  </div>
</template>

<script>
import FileUpload from '@admin/components/upload/FileUpload'
import ImageUpload from '@admin/components/upload/ImageUpload'
export default {
  components: { ImageUpload, FileUpload },
  metaInfo: {
    title: '首页'
  },
  data() {
    return {
      file: '',
      files: [],
      message: ''
    }
  },
  created() {}
}
</script>
