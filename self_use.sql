/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : scqnq

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 14/02/2019 11:03:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for orz_admin_access
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_access`;
CREATE TABLE `orz_admin_access`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
  `group` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '管理员用户组',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台管理员与用户组对应关系表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_admin_access
-- ----------------------------
INSERT INTO `orz_admin_access` VALUES (1, 1, 1, 1438651748, 1438651748, 0, 1);
INSERT INTO `orz_admin_access` VALUES (2, 2, 2, 1548231523, 1548231523, 0, 1);

-- ----------------------------
-- Table structure for orz_admin_addon
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_addon`;
CREATE TABLE `orz_admin_addon`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '插件名或标识',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '插件描述',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本号',
  `adminlist` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否有后台列表',
  `type` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '插件类型',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '安装时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  `sort` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '插件表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_admin_addon
-- ----------------------------
INSERT INTO `orz_admin_addon` VALUES (1, 'ModelConfigEditor', '模型配置器', '用于编辑已有模块的配置', '\"\"', 'yangweijie', '0.2', 0, 0, 1479866990, 1479866990, 0, 1);
INSERT INTO `orz_admin_addon` VALUES (3, 'YuntxSms', '云通讯插件', '用于配置并发送云通讯短信', '{\"account_sid\":\"\",\"account_token\":\"\",\"app_id\":\"\",\"debug\":\"1\"}', 'yangweijie', '0.1', 0, 0, 1548228077, 1548228077, 0, 1);

