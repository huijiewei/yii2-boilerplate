CREATE TABLE `${table-prefix}admin_group`
(
    `id`   int         NOT NULL AUTO_INCREMENT,
    `name` varchar(30) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 128
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `${table-prefix}admin_group`(`id`, `name`)
VALUES (11, '开发组');

CREATE TABLE `${table-prefix}admin_group_permission`
(
    `id`           int         NOT NULL AUTO_INCREMENT,
    `adminGroupId` int         NOT NULL DEFAULT '0',
    `actionId`     varchar(60) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `adminGroupId` (`adminGroupId`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1981
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin/index');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin/create');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin/view/:id');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin/edit/:id');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin/delete');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin-group/index');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin-group/create');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin-group/view/:id');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin-group/edit/:id');
INSERT INTO `${table-prefix}admin_group_permission`(`adminGroupId`, `actionId`)
VALUES (11, 'admin-group/delete');

CREATE TABLE `${table-prefix}admin`
(
    `id`           int          NOT NULL AUTO_INCREMENT,
    `adminGroupId` int                   DEFAULT '0',
    `phone`        varchar(30)  NOT NULL DEFAULT '',
    `email`        varchar(90)  NOT NULL DEFAULT '',
    `name`         varchar(30)  NOT NULL DEFAULT '',
    `avatar`       varchar(500) NOT NULL DEFAULT '',
    `password`     varchar(200) NOT NULL DEFAULT '',
    `createdAt`    timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt`    timestamp    NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deletedAt`    timestamp    NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `phone` (`phone`),
    KEY `adminGroupId` (`adminGroupId`),
    KEY `deletedAt` (`deletedAt`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 101
  DEFAULT CHARSET = utf8mb4;

INSERT INTO `${table-prefix}admin`(`adminGroupId`, `phone`, `email`, `name`, `avatar`, `password`)
VALUES (11, '13012345678', 'dev@agile.test', '开发帐号',
        'https://yuncars-other.oss-cn-shanghai.aliyuncs.com//agile/201912/6vhndpiufbuidayxg79f.jpg?x-oss-process=style/avatar',
        '$2a$10$SDOgPHq87zxz.3VhxPKcqOo/iuPO.S9QSKQXRNyXRUY7Do64oApjq');

CREATE TABLE `${table-prefix}admin_access_token`
(
    `id`          int           NOT NULL AUTO_INCREMENT,
    `clientId`    varchar(60)   NOT NULL DEFAULT '',
    `adminId`     int           NOT NULL DEFAULT '0',
    `accessToken` varchar(60)   NOT NULL DEFAULT '',
    `remoteAddr`  varchar(50)   NOT NULL DEFAULT '',
    `userAgent`   varchar(2048) NOT NULL DEFAULT '',
    `updatedAt`   timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `accessToken` (`clientId`, `accessToken`),
    KEY `clientId` (`clientId`),
    KEY `adminId` (`adminId`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 11981
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}admin_log`
(
    `id`         int           NOT NULL AUTO_INCREMENT,
    `adminId`    int           NOT NULL DEFAULT '0',
    `status`     tinyint       NOT NULL DEFAULT '0',
    `type`       varchar(10)   NOT NULL DEFAULT '',
    `method`     varchar(20)   NOT NULL DEFAULT '',
    `action`     varchar(255)  NOT NULL DEFAULT '',
    `params`     varchar(2048) NOT NULL DEFAULT '',
    `userAgent`  varchar(2048) NOT NULL DEFAULT '',
    `remoteAddr` varchar(50)   NOT NULL DEFAULT '',
    `exception`  text,
    `createdAt`  timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `adminId` (`adminId`),
    KEY `type` (`type`),
    KEY `status` (`status`),
    KEY `createdAt` (`createdAt`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 11981
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}user`
(
    `id`          int          NOT NULL AUTO_INCREMENT,
    `phone`       varchar(30)  NOT NULL DEFAULT '',
    `email`       varchar(90)  NOT NULL DEFAULT '',
    `password`    varchar(200) NOT NULL DEFAULT '',
    `name`        varchar(20)  NOT NULL DEFAULT '',
    `avatar`      varchar(500) NOT NULL DEFAULT '',
    `createdIp`   varchar(30)  NOT NULL DEFAULT '',
    `createdFrom` varchar(20)  NOT NULL DEFAULT '',
    `createdAt`   timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt`   timestamp    NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deletedAt`   timestamp    NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `phone` (`phone`),
    KEY `email` (`email`),
    KEY `deletedAt` (`deletedAt`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1981
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}user_address`
(
    `id`           int          NOT NULL AUTO_INCREMENT,
    `userId`       int          NOT NULL DEFAULT '0',
    `districtCode` varchar(9)   NOT NULL DEFAULT '',
    `alias`        varchar(12)  NOT NULL DEFAULT '',
    `name`         varchar(32)  NOT NULL DEFAULT '',
    `phone`        varchar(20)  NOT NULL DEFAULT '',
    `address`      varchar(160) NOT NULL DEFAULT '',
    `createdAt`    timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt`    timestamp    NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `userId` (`userId`),
    KEY `districtCode` (`districtCode`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1021
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}shop_brand`
(
    `id`          int          NOT NULL AUTO_INCREMENT,
    `name`        varchar(60)  NOT NULL DEFAULT '',
    `alias`       varchar(50)  NOT NULL DEFAULT '',
    `logo`        varchar(255) NOT NULL DEFAULT '',
    `website`     varchar(255) NOT NULL DEFAULT '',
    `description` text,
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 11102
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}shop_brand_category`
(
    `id`             int NOT NULL AUTO_INCREMENT,
    `shopBrandId`    int NOT NULL DEFAULT '0',
    `shopCategoryId` int NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 271
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}shop_category`
(
    `id`          int          NOT NULL AUTO_INCREMENT,
    `parentId`    int          NOT NULL DEFAULT '0',
    `name`        varchar(50)  NOT NULL DEFAULT '',
    `icon`        text,
    `image`       varchar(500) NOT NULL DEFAULT '',
    `description` text,
    PRIMARY KEY (`id`),
    KEY `parentId` (`parentId`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1211
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}captcha`
(
    `id`         int           NOT NULL AUTO_INCREMENT,
    `code`       varchar(10)   NOT NULL DEFAULT '',
    `uuid`       varchar(22)   NOT NULL DEFAULT '',
    `userAgent`  varchar(2048) NOT NULL DEFAULT '',
    `remoteAddr` varchar(50)   NOT NULL DEFAULT '',
    `createdAt`  timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uuid` (`uuid`, `code`, `remoteAddr`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 136
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}district`
(
    `id`       int         NOT NULL AUTO_INCREMENT,
    `parentId` int         NOT NULL DEFAULT '0',
    `name`     varchar(60) NOT NULL DEFAULT '',
    `code`     varchar(9)  NOT NULL DEFAULT '',
    `zipCode`  varchar(9)  NOT NULL DEFAULT '',
    `areaCode` varchar(9)  NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`),
    KEY `parentId` (`parentId`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 1221
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}district_closure`
(
    `id`         int NOT NULL AUTO_INCREMENT,
    `ancestor`   int NOT NULL DEFAULT '0',
    `descendant` int NOT NULL DEFAULT '0',
    `distance`   int NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    UNIQUE KEY `ancestor` (`ancestor`, `descendant`),
    UNIQUE KEY `descendant` (`descendant`, `distance`),
    KEY `distance` (`distance`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `${table-prefix}shop_product`
(
    `id`             int          NOT NULL AUTO_INCREMENT,
    `shopCategoryId` int          NOT NULL DEFAULT '0',
    `shopBrandId`    int          NOT NULL DEFAULT '0',
    `name`           varchar(100) NOT NULL DEFAULT '',
    `cover`          varchar(255) NOT NULL DEFAULT '',
    `detail`         mediumtext,
    `createdAt`      timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `shopCategoryId` (`shopCategoryId`),
    KEY `shopBrandId` (`shopBrandId`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 12230
  DEFAULT CHARSET = utf8mb4;