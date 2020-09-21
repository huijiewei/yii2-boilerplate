<template>
  <div class="box">
    <br />
    <h4>特点</h4>
    <ol>
      <li>
        <p>模块化开发模版</p>
      </li>
      <li>
        <p>使用 dotenv 环境变量配置敏感数据</p>
      </li>
      <li>
        <p>更灵活的目录结构</p>
      </li>
      <li>
        <p>使用 PSR-4 自动加载</p>
      </li>
      <li>
        <p>代码风格规范符合 PSR-2,PSR-12</p>
      </li>
      <li>
        <p>后台管理系统使用 Vue.js + Element UI + webpack 4 构建</p>
      </li>
      <li>
        <p>
          默认开启本地开发环境 HTTPS 和 HTTP2 支持（webpack-serve 未开启 HTTP2）
        </p>
      </li>
    </ol>
  </div>
</template>

<script>
export default {
  metaInfo: {
    title: '首页',
  },
  data() {
    return {
      message: '',
    }
  },
  created() {},
}
</script>
