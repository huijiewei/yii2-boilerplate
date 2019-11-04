VUE + ELEMENT.UI 演示项目

项目目前正在开发，变动可能会很大，暂时只供研究学习参考

### 特点

1. 基于 VUE CLI

2. 自带 Mock 服务器

3. 使用 .env 配置环境变量

### 教程

#### 安装

```bash
npm install
```

#### 运行本地开发

```bash
npm run serve
```

#### 本地开发访问方法
http://localhost:8080/admin

http://localhost:8080/mobile

#### 构建生产版本

```bash
npm run build
```

### 关键目录说明
```
├── dist // 生成的生产环境文件
├── mocker // Mock 服务器和 Mock 数据
├── src // 源代码目录
│   ├── core // 公用核心模块
│   │   ├── assets
│   │   ├── components
│   │   └── styles
│   └── modules // 模块目录
│      └── admin // 管理后台
│      │   ├── assets
│      │   ├── components
│      │   ├── plugins
│      │   ├── router
│      │   ├── services
│      │   ├── store
│      │   ├── utils
│      │   └── views
│      └── mobile // 移动端
```

### 其他说明

默认 Mock 服务后台管理员：

用户：13012345678
密码：123456

### 说明文件版本更新

Version: 2019-11-01 11:11
