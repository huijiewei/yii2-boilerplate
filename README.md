前后端分类脚手架

### 特点

1. 模块化开发模版

2. 使用 dotenv 环境变量配置敏感数据

3. 更灵活的目录结构

4. 使用 PSR-4 自动加载

5. 代码风格规范符合 PSR-2,PSR-12

6. 前端使用 Vue.js + Element UI + Vue Cli 构建

### 在线演示
https://bp.huijiewei.com/admin
账号：13098761234
密码：123456

### 欢迎体验 VUE 和 Spring Boot 配合
https://github.com/huijiewei/agile-vue

https://github.com/huijiewei/agile-boot

### 安装

项目需要 PHP 7.3 以上版本

##### 安装 composer 和 npm 依赖包

```bash
composer install
npm install
```

##### 复制 .env.example 文件为 .env 并编辑配置

##### 开发服务器环境

###### 修改 Hosts
```text
127.0.0.1 www.bp.test
```

###### Nginx 配置
```text

server {
    listen      80;
    server_name www.bp.test;

    root {项目根目录}/public;
    index index.php index.html index.htm;

    rewrite ^/(.*)/$ /$1 permanent;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    include php-fpm;
}
```

### 数据表初始化方法：

```bash
php bin/yii migrate
```
### 区域数据导入
下载省市县数据库 https://github.com/modood/Administrative-divisions-of-China/blob/master/dist/data.sqlite

重命名为 district.sqlite 并保存到 database 目录

运行 php bin/yii import/district 导入地区数据

### 目录结构
```
├── bin // yii 命令
├── config // 后端配置
├── database
│   └── migrations // 数据迁移脚本
├── public // 网站根目录
│   └── statics // 静态资源
├── ui // 前端开发
│   ├── core // 公用核心模块
│   │   ├── assets
│   │   ├── components
│   │   └── styles
│   └── modules // 前端模块目录
│      └── admin // 管理后台前端代码目录
│          ├── assets
│          ├── components
│          ├── plugins
│          ├── router
│          ├── services
│          ├── store
│          ├── utils
│          └── views
├── src // 后端代码
│   ├── core // 核心公用代码
│   │   ├── components
│   │   ├── models
│   │   │   └── admin
│   │   ├── traits
│   │   └── widgets
│   └── modules // 后端模块
│       ├── admin // 管理后台
│       │   ├── api // 管理后台 API
│       │   │   ├── commands
│       │   │   └── controllers
│       │   └── spa // 管理后台 SPA 页面
│       │       ├── controllers
│       │       └── views
│       ├── website // 前台网站
│       │   ├── controllers
│       │   └── views
│       │       ├── layouts
│       │       └── templates
│       │           ├── auth
│       │           └── site
│       └── wechat // 微信端
```

### 前端相关说明
#####
管理后台前端开发服务器
```bash
npm run serve:admin
```
管理后台构建生产版本
```bash
npm run build:admin
```

### 其他

网站主地址
http://www.bp.test/

后台访问路径
http://www.bp.test/admin

后台管理：
用户：13012345678
密码：123456

Version: 2020-11-07 18:00