-- ----------------------------
-- Table structure for orz_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_config`;
CREATE TABLE `orz_admin_config`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置标题',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配置名称',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置值',
  `group` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配置分组',
  `type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置类型',
  `options` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置额外值',
  `tip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统配置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_admin_config
-- ----------------------------
INSERT INTO `orz_admin_config` VALUES (1, '站点开关', 'TOGGLE_WEB_SITE', '1', 1, 'select', '0:关闭\r\n1:开启', '站点关闭后将不能访问', 1378898976, 1406992386, 1, 1);
INSERT INTO `orz_admin_config` VALUES (2, '网站标题', 'WEB_SITE_TITLE', '房车服务号', 1, 'text', '', '网站标题前台显示标题', 1378898976, 1379235274, 2, 1);
INSERT INTO `orz_admin_config` VALUES (3, '网站LOGO', 'WEB_SITE_LOGO', '', 1, 'picture', '', '网站LOGO', 1407003397, 1407004692, 4, 1);
INSERT INTO `orz_admin_config` VALUES (4, '网站域名', 'WEB_URL', '', 1, 'text', '', '', 1483437312, 1483437342, 0, 1);
INSERT INTO `orz_admin_config` VALUES (5, '客服热线', 'WXWAP_HOTLINE', '', 1, 'text', '', '', 1488008635, 1488008664, 5, 1);
INSERT INTO `orz_admin_config` VALUES (6, '文件上传大小', 'UPLOAD_FILE_SIZE', '100', 2, 'num', '', '文件上传大小单位：MB', 1428681031, 1428681031, 1, 1);
INSERT INTO `orz_admin_config` VALUES (7, '图片上传大小', 'UPLOAD_IMAGE_SIZE', '100', 2, 'num', '', '图片上传大小单位：MB', 1428681071, 1428681071, 2, 1);
INSERT INTO `orz_admin_config` VALUES (8, '后台多标签', 'ADMIN_TABS', '0', 2, 'radio', '0:关闭\r\n1:开启', '', 1453445526, 1453445526, 3, 0);
INSERT INTO `orz_admin_config` VALUES (9, '分页数量', 'ADMIN_PAGE_ROWS', '10', 2, 'num', '', '分页时每页的记录数', 1434019462, 1434019481, 4, 1);
INSERT INTO `orz_admin_config` VALUES (10, '后台主题', 'ADMIN_THEME', 'aliyun', 2, 'select', 'admin:默认主题\r\naliyun:阿里云风格\r\nweixin:微信风格\r\ngreen:绿色主题\r\npink:粉色主题\r\nred:红色主题', '后台界面主题', 1436678171, 1548214061, 5, 1);
INSERT INTO `orz_admin_config` VALUES (11, '配置分组', 'CONFIG_GROUP_LIST', '1:基本\r\n2:系统\r\n3:开发\r\n4:部署\r\n5:微信\r\n6:后台', 2, 'array', '', '配置分组', 1379228036, 1548227594, 7, 1);
INSERT INTO `orz_admin_config` VALUES (12, '开发模式', 'DEVELOP_MODE', '1', 3, 'select', '1:开启\r\n0:关闭', '开发模式下会显示菜单管理、配置管理、数据字典等开发者工具', 1432393583, 1432393583, 1, 1);
INSERT INTO `orz_admin_config` VALUES (13, '是否显示页面Trace', 'SHOW_PAGE_TRACE', '0', 3, 'select', '0:关闭\r\n1:开启', '是否显示页面Trace信息', 1387165685, 1387165685, 2, 1);
INSERT INTO `orz_admin_config` VALUES (14, '系统加密KEY', 'AUTH_KEY', 'YwYH?hNv,?Q?H&h{ox:}$C!<#)\"-j[T;Z~N~cyxXI,(L]czF@N+;&qbA$h;HG.Ph', 3, 'textarea', '', '轻易不要修改此项，否则容易造成用户无法登录；如要修改，务必备份原key', 1438647773, 1438647815, 3, 1);
INSERT INTO `orz_admin_config` VALUES (15, 'URL模式', 'URL_MODEL', '3', 4, 'select', '1:PATHINFO模式\r\n2:REWRITE模式\r\n3:兼容模式', '', 1438423248, 1438423248, 1, 1);
INSERT INTO `orz_admin_config` VALUES (16, '微信APPID', 'wechat_appid', '', 5, 'text', '', '', 1479866418, 1479866418, 1, 1);
INSERT INTO `orz_admin_config` VALUES (17, '微信APPSECRET', 'wechat_appsecret', '', 5, 'text', '', '', 1479866483, 1479887153, 2, 1);
INSERT INTO `orz_admin_config` VALUES (18, '微信TOKEN', 'wechat_apptoken', '', 5, 'text', '', '', 1479866587, 1479866587, 3, 1);
INSERT INTO `orz_admin_config` VALUES (19, '微信授权回调地址', 'wechat_url', 'weixin/auth_back', 5, 'text', '', '', 1479866632, 1479866632, 4, 1);
INSERT INTO `orz_admin_config` VALUES (20, '微信商户id', 'wechat_merchant_id', '', 5, 'text', '', '', 1479866670, 1479866670, 5, 1);
INSERT INTO `orz_admin_config` VALUES (21, '微信商户key', 'wechat_key', '', 5, 'text', '', '', 1479866703, 1479866703, 6, 1);

-- ----------------------------
-- Table structure for orz_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_group`;
CREATE TABLE `orz_admin_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '部门ID',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级部门ID',
  `title` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '部门名称',
  `icon` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `menu_auth` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限列表',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序（同级有效）',
  `status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台用户分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_admin_group
-- ----------------------------
INSERT INTO `orz_admin_group` VALUES (1, 0, '超级管理员', 'fa-user', '', 1426881003, 1427552428, 0, 1);
INSERT INTO `orz_admin_group` VALUES (2, 0, '管理员', 'fa-user', '{\"Admin\":[\"1\",\"2\",\"3\",\"4\",\"13\",\"14\",\"15\",\"61\",\"62\",\"63\",\"17\",\"18\",\"19\",\"21\",\"22\",\"64\",\"65\",\"66\",\"23\",\"24\",\"25\",\"26\",\"67\",\"68\",\"69\",\"70\",\"28\",\"29\",\"30\",\"71\",\"72\",\"73\",\"32\",\"33\",\"34\",\"74\",\"75\",\"76\",\"36\",\"44\",\"45\",\"46\",\"47\",\"77\",\"78\",\"49\",\"50\",\"51\",\"52\",\"53\",\"54\",\"55\",\"56\",\"79\",\"80\",\"85\",\"81\",\"82\",\"83\",\"84\"],\"Wxwap\":[\"1\",\"2\",\"3\",\"4\"]}', 1541657200, 1548231912, 1, 1);

