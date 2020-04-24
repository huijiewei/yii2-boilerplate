VUE + ELEMENT.UI 演示项目

项目目前正在开发，变动可能会很大，暂时只供研究学习参考

### 特点

1. 基于 VUE CLI

2. 自带 Mock 服务器

3. 使用 .env 配置环境变量

4. 使用不同配置文件来分割不同项目入口

### 在线演示
https://agile.huijiewei.com/admin
账号：13098761234
密码：123456

### 教程

#### 安装

```bash
npm install
```

#### 配置

##### 修改 Hosts
```text
127.0.0.1 www.agile.test
```

##### 生成本地开发环境 SSL 证书
使用 mkcert 工具生成本地证书，安装请参考：https://github.com/FiloSottile/mkcert
```bash
cd certs
mkcert www.agile.test
cd ..
```

#### vue.config.js 配置说明
可以根据 package.json 文件 scripts 内命令行 VUE_CLI_SERVICE_CONFIG_PATH 参数使用不同项目入口配置文件


#### 运行本地开发
复制 .env.example 为 .env.development

```bash
npm run serve:admin
npm run serve:mobile
```

#### 构建生产版本

```bash
npm run build:admin
npm run build:mobile
```

### 关键目录说明
```
├── dist // 生成的生产环境文件
├── mocker // Mock 服务器和 Mock 数据
├── src // 源代码目录
│   ├── core // 公用核心模块
│   └── modules // 模块目录
│      └── admin // 管理后台
│      └── mobile // 移动端
```

### 其他说明

默认 Mock 服务后台管理员：

用户：13012345679
密码：123456

### 后端配合
Agile Boot

https://github.com/huijiewei/agile-boot

### 说明文件版本更新

Version: 2019-11-06 09:09
