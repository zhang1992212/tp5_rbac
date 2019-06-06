/*
 Navicat Premium Data Transfer

 Source Server         : 本地连接
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost:3306
 Source Schema         : tp5

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 06/06/2019 18:51:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tp_action_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_action_log`;
CREATE TABLE `tp_action_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) NOT NULL DEFAULT 0 COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `log` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '日志备注',
  `log_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '执行的URL',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '执行行为的时间',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '执行者',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 124 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '行为日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_action_log
-- ----------------------------
INSERT INTO `tp_action_log` VALUES (109, 1, 2130706433, '5', '/index/auth/menuedit.html', 1484745934, 'admin', '测试5');
INSERT INTO `tp_action_log` VALUES (110, 27, 2130706433, '管理员<spen style=\'color: #1dd2af;\'>[ tekin ]</spen>偷偷的进入后台了,', '/index/publics/login.html', 1484746112, 'tekin', '后台登录');
INSERT INTO `tp_action_log` VALUES (111, 1, 2130706433, '管理员<spen style=\'color: #1dd2af;\'>[ admin ]</spen>偷偷的进入后台了,', '/index/publics/login.html', 1484746195, 'admin', '后台登录');
INSERT INTO `tp_action_log` VALUES (112, 27, 2130706433, '管理员<spen style=\'color: #1dd2af;\'>[ tekin ]</spen>偷偷的进入后台了,', '/index/publics/login.html', 1484746265, 'tekin', '后台登录');
INSERT INTO `tp_action_log` VALUES (113, 1, 2130706433, '管理员<spen style=\'color: #1dd2af;\'>[ admin ]</spen>偷偷的进入后台了,', '/index/publics/login.html', 1484746296, 'admin', '后台登录');
INSERT INTO `tp_action_log` VALUES (114, 27, 2130706433, '管理员<spen style=\'color: #1dd2af;\'>[ tekin ]</spen>偷偷的进入后台了,', '/index/publics/login.html', 1484746331, 'tekin', '后台登录');
INSERT INTO `tp_action_log` VALUES (115, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746336, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (116, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746340, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (117, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746342, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (118, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746344, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (119, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746346, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (120, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746351, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (121, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746353, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (122, 27, 2130706433, '5', '/index/auth/menuedit.html', 1484746354, 'tekin', '测试5');
INSERT INTO `tp_action_log` VALUES (123, 1, 2130706433, '管理员<spen style=\'color: #1dd2af;\'>[ admin ]</spen>偷偷的进入后台了,', '/index/publics/login.html', 1484746396, 'admin', '后台登录');

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员自增ID',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `user_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员的密码',
  `user_nicename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员的简称',
  `user_status` int(11) NULL DEFAULT 1 COMMENT '用户状态 0：禁用； 1：正常 ；',
  `user_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '邮箱',
  `last_login_ip` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime(0) NULL DEFAULT NULL COMMENT '最后登录时间',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '注册时间',
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
INSERT INTO `tp_admin` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 1, 'admin@qq.com', '114.88.197.96', '2016-10-26 12:06:43', '2016-06-07 17:04:05', NULL);
INSERT INTO `tp_admin` VALUES (16, 'zou', '21232f297a57a5a743894a0e4a801fc3', NULL, 1, 'zou1@qq.com', '127.0.0.1', '2016-07-17 17:01:36', '2016-07-08 15:29:41', '2');
INSERT INTO `tp_admin` VALUES (23, 'sdasd', '0aa1ea9a5a04b78d4581dd6d17742627', NULL, 1, 'asdas@qq.com', NULL, NULL, '2016-11-15 16:55:36', '2,3');
INSERT INTO `tp_admin` VALUES (27, 'tekin', '21232f297a57a5a743894a0e4a801fc3', NULL, 1, 'tekin@qq.com', NULL, NULL, '2017-01-18 21:14:40', '2');

-- ----------------------------
-- Table structure for tp_admin_account
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_account`;
CREATE TABLE `tp_admin_account`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `is_active` int(2) NOT NULL DEFAULT 0 COMMENT '类型 0未激活 1已激活',
  `deleted` int(2) NOT NULL DEFAULT 0 COMMENT '是否删除',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin_account
-- ----------------------------
INSERT INTO `tp_admin_account` VALUES (1, 'admin', '96e79218965eb72c92a549dd5a330112', 'admin', 1, 0, '2019-05-09 16:38:04', NULL);
INSERT INTO `tp_admin_account` VALUES (2, 'b', 'b', 'b', 0, 0, '2019-05-09 18:41:07', NULL);

-- ----------------------------
-- Table structure for tp_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_menu`;
CREATE TABLE `tp_admin_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `module` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模块',
  `controller` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作名称',
  `type` int(2) NOT NULL DEFAULT 1 COMMENT '菜单类型， 0 系统菜单 不允许修改  1普通菜单',
  `level` int(2) NOT NULL DEFAULT 1 COMMENT '菜单等级',
  `remark` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `order` int(10) NOT NULL DEFAULT 0 COMMENT '排序',
  `parent_id` int(10) NOT NULL DEFAULT 0 COMMENT '父级id',
  `deleted` int(2) NOT NULL DEFAULT 0 COMMENT '是否删除',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin_menu
-- ----------------------------
INSERT INTO `tp_admin_menu` VALUES (1, '系统管理', 'icon-system', '', '', '', 0, 1, '', 0, 0, 0, '2019-05-10 11:27:18', NULL);
INSERT INTO `tp_admin_menu` VALUES (2, '用户管理', 'icon-man', 'index', 'account', 'index', 0, 2, '', 10, 1, 0, '2019-05-10 11:27:18', NULL);
INSERT INTO `tp_admin_menu` VALUES (3, '角色管理', 'icon-role', 'index', 'role', 'index', 0, 2, '', 9, 1, 0, '2019-05-10 11:27:18', NULL);
INSERT INTO `tp_admin_menu` VALUES (4, '菜单管理', 'icon-man', 'index', 'menu', 'index', 0, 2, '', 8, 1, 0, '2019-05-10 11:27:18', NULL);
INSERT INTO `tp_admin_menu` VALUES (5, '首页', '&#xe8b4;', 'index', 'welcome', 'index', 0, 1, '', 9999, 0, 0, '2019-05-10 11:27:18', NULL);
INSERT INTO `tp_admin_menu` VALUES (6, 'tianjai', '', '', '', '', 1, 3, '', 9, 2, 0, '2019-05-10 14:40:59', NULL);
INSERT INTO `tp_admin_menu` VALUES (7, 'wwwq', '', '', '', '', 1, 3, '', 0, 2, 0, '2019-05-10 17:42:52', NULL);
INSERT INTO `tp_admin_menu` VALUES (8, '撒旦撒多', '&#xe61a;', 'index', 'index', 'a', 1, 2, '', 0, 1, 0, '2019-06-05 15:20:39', NULL);
INSERT INTO `tp_admin_menu` VALUES (9, 'qw', '', 'qw', 'qw', 'q', 1, 2, '', 0, 5, 0, '2019-06-06 18:37:14', NULL);
INSERT INTO `tp_admin_menu` VALUES (10, 'q', '', 'q', 'q', 'q', 1, 2, '', 1, 5, 0, '2019-06-06 18:37:52', NULL);

-- ----------------------------
-- Table structure for tp_auth_access
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_access`;
CREATE TABLE `tp_auth_access`  (
  `role_id` mediumint(8) UNSIGNED NOT NULL COMMENT '角色',
  `rule_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '权限规则分类，请加应用前缀,如admin_',
  `menu_id` int(11) NULL DEFAULT NULL COMMENT '后台菜单ID',
  INDEX `role_id`(`role_id`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限授权表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_auth_access
-- ----------------------------
INSERT INTO `tp_auth_access` VALUES (2, 'index/auth/default', 'admin_url', 1);
INSERT INTO `tp_auth_access` VALUES (2, 'index/auth/default', 'admin_url', 2);
INSERT INTO `tp_auth_access` VALUES (2, 'index/auth/log', 'admin_url', 20);
INSERT INTO `tp_auth_access` VALUES (2, 'index/auth/viewlog', 'admin_url', 21);
INSERT INTO `tp_auth_access` VALUES (2, 'index/index/sasd', 'admin_url', 15);
INSERT INTO `tp_auth_access` VALUES (2, 'index/index/asd', 'admin_url', 16);
INSERT INTO `tp_auth_access` VALUES (2, 'index/auth/menuedit', 'admin_url', 19);

-- ----------------------------
-- Table structure for tp_auth_role
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_role`;
CREATE TABLE `tp_auth_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名称',
  `pid` smallint(6) NULL DEFAULT 0 COMMENT '父角色ID',
  `status` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT 0 COMMENT '排序字段',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parentId`(`pid`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_auth_role
-- ----------------------------
INSERT INTO `tp_auth_role` VALUES (1, '超级管理员', 0, 1, '拥有网站最高管理员权限！', 1329633709, 1329633709, 0);
INSERT INTO `tp_auth_role` VALUES (2, '文章管理', 0, 1, 'SDAS', 0, 0, 0);
INSERT INTO `tp_auth_role` VALUES (3, 'abc', 0, 1, '', 0, 0, 0);

-- ----------------------------
-- Table structure for tp_auth_role_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_role_user`;
CREATE TABLE `tp_auth_role_user`  (
  `role_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '角色 id',
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  INDEX `group_id`(`role_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户角色对应表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of tp_auth_role_user
-- ----------------------------
INSERT INTO `tp_auth_role_user` VALUES (2, 16);
INSERT INTO `tp_auth_role_user` VALUES (2, 27);

-- ----------------------------
-- Table structure for tp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_rule`;
CREATE TABLE `tp_auth_rule`  (
  `menu_id` int(11) NOT NULL COMMENT '后台菜单 ID',
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则所属module',
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `url_param` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '额外url参数',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否有效(0:无效,1:有效)',
  `rule_param` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则附加条件',
  `nav_id` int(11) NULL DEFAULT 0 COMMENT 'nav id',
  PRIMARY KEY (`menu_id`) USING BTREE,
  INDEX `module`(`module`, `status`, `type`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限规则表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_auth_rule
-- ----------------------------
INSERT INTO `tp_auth_rule` VALUES (2, 'index', 'admin_url', 'index/auth/default', '', '权限管理', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (3, 'index', 'admin_url', 'index/auth/role', '', '角色管理', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (4, 'index', 'admin_url', 'index/auth/roleadd', '', '角色增加', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (5, 'index', 'admin_url', 'index/auth/roleedit', '', '角色编辑', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (6, 'index', 'admin_url', 'index/auth/roledelete', '', '角色删除', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (7, 'index', 'admin_url', 'index/auth/authorize', '', '角色授权', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (8, 'index', 'admin_url', 'index/auth/menu', '', '菜单管理', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (9, 'index', 'admin_url', 'index/auth/menu', '', '菜单列表', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (10, 'index', 'admin_url', 'index/auth/menuadd', '', '菜单增加', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (11, 'index', 'admin_url', 'index/auth/menuedit', '', '菜单修改', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (12, 'index', 'admin_url', 'index/auth/menudelete', '', '菜单删除', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (13, 'index', 'admin_url', 'index/auth/menuorder', '', '菜单排序', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (14, 'index', 'admin_url', 'index/admin/index', '', '用户管理', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (15, 'index', 'admin_url', 'index/index/sasd', '', '测试', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (16, 'index', 'admin_url', 'index/index/asd', 'asd', '测试', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (17, 'index', 'admin_url', 'index/auth/menuedit', 'dasd', '边缘', 1, 'in_array({id},[1,2,4,5] )', 0);
INSERT INTO `tp_auth_rule` VALUES (19, 'index', 'admin_url', 'index/auth/menuedit', 'id=5', '测试5', 1, '{id}==5', 0);
INSERT INTO `tp_auth_rule` VALUES (20, 'index', 'admin_url', 'index/auth/log', '', '行为日志', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (21, 'index', 'admin_url', 'index/auth/viewlog', '', '查看日志', 1, '', 0);
INSERT INTO `tp_auth_rule` VALUES (22, 'index', 'admin_url', 'index/auth/clear', '', '清空日志', 1, '', 0);

-- ----------------------------
-- Table structure for tp_menu
-- ----------------------------
DROP TABLE IF EXISTS `tp_menu`;
CREATE TABLE `tp_menu`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级ID',
  `app` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '应用名称app',
  `model` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '控制器',
  `action` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作名称',
  `url_param` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'url参数',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态，1显示，0不显示',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单图标',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `list_order` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序ID',
  `rule_param` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '验证规则',
  `nav_id` int(11) NULL DEFAULT 0 COMMENT 'nav ID ',
  `request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '请求方式（日志生成）',
  `log_rule` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '日志规则',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `model`(`model`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_menu
-- ----------------------------
INSERT INTO `tp_menu` VALUES (1, 0, 'index', 'auth', 'default', '', 0, 1, '系统管理', '', '', 10, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (2, 1, 'index', 'auth', 'default', '', 0, 1, '权限管理', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (3, 2, 'index', 'auth', 'role', '', 1, 1, '角色管理', '', '1', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (4, 3, 'index', 'auth', 'roleAdd', '', 1, 0, '角色增加', '', '', 0, '', 0, '', '{id}');
INSERT INTO `tp_menu` VALUES (5, 3, 'index', 'auth', 'roleEdit', '', 1, 0, '角色编辑', '', 'asdas', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (6, 3, 'index', 'auth', 'roleDelete', '', 1, 0, '角色删除', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (7, 3, 'index', 'auth', 'authorize', '', 1, 0, '角色授权', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (8, 1, 'index', 'auth', 'default', '', 0, 1, '菜单管理', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (9, 8, 'index', 'auth', 'menu', '', 1, 1, '菜单列表', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (10, 9, 'index', 'auth', 'menuAdd', '', 1, 0, '菜单增加', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (11, 9, 'index', 'auth', 'menuEdit', '', 1, 0, '菜单修改', '', '', 0, '', 0, 'POST', '我的ID是{id} <br> 记入的目录{name}');
INSERT INTO `tp_menu` VALUES (12, 9, 'index', 'auth', 'menuDelete', '', 1, 0, '菜单删除', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (13, 9, 'index', 'auth', 'menuOrder', '', 1, 0, '菜单排序', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (14, 2, 'index', 'admin', 'index', '', 1, 1, '用户管理', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (15, 0, 'index', 'index', 'sasd', '', 0, 1, '测试', '', '', 20, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (16, 15, 'index', 'index', 'asd', 'asd', 1, 1, '测试', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (17, 15, 'index', 'auth', 'menuEdit', 'dasd', 1, 1, '边缘', '', '11q1adas1adsasdfsdfdsd', 0, 'in_array({id},[1,2,4,5] )', 0, '', '');
INSERT INTO `tp_menu` VALUES (20, 2, 'index', 'auth', 'log', '', 1, 1, '行为日志', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (19, 16, 'index', 'auth', 'menuEdit', 'id=5', 1, 1, '测试5', '', 'dasd', 0, '{id}==5', 0, 'GET', '{id}');
INSERT INTO `tp_menu` VALUES (21, 20, 'index', 'auth', 'viewLog', '', 1, 0, '查看日志', '', '', 0, '', 0, '', '');
INSERT INTO `tp_menu` VALUES (22, 20, 'index', 'auth', 'clear', '', 1, 0, '清空日志', '', '', 0, '', 0, '', '');

-- ----------------------------
-- Table structure for tp_migrations
-- ----------------------------
DROP TABLE IF EXISTS `tp_migrations`;
CREATE TABLE `tp_migrations`  (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `start_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_migrations
-- ----------------------------
INSERT INTO `tp_migrations` VALUES (20190508074331, 'CreateAccountTable', '2019-05-09 16:37:55', '2019-05-09 16:37:56', 0);
INSERT INTO `tp_migrations` VALUES (20190509064812, 'CreateMenuTable', '2019-05-09 16:37:56', '2019-05-09 16:37:56', 0);

SET FOREIGN_KEY_CHECKS = 1;