-- ----------------------------
-- Table structure for orz_admin_hook
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_hook`;
CREATE TABLE `orz_admin_hook`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '钩子ID',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '钩子名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `addons` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '钩子挂载的插件',
  `type` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '钩子表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_admin_hook
-- ----------------------------
INSERT INTO `orz_admin_hook` VALUES (1, 'AdminIndex', '后台首页小工具', '后台首页小工具,ModelConfigEditor', 1, 1446522155, 1446522155, 1);
INSERT INTO `orz_admin_hook` VALUES (2, 'FormBuilderExtend', 'FormBuilder类型扩展Builder', '', 1, 1447831268, 1447831268, 1);
INSERT INTO `orz_admin_hook` VALUES (3, 'UploadFile', '上传文件钩子', '', 1, 1407681961, 1407681961, 1);
INSERT INTO `orz_admin_hook` VALUES (4, 'PageHeader', '页面header钩子，一般用于加载插件CSS文件和代码', '', 1, 1407681961, 1407681961, 1);
INSERT INTO `orz_admin_hook` VALUES (5, 'PageFooter', '页面footer钩子，一般用于加载插件CSS文件和代码', 'RocketToTop', 1, 1407681961, 1407681961, 1);
INSERT INTO `orz_admin_hook` VALUES (6, 'CommonHook', '通用钩子，自定义用途，一般用来定制特殊功能', '', 1, 1456147822, 1456147822, 1);

-- ----------------------------
-- Table structure for orz_admin_module
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_module`;
CREATE TABLE `orz_admin_module`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `title` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `logo` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片图标',
  `icon` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字体图标',
  `icon_color` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字体图标颜色',
  `description` varchar(127) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `developer` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(7) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本',
  `user_nav` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '个人中心导航',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置',
  `admin_menu` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单节点',
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否允许卸载',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模块功能表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_admin_module
-- ----------------------------
INSERT INTO `orz_admin_module` VALUES (1, 'Admin', '系统', '', 'fa fa-cog', '#3CA6F1', '核心系统', '西陆科技', '1.0.0', '', '', '{\"1\":{\"pid\":\"0\",\"title\":\"\\u7cfb\\u7edf\",\"icon\":\"fa fa-cog\",\"level\":\"system\",\"id\":\"1\"},\"2\":{\"pid\":\"1\",\"title\":\"\\u7cfb\\u7edf\\u529f\\u80fd\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"icon\":\"fa fa-wrench\",\"url\":\"Admin\\/Config\\/group\",\"id\":\"3\"},\"4\":{\"pid\":\"3\",\"title\":\"\\u4fee\\u6539\\u8bbe\\u7f6e\",\"url\":\"Admin\\/Config\\/groupSave\",\"id\":\"4\"},\"6\":{\"pid\":\"5\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Nav\\/add\",\"id\":\"6\"},\"7\":{\"pid\":\"5\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Nav\\/edit\",\"id\":\"7\"},\"13\":{\"pid\":\"2\",\"title\":\"\\u914d\\u7f6e\\u7ba1\\u7406\",\"icon\":\"fa fa-cogs\",\"url\":\"Admin\\/Config\\/index\",\"id\":\"13\"},\"14\":{\"pid\":\"13\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Config\\/add\",\"id\":\"14\"},\"15\":{\"pid\":\"13\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Config\\/edit\",\"id\":\"15\"},\"17\":{\"pid\":\"2\",\"title\":\"\\u4e0a\\u4f20\\u7ba1\\u7406\",\"icon\":\"fa fa-upload\",\"url\":\"Admin\\/Upload\\/index\",\"id\":\"17\"},\"18\":{\"pid\":\"17\",\"title\":\"\\u4e0a\\u4f20\\u6587\\u4ef6\",\"url\":\"Admin\\/Upload\\/upload\",\"id\":\"18\"},\"19\":{\"pid\":\"17\",\"title\":\"\\u5220\\u9664\\u6587\\u4ef6\",\"url\":\"Admin\\/Upload\\/delete\",\"id\":\"19\"},\"21\":{\"pid\":\"17\",\"title\":\"\\u4e0b\\u8f7d\\u8fdc\\u7a0b\\u56fe\\u7247\",\"url\":\"Admin\\/Upload\\/downremoteimg\",\"id\":\"21\"},\"22\":{\"pid\":\"17\",\"title\":\"\\u6587\\u4ef6\\u6d4f\\u89c8\",\"url\":\"Admin\\/Upload\\/fileManager\",\"id\":\"22\"},\"23\":{\"pid\":\"1\",\"title\":\"\\u7cfb\\u7edf\\u6743\\u9650\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"23\"},\"24\":{\"pid\":\"23\",\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"fa fa-user\",\"url\":\"Admin\\/User\\/index\",\"id\":\"24\"},\"25\":{\"pid\":\"24\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/User\\/add\",\"id\":\"25\"},\"26\":{\"pid\":\"24\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/User\\/edit\",\"id\":\"26\"},\"28\":{\"pid\":\"23\",\"title\":\"\\u7ba1\\u7406\\u5458\\u7ba1\\u7406\",\"icon\":\"fa fa-lock\",\"url\":\"Admin\\/Access\\/index\",\"id\":\"28\"},\"29\":{\"pid\":\"28\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Access\\/add\",\"id\":\"29\"},\"30\":{\"pid\":\"28\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Access\\/edit\",\"id\":\"30\"},\"32\":{\"pid\":\"23\",\"title\":\"\\u7528\\u6237\\u7ec4\\u7ba1\\u7406\",\"icon\":\"fa fa-sitemap\",\"url\":\"Admin\\/Group\\/index\",\"id\":\"32\"},\"33\":{\"pid\":\"32\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Group\\/add\",\"id\":\"33\"},\"34\":{\"pid\":\"32\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Group\\/edit\",\"id\":\"34\"},\"36\":{\"pid\":\"1\",\"title\":\"\\u6269\\u5c55\\u4e2d\\u5fc3\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"36\"},\"44\":{\"pid\":\"36\",\"title\":\"\\u529f\\u80fd\\u6a21\\u5757\",\"icon\":\"fa fa-th-large\",\"url\":\"Admin\\/Module\\/index\",\"id\":\"44\"},\"45\":{\"pid\":\"44\",\"title\":\"\\u5b89\\u88c5\",\"url\":\"Admin\\/Module\\/install\",\"id\":\"45\"},\"46\":{\"pid\":\"44\",\"title\":\"\\u5378\\u8f7d\",\"url\":\"Admin\\/Module\\/uninstall\",\"id\":\"46\"},\"47\":{\"pid\":\"44\",\"title\":\"\\u66f4\\u65b0\\u4fe1\\u606f\",\"url\":\"Admin\\/Module\\/updateInfo\",\"id\":\"47\"},\"49\":{\"pid\":\"36\",\"title\":\"\\u63d2\\u4ef6\\u7ba1\\u7406\",\"icon\":\"fa fa-th\",\"url\":\"Admin\\/Addon\\/index\",\"id\":\"49\"},\"50\":{\"pid\":\"49\",\"title\":\"\\u5b89\\u88c5\",\"url\":\"Admin\\/Addon\\/install\",\"id\":\"50\"},\"51\":{\"pid\":\"49\",\"title\":\"\\u5378\\u8f7d\",\"url\":\"Admin\\/Addon\\/uninstall\",\"id\":\"51\"},\"52\":{\"pid\":\"49\",\"title\":\"\\u8fd0\\u884c\",\"url\":\"Admin\\/Addon\\/execute\",\"id\":\"52\"},\"53\":{\"pid\":\"49\",\"title\":\"\\u8bbe\\u7f6e\",\"url\":\"Admin\\/Addon\\/config\",\"id\":\"53\"},\"54\":{\"pid\":\"49\",\"title\":\"\\u540e\\u53f0\\u7ba1\\u7406\",\"url\":\"Admin\\/Addon\\/adminList\",\"id\":\"54\"},\"55\":{\"pid\":\"54\",\"title\":\"\\u65b0\\u589e\\u6570\\u636e\",\"url\":\"Admin\\/Addon\\/adminAdd\",\"id\":\"55\"},\"56\":{\"pid\":\"54\",\"title\":\"\\u7f16\\u8f91\\u6570\\u636e\",\"url\":\"Admin\\/Addon\\/adminEdit\",\"id\":\"56\"},\"58\":{\"id\":\"58\",\"pid\":\"5\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/Nav\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \"},\"59\":{\"pid\":\"5\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/Nav\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"59\"},\"60\":{\"pid\":\"5\",\"title\":\"\\u5220\\u9664\",\"url\":\"Admin\\/Nav\\/setStatus\\/status\\/delete\",\"icon\":\"fa \",\"id\":\"60\"},\"61\":{\"pid\":\"13\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/Config\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \",\"id\":\"61\"},\"62\":{\"pid\":\"13\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/Config\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"62\"},\"63\":{\"pid\":\"13\",\"title\":\"\\u5220\\u9664\",\"url\":\"Admin\\/Config\\/setStatus\\/status\\/delete\",\"icon\":\"fa \",\"id\":\"63\"},\"64\":{\"pid\":\"17\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/Upload\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \",\"id\":\"64\"},\"65\":{\"pid\":\"17\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/Upload\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"65\"},\"66\":{\"pid\":\"17\",\"title\":\"\\u5220\\u9664\",\"url\":\"Admin\\/Upload\\/setStatus\\/status\\/delete\",\"icon\":\"fa \",\"id\":\"66\"},\"67\":{\"pid\":\"24\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/User\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \",\"id\":\"67\"},\"68\":{\"pid\":\"24\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/User\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"68\"},\"69\":{\"pid\":\"24\",\"title\":\"\\u5220\\u9664\",\"url\":\"Admin\\/User\\/setStatus\\/status\\/delete\",\"icon\":\"fa \",\"id\":\"69\"},\"70\":{\"pid\":\"24\",\"title\":\"\\u56de\\u6536\",\"url\":\"Admin\\/User\\/setStatus\\/status\\/recyle\",\"icon\":\"fa \",\"id\":\"70\"},\"71\":{\"pid\":\"28\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/Access\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \",\"id\":\"71\"},\"72\":{\"pid\":\"28\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/Access\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"72\"},\"73\":{\"pid\":\"28\",\"title\":\"\\u5220\\u9664\",\"url\":\"Admin\\/Access\\/setStatus\\/status\\/delete\",\"icon\":\"fa \",\"id\":\"73\"},\"74\":{\"pid\":\"32\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/Group\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \",\"id\":\"74\"},\"75\":{\"pid\":\"32\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/Group\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"75\"},\"76\":{\"pid\":\"32\",\"title\":\"\\u5220\\u9664\",\"url\":\"Admin\\/Group\\/setStatus\\/status\\/delete\",\"icon\":\"fa \",\"id\":\"76\"},\"77\":{\"pid\":\"44\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/Module\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \",\"id\":\"77\"},\"78\":{\"pid\":\"44\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/Module\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"78\"},\"79\":{\"pid\":\"54\",\"title\":\"\\u7981\\u7528\",\"url\":\"Admin\\/Addon\\/setStatus\\/status\\/forbid\",\"icon\":\"fa \",\"id\":\"79\"},\"80\":{\"pid\":\"54\",\"title\":\"\\u542f\\u7528\",\"url\":\"Admin\\/Addon\\/setStatus\\/status\\/resume\",\"icon\":\"fa \",\"id\":\"80\"},\"81\":{\"id\":\"81\",\"pid\":\"85\",\"title\":\"\\u5fae\\u4fe1\\u5e95\\u90e8\\u83dc\\u5355\",\"url\":\"Admin\\/Wxmenu\\/index\",\"icon\":\"fa fa-comments-o\",\"sort\":\"\"},\"82\":{\"pid\":\"81\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Wxmenu\\/add\",\"icon\":\"fa \",\"sort\":\"\",\"id\":\"82\"},\"83\":{\"pid\":\"81\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Wxmenu\\/edit\",\"icon\":\"fa \",\"sort\":\"\",\"id\":\"83\"},\"84\":{\"pid\":\"81\",\"title\":\"\\u751f\\u6210\\u83dc\\u5355\",\"url\":\"Admin\\/Wxmenu\\/build\",\"icon\":\"fa \",\"sort\":\"\",\"id\":\"84\"},\"85\":{\"id\":\"85\",\"pid\":\"1\",\"title\":\"\\u5fae\\u4fe1\\u914d\\u7f6e\",\"url\":\"\",\"icon\":\"fa fa-folder-open-o\",\"sort\":\"\"},\"88\":{\"id\":\"88\",\"pid\":\"87\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Wxmenu\\/addit\",\"icon\":\"fa \",\"sort\":\"\"}}', 1, 1438651748, 1548227975, 0, 1);
INSERT INTO `orz_admin_module` VALUES (7, 'Wxwap', '微信站', '', 'fa fa-comments', '#F9B440', '微信站模块', 'yangweijie', '1.0.0', '', '{\"test\":\"\"}', '{\"1\":{\"id\":\"1\",\"pid\":\"0\",\"title\":\"\\u540e\\u53f0\\u7ba1\\u7406\",\"url\":\"\",\"icon\":\"fa fa-comments\",\"sort\":\"\"},\"2\":{\"id\":\"2\",\"pid\":\"1\",\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"url\":\"\",\"icon\":\"fa fa-folder-open-o\",\"sort\":\"\"},\"3\":{\"id\":\"3\",\"pid\":\"2\",\"title\":\"\\u5fae\\u4fe1\\u7ad9\",\"url\":\"Wxwap\\/Index\\/index\",\"icon\":\"fa fa-comments\"},\"4\":{\"pid\":\"1\",\"title\":\"\\u5fae\\u4fe1\\u7ad9\\u8bbe\\u7f6e\",\"url\":\"\",\"icon\":\"fa fa-wrench\",\"sort\":\"\",\"id\":\"4\"}}', 0, 1486362129, 1548227979, 0, 1);

