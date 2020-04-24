# Host: 192.168.33.11  (Version 5.5.60-MariaDB)
# Date: 2020-04-24 22:46:23
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "m_admin"
#

CREATE TABLE `m_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL DEFAULT '0' COMMENT '角色id',
  `admin_name` varchar(50) NOT NULL COMMENT '用户名',
  `admin_password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `last_login_ip` varchar(128) NOT NULL COMMENT '最后登陆IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员';

#
# Data for table "m_admin"
#

INSERT INTO `m_admin` VALUES (1,1,'admin','$2y$10$t1.BK.U4oSJNJg1ThM619uTaLkUk3DLtsEnrM5xbgWuYXyRW.UXuC','13888888888','138@163.com',1,'192.168.33.1',1587738109,0,1587738109);

#
# Structure for table "m_login_log"
#

CREATE TABLE `m_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `login_uid` int(11) NOT NULL DEFAULT '0' COMMENT '登录用户id',
  `login_ip` varchar(15) NOT NULL COMMENT '登录ip',
  `login_area` varchar(55) DEFAULT NULL COMMENT '登录地区',
  `login_user_agent` varchar(155) DEFAULT NULL COMMENT '登录设备头',
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `login_status` tinyint(1) DEFAULT '1' COMMENT '登录状态 1 成功 0失败',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Structure for table "m_menu"
#

CREATE TABLE `m_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父节点id',
  `title` varchar(20) NOT NULL COMMENT '菜单标题',
  `icon` varchar(80) DEFAULT 'null' COMMENT '菜单图标',
  `ctrl` varchar(200) NOT NULL COMMENT '链接地址(模块/控制器/方法)',
  `action` varchar(20) NOT NULL DEFAULT '' COMMENT '方法',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统菜单，系统菜单不可删除',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态1显示，0隐藏',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理菜单';

#
# Data for table "m_menu"
#

INSERT INTO `m_menu` VALUES (1,0,'主页','el-icon-s-home','#','#',0,1,1,0,0),(2,1,'后台首页','el-icon-arrow-right','index','index',1,1,1,1970,1970),(3,1,'个人信息','null','index','update',1,1,0,1970,1970),(4,0,'系统','el-icon-setting','#','#',0,1,1,0,0),(5,4,'菜单管理','el-icon-menu','menu','index',0,1,1,0,0),(6,5,'菜单列表','null','menu','index',0,1,0,0,0),(7,5,'菜单详情','null','menu','read',0,1,0,0,0),(8,5,'添加菜单','null','menu','save',0,1,0,0,0),(9,5,'编辑菜单','null','menu','update',0,1,0,0,0),(10,5,'删除菜单','null','menu','delete',0,1,0,0,0),(11,0,'管理员','el-icon-s-custom','#','#',0,1,1,0,0),(12,11,'角色管理','el-icon-eleme','role','index',0,1,1,0,0),(13,12,'角色列表','null','role','index',0,1,0,0,0),(14,12,'角色详情','null','role','read',0,1,0,0,0),(15,12,'添加角色','null','role','save',0,1,0,0,0),(16,12,'编辑角色','null','role','update',0,1,0,0,0),(17,12,'删除角色','v','role','delete',0,1,0,0,0),(18,11,'权限管理','el-icon-eleme','auth','index',0,1,0,0,0),(19,18,'权限列表','null','auth','index',0,1,0,0,0),(20,18,'权限分配','null','auth','update',0,1,0,0,0),(21,18,'指定权限','null','auth','read',0,1,0,0,0),(22,11,'管理员管理','el-icon-user','admin','index',0,1,1,0,0),(23,22,'管理员列表','null','admin','index',0,1,0,0,0),(24,22,'管理员详情','null','admin','read',0,1,0,0,0),(25,22,'添加管理员','null','admin','save',0,1,0,0,0),(26,22,'编辑管理员','null','admin','update',0,1,0,0,0),(27,22,'删除管理员','null','admin','delete',0,1,0,0,0),(28,4,'日志管理','el-icon-document','log','index',1,1,1,1587725811,1587725811),(29,28,'日志列表','null','log','index',1,1,0,1587725842,1587725842);

#
# Structure for table "m_role"
#

CREATE TABLE `m_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `intro` varchar(200) NOT NULL COMMENT '角色简介',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='管理角色';

#
# Data for table "m_role"
#

INSERT INTO `m_role` VALUES (1,'超级管理员','超级管理员',0,0,1),(2,'系统管理员','系统管理员',1587653531,1587708867,1);

#
# Structure for table "m_role_auth"
#

CREATE TABLE `m_role_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id（菜单id）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关联表';
