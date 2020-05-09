# Host: 192.168.33.11  (Version 5.5.60-MariaDB)
# Date: 2020-05-10 01:44:29
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "p_admin"
#

CREATE TABLE `p_admin` (
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='管理员';

#
# Data for table "p_admin"
#

INSERT INTO `p_admin` VALUES (1,1,'admin','$2y$10$t1.BK.U4oSJNJg1ThM619uTaLkUk3DLtsEnrM5xbgWuYXyRW.UXuC','13888888232','111@111.com',1,'192.168.33.1',1589028780,0,1589028780);

#
# Structure for table "p_file"
#

CREATE TABLE `p_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `file_size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `file_url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件地址',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='文件表';

#
# Structure for table "p_login_log"
#

CREATE TABLE `p_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `login_uid` int(11) NOT NULL DEFAULT '0' COMMENT '登录用户id',
  `login_ip` varchar(15) NOT NULL COMMENT '登录ip',
  `login_area` varchar(55) DEFAULT NULL COMMENT '登录地区',
  `login_user_agent` varchar(155) DEFAULT NULL COMMENT '登录设备头',
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `login_status` tinyint(1) DEFAULT '1' COMMENT '登录状态 1 成功 0失败',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COMMENT='日志表';

#
# Structure for table "p_menu"
#

CREATE TABLE `p_menu` (
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理菜单';

#
# Data for table "p_menu"
#

INSERT INTO `p_menu` VALUES (1,0,'主页','el-icon-s-home','index','#',1,1,1,1970,1970),(2,1,'后台首页','el-icon-arrow-right','index','index',1,1,1,1970,1970),(3,1,'个人信息','null','index','update',1,1,0,1970,1970),(4,0,'系统','el-icon-setting','sys','#',1,1,1,1970,1970),(5,4,'菜单管理','el-icon-menu','menu','index',0,1,1,0,0),(6,5,'菜单列表','null','menu','index',0,1,0,0,0),(7,5,'菜单详情','null','menu','read',0,1,0,0,0),(8,5,'添加菜单','null','menu','save',0,1,0,0,0),(9,5,'编辑菜单','null','menu','update',0,1,0,0,0),(10,5,'删除菜单','null','menu','delete',0,1,0,0,0),(11,0,'管理员','el-icon-s-custom','manage','#',1,1,1,1970,1970),(12,11,'角色管理','el-icon-eleme','role','index',0,1,1,0,0),(13,12,'角色列表','null','role','index',0,1,0,0,0),(14,12,'角色详情','null','role','read',0,1,0,0,0),(15,12,'添加角色','null','role','save',0,1,0,0,0),(16,12,'编辑角色','null','role','update',0,1,0,0,0),(17,12,'删除角色','v','role','delete',0,1,0,0,0),(18,11,'权限管理','el-icon-eleme','auth','index',0,1,0,0,0),(19,18,'权限列表','null','auth','index',0,1,0,0,0),(20,18,'权限分配','null','auth','update',0,1,0,0,0),(21,18,'指定权限','null','auth','read',0,1,0,0,0),(22,11,'管理员管理','el-icon-user','admin','index',0,1,1,0,0),(23,22,'管理员列表','null','admin','index',0,1,0,0,0),(24,22,'管理员详情','null','admin','read',0,1,0,0,0),(25,22,'添加管理员','null','admin','save',0,1,0,0,0),(26,22,'编辑管理员','null','admin','update',0,1,0,0,0),(27,22,'删除管理员','null','admin','delete',0,1,0,0,0),(28,4,'日志管理','el-icon-document','log','index',1,1,1,1587725811,1587725811),(29,28,'日志列表','null','log','index',1,1,0,1587725842,1587725842),(30,0,'客户管理','el-icon-user','client','#',1,0,1,2020,2020),(31,30,'用户管理','el-icon-user-solid','user','#',1,0,1,1587819582,1587819582),(32,31,'用户列表','null','user','index',1,0,0,1587819647,1587819647),(33,31,'用户详细','null','user','read',1,0,0,1587819687,1587819687),(34,31,'用户更新','null','user','update',1,0,0,1587819718,1587819718),(35,31,'用户删除','null','user','delete',1,0,0,1587819733,1587819733),(36,30,'商户管理','el-icon-s-goods','merchant','#',1,0,1,1587819851,1587819851),(37,36,'商户列表','null','merchant','index',1,0,0,1587819887,1587819887),(38,36,'商户详情','null','merchant','read',1,0,0,1587819909,1587819909),(39,36,'商户更新','null','merchant','update',1,0,0,1587819933,1587819933),(40,36,'商户删除','null','merchant','delete',1,0,0,1587819950,1587819950);

#
# Structure for table "p_merchant"
#

CREATE TABLE `p_merchant` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `m_login_name` varchar(25) NOT NULL DEFAULT '' COMMENT '商家登录名',
  `m_login_pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '商家登录密码',
  `m_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商家店名',
  `m_tel` varchar(255) NOT NULL DEFAULT '' COMMENT '电话',
  `m_status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 0禁用 1启用',
  `m_address` varchar(100) NOT NULL DEFAULT '' COMMENT '商家地址',
  `m_lng` float(8,5) NOT NULL DEFAULT '0.00000' COMMENT '经度',
  `m_lat` float(8,5) NOT NULL DEFAULT '0.00000' COMMENT '纬度',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `is_audit` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商家表';


#
# Structure for table "p_options"
#

CREATE TABLE `p_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '商户id',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '价格配置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='打印项目';

#
# Structure for table "p_order"
#

CREATE TABLE `p_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_number` varchar(30) NOT NULL DEFAULT '' COMMENT '订单号',
  `total_price` float(4,2) NOT NULL DEFAULT '0.00' COMMENT '订单总价',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '商户id',
  `file_id` varchar(100) NOT NULL DEFAULT '' COMMENT '文件id 数组形式',
  `p_options` text COMMENT '打印参数',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `order_status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '订单状态 1已提交 2已支付 3打印中 4已完成',
  `delete_for_merchant` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商家删除',
  `delete_for_user` tinyint(3) NOT NULL DEFAULT '0' COMMENT '用户删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='订单表';

#
# Structure for table "p_role"
#

CREATE TABLE `p_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `intro` varchar(200) NOT NULL COMMENT '角色简介',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='管理角色';

#
# Data for table "p_role"
#

INSERT INTO `p_role` VALUES (1,'超级管理员','超级管理员',0,1588690357,1);

#
# Structure for table "p_role_auth"
#

CREATE TABLE `p_role_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id（菜单id）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='角色权限关联表';

#
# Structure for table "p_user"
#

CREATE TABLE `p_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_name` varchar(30) NOT NULL DEFAULT '' COMMENT '登录名',
  `user_pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '登陆密码',
  `user_tel` varchar(15) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `user_address` varchar(255) NOT NULL DEFAULT '' COMMENT '用户地址',
  `user_lng` float(8,5) NOT NULL DEFAULT '0.00000' COMMENT '用户经度',
  `user_lat` float(8,5) NOT NULL DEFAULT '0.00000' COMMENT '用户纬度',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `user_status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0禁用 1启用',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';
