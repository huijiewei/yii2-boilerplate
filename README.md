前后端分类脚手架

### 特点

1. 模块化开发模版

2. 使用 dotenv 环境变量配置敏感数据

3. 更灵活的目录结构

4. 使用 PSR-4 自动加载

5. 代码风格规范符合 PSR-2,PSR-12

6. 后台管理系统使用 Vue.js + Element UI + Vue Cli 构建

7. 默认开启本地开发环境 HTTPS 和 HTTP2 支持（webpack-serve 未开启 HTTP2）

### 在线演示
https://bp.huijiewei.com/admin
账号：13098761234
密码：123456

### 安装

项目需要 PHP 7.1 以上版本

##### 安装 composer 依赖包

```bash
composer install
```

##### 复制 .env.example 文件为 .env 并编辑配置

##### 开发服务器环境

###### 修改 Hosts
```text
127.0.0.1 www.bp.test
```

###### 生成本地开发环境 SSL 证书
使用 mkcert 工具，具体请参考：https://github.com/FiloSottile/mkcert

####### 安装 mkcert
```bash
brew install mkcert
brew install nss # 如果使用 Firefox
```
###### 生成并安装 ROOT 证书
```bash
mkcert -install
```

##### 进入项目 certs 目录生成 SSL 证书
```bash
cd certs
mkcert www.bp.test
cd ..
```

###### Nginx 配置，启用 HTTPS 和 HTTP2
```text
server {
    listen     80;
    server_name www.bp.test;
    return 301 https://$host$request_uri;
}

server {
    listen      443 ssl http2;
    server_name www.bp.test;

    ssl_certificate {项目根目录}/certs/www.bp.test.pem;
    ssl_certificate_key {项目根目录}/certs/www.bp.test-key.pem;

    root {项目根目录}/public;
    index index.php index.html index.htm;

    rewrite ^/(.*)/$ /$1 permanent;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    include php-fpm;
}
```

##### 数据表初始化方法：

```bash
php bin/yii migrate
php bin/yii migrate --migrationPath=@vendor/huijiewei/yii2-wechat/src/migrations
```

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
初始化开发环境
```bash
yarn install
```
管理后台前端开发服务器
```bash
yarn admin-serve
```
管理后台构建生产版本
```bash
yarn admin-build
```

### 其他

网站主地址
http://www.bp.test/

后台访问路径
http://www.bp.test/admin

后台管理：
用户：13012345678
密码：123456

### 关闭 HTTPS 的配置
###### Nginx 配置文件
```text
server {
    listen	80;
    server_name www.bp.test;

    root {项目根目录}/public;
    index index.php index.html index.htm;

    rewrite ^/(.*)/$ /$1 permanent;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    include php71-fpm;
}
```
###### Webpack 配置文件修改
修改文件 resources/config/admin.webpack.dev.js
```js
config.serveHttps = false
```

Version: 2019-11-02 09:55