-- ----------------------------
-- Table structure for orz_admin_upload
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_upload`;
CREATE TABLE `orz_admin_upload`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'UID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件链接',
  `ext` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '文件大小',
  `md5` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件md5',
  `sha1` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件sha1编码',
  `location` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件存储位置',
  `download` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '下载次数',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上传时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `md5`(`md5`) USING BTREE,
  UNIQUE INDEX `sha1`(`sha1`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文件上传表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for orz_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `orz_admin_user`;
CREATE TABLE `orz_admin_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `user_type` int(11) NOT NULL DEFAULT 1 COMMENT '用户类型',
  `nickname` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `username` varchar(31) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户账号表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_admin_user
-- ----------------------------
INSERT INTO `orz_admin_user` VALUES (1, 1, '开发', 'xilukeji', 'c73da6e4246c88ca3e959c0d68083a93', 1438651748, 1548231639, 1);
INSERT INTO `orz_admin_user` VALUES (2, 1, '管理员', 'admin', 'e811fee0842e9e7aa2a989058e5b402d', 1548231509, 1548231509, 1);

-- ----------------------------
-- Table structure for orz_user
-- ----------------------------
DROP TABLE IF EXISTS `orz_user`;
CREATE TABLE `orz_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `openid` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'openid',
  `nickname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信昵称',
  `cnname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '姓名',
  `headimgurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信头像',
  `avatar` int(30) UNSIGNED NULL DEFAULT 0 COMMENT '上传头像',
  `mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码MD5',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `score` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '积分',
  `sex` tinyint(4) UNSIGNED NULL DEFAULT 0 COMMENT '性别  1 男  2 女 0 保密',
  `birthday` date NULL DEFAULT NULL COMMENT '生日',
  `recUid` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '上级代理商',
  `rec_time` datetime NULL DEFAULT NULL COMMENT '确定上下级关系时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orz_user
-- ----------------------------
INSERT INTO `orz_user` VALUES (1, 'oRrvHs8YkeK0um5dXuKfd4Asf7_U', '开发人员', '开发人员', 'http://wx.qlogo.cn/mmopen/oLVxgQSrbtia8t05FmSqp1ePm9icubfLHrFLGT5MAlM5Richgtb0PJQ5dpYvNz1X61L8icsVCdm0BMiaA1r479jkrRdorg1s35B1E/0', 0, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, 0, NULL);

-- ----------------------------
-- Table structure for orz_wxmenu
-- ----------------------------
DROP TABLE IF EXISTS `orz_wxmenu`;
CREATE TABLE `orz_wxmenu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fid` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 链接 1关键字',
  `sort` int(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信菜单表' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
