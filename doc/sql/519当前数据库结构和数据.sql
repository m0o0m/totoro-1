/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50051
Source Host           : 127.0.0.1:3306
Source Database       : totoro

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-05-19 15:53:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for player_bonus
-- ----------------------------
DROP TABLE IF EXISTS `player_bonus`;
CREATE TABLE `player_bonus` (
  `id` int(11) NOT NULL auto_increment,
  `client_id` int(11) NOT NULL,
  `client_logn` varchar(10) collate utf8_unicode_ci NOT NULL,
  `bonus_bl` int(11) NOT NULL COMMENT '分红比例',
  `bonus_zq` int(11) NOT NULL COMMENT '分红周期',
  `bonus_kssj` datetime NOT NULL COMMENT '周期开始时间',
  `bonus_jssj` datetime NOT NULL COMMENT '周期结束时间',
  `bonus_yk` decimal(10,0) NOT NULL COMMENT '周期盈亏',
  `bonus_je` decimal(10,0) NOT NULL COMMENT '周期金额',
  `bonus_state` int(11) NOT NULL default '0' COMMENT '状态0处理中1通过2取消',
  `bonus_user` int(11) default '0' COMMENT '审核人',
  `bonus_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `bonus_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '审核时间 ',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_bonus
-- ----------------------------
INSERT INTO `player_bonus` VALUES ('1', '1', 'liaohan', '10', '7', '2015-05-19 13:35:30', '2015-05-19 13:35:33', '10000', '100', '1', '1', '11', '2015-05-19 15:05:59', '0');

-- ----------------------------
-- Table structure for player_bonusbl
-- ----------------------------
DROP TABLE IF EXISTS `player_bonusbl`;
CREATE TABLE `player_bonusbl` (
  `id` int(11) NOT NULL auto_increment,
  `bonusbl_bl` int(11) NOT NULL COMMENT '分红比例',
  `bonuszq_id` int(11) NOT NULL COMMENT '分红周期',
  `bonusbl_name` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '分红类型名',
  `bonusbl_zjsx` decimal(10,0) NOT NULL COMMENT '分红资金上限',
  `bonusbl_zjxx` decimal(10,0) NOT NULL COMMENT '分红资金下限',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` int(11) default '0' COMMENT '修改人',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_bonusbl
-- ----------------------------
INSERT INTO `player_bonusbl` VALUES ('1', '10', '5', '1千到1万10%', '10000', '1000', '1', '2015-05-18 12:40:04', '0', '2015-05-18 12:40:04', '0');
INSERT INTO `player_bonusbl` VALUES ('2', '12', '5', '1万到5万12%', '500000', '10000', '1', '2015-05-18 12:41:10', '1', '2015-05-18 12:41:20', '0');
INSERT INTO `player_bonusbl` VALUES ('3', '15', '5', '5万以上15%', '1000000000', '50000', '1', '2015-05-18 12:41:54', '0', '2015-05-18 12:41:54', '0');
INSERT INTO `player_bonusbl` VALUES ('4', '8', '7', '1千到1万8%', '10000', '1000', '1', '2015-05-18 12:42:36', '0', '2015-05-18 12:42:36', '0');
INSERT INTO `player_bonusbl` VALUES ('5', '10', '7', '1万到5万10%', '50000', '10000', '1', '2015-05-18 12:42:57', '1', '2015-05-18 12:43:56', '0');
INSERT INTO `player_bonusbl` VALUES ('6', '12', '7', '5万以上12%', '1000000000', '50000', '1', '2015-05-18 12:43:39', '1', '2015-05-18 12:43:50', '0');

-- ----------------------------
-- Table structure for player_bonuszq
-- ----------------------------
DROP TABLE IF EXISTS `player_bonuszq`;
CREATE TABLE `player_bonuszq` (
  `id` int(11) NOT NULL auto_increment COMMENT '分红id',
  `bonuszq_zq` int(11) NOT NULL COMMENT '分红周期',
  `bonuszq_qssj` datetime NOT NULL COMMENT '起始时间',
  `bonuszq_kssj` datetime NOT NULL COMMENT '周期开始',
  `bonuszq_jssj` datetime NOT NULL COMMENT '周期结束',
  `bonuszq_state` int(11) NOT NULL COMMENT '状态0正常1暂停',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` int(11) default '0' COMMENT '修改人',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_bonuszq
-- ----------------------------
INSERT INTO `player_bonuszq` VALUES ('5', '7', '2015-05-01 00:00:00', '2015-05-15 00:00:00', '2015-05-22 00:00:00', '0', '1', '2015-05-18 12:18:55', '1', '2015-05-18 16:02:49', '0');
INSERT INTO `player_bonuszq` VALUES ('7', '15', '2015-05-01 00:00:00', '2015-05-16 00:00:00', '2015-05-31 00:00:00', '0', '1', '2015-05-18 12:29:17', '1', '2015-05-18 15:59:41', '0');

-- ----------------------------
-- Table structure for player_client
-- ----------------------------
DROP TABLE IF EXISTS `player_client`;
CREATE TABLE `player_client` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `fid` int(11) default NULL COMMENT '上级代理id',
  `flogn` varchar(10) collate utf8_unicode_ci default NULL COMMENT '上级账号',
  `client_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '玩家名',
  `client_pw` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '密码',
  `client_txpw` varchar(20) collate utf8_unicode_ci default NULL COMMENT '交易密码（必须与登陆密码不同）',
  `client_nickn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '昵称',
  `client_sex` varchar(1) collate utf8_unicode_ci default '0' COMMENT '性别0男1女',
  `client_mobile` varchar(15) collate utf8_unicode_ci default NULL COMMENT '手机',
  `client_email` varchar(15) collate utf8_unicode_ci default NULL COMMENT '电子邮箱',
  `client_QQnum` varchar(10) collate utf8_unicode_ci default NULL COMMENT 'QQ号码',
  `client_type` int(11) NOT NULL COMMENT '客户类型0总代1代理2顶级',
  `client_status` int(11) NOT NULL default '0' COMMENT '状态0正常 1冻结 2作废',
  `client_register` int(11) NOT NULL default '0' COMMENT '是否可以开户0否1是',
  `client_balance` decimal(10,0) NOT NULL default '0' COMMENT '账户资金',
  `client_freeze` decimal(10,0) NOT NULL default '0' COMMENT '冻结资金',
  `bonuszq_id` int(11) NOT NULL COMMENT '分红周期',
  `client_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `update_user` int(11) default '0' COMMENT '修改人',
  `client_ctime` datetime NOT NULL COMMENT '注册日期',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `AK_uniq_name` (`client_logn`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_client
-- ----------------------------
INSERT INTO `player_client` VALUES ('1', null, null, 'liaohan', '1234567812', '11111111111', 'e2222', '0', null, null, null, '0', '0', '0', '3320', '0', '7', null, '1', '1', '2015-05-14 21:09:27', '2015-05-19 15:05:59', '0');
INSERT INTO `player_client` VALUES ('2', null, null, 'zdl1', '123123123123', null, 'nnnvvv', '0', null, null, null, '0', '0', '1', '3600', '0', '5', null, '1', '1', '2015-05-17 14:05:28', '2015-05-18 15:20:06', '0');
INSERT INTO `player_client` VALUES ('3', '1', 'liaohan', 'xiaoxiao', 'lilililililili', null, '13213', '0', null, null, null, '1', '0', '0', '0', '0', '5', null, '1', '0', '2015-05-19 12:55:40', '2015-05-19 12:55:40', '0');

-- ----------------------------
-- Table structure for player_hnzz
-- ----------------------------
DROP TABLE IF EXISTS `player_hnzz`;
CREATE TABLE `player_hnzz` (
  `id` int(11) NOT NULL auto_increment,
  `zclient_num` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '转账编号',
  `zclient_id` int(11) NOT NULL COMMENT '转账账户id',
  `dclient_id` int(11) NOT NULL COMMENT '转入账户id',
  `zclient_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '转账人账号',
  `dclient_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '转入账户号',
  `hnzz_amount` int(11) NOT NULL COMMENT '转账金额',
  `hnzz_date` datetime NOT NULL COMMENT '转账时间',
  `hnzz_desc` varchar(30) collate utf8_unicode_ci default NULL,
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_hnzz
-- ----------------------------
INSERT INTO `player_hnzz` VALUES ('4', '123456', '1', '8', 'liaohan', 'skry10', '100', '2015-05-16 19:44:39', '', '0');

-- ----------------------------
-- Table structure for player_load
-- ----------------------------
DROP TABLE IF EXISTS `player_load`;
CREATE TABLE `player_load` (
  `id` int(11) NOT NULL auto_increment,
  `client_id` int(11) NOT NULL,
  `client_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '账户名',
  `load_num` varchar(20) collate utf8_unicode_ci default NULL COMMENT '充值编号',
  `load_amount` decimal(10,0) NOT NULL COMMENT '充值金额',
  `load_sjdz` decimal(10,0) default NULL COMMENT '实际到账金额',
  `load_sxf` decimal(10,0) default NULL COMMENT '手续费',
  `load_date` datetime NOT NULL COMMENT '充值提交时间',
  `yhk_id` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '玩家银行id',
  `yhk_num` varchar(19) collate utf8_unicode_ci NOT NULL COMMENT '玩家银行账户号',
  `yhk_name` varchar(10) collate utf8_unicode_ci default NULL COMMENT '玩家银行账户名称',
  `load_ps` varchar(30) collate utf8_unicode_ci default NULL COMMENT '附言',
  `xtyhk_id` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '系统银行id',
  `xtyhk_num` varchar(19) collate utf8_unicode_ci NOT NULL COMMENT '系统银行账户号',
  `xtyhk_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '系统银行账户名称',
  `load_fkstate` int(11) NOT NULL default '0' COMMENT '状态 0审核中1取消2成功3失败',
  `load_shuser` int(11) default NULL COMMENT '审核人',
  `load_fkdate` datetime NOT NULL COMMENT '审核时间',
  `load_desc` varchar(30) collate utf8_unicode_ci NOT NULL COMMENT '审核意见',
  `load_bonus` int(11) NOT NULL default '0' COMMENT '红利0未申请1申请中2通过3失败',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_load
-- ----------------------------
INSERT INTO `player_load` VALUES ('4', '1', 'liaohan', '123456', '100', '100', '10', '2015-05-17 16:47:09', '2', '1312313123124324', '李傲寒', '充值附言', '2', '12370197483589', '翠花', '2', '1', '2015-05-17 16:51:26', '审核完毕', '0', '0');

-- ----------------------------
-- Table structure for player_logfile
-- ----------------------------
DROP TABLE IF EXISTS `player_logfile`;
CREATE TABLE `player_logfile` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `client_id` int(11) default NULL COMMENT 'id',
  `logfile_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '登录名',
  `logfile_ip` varchar(15) collate utf8_unicode_ci NOT NULL COMMENT 'ip地址',
  `logfile_mac` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '设备序号',
  `logfile_logdate` datetime NOT NULL COMMENT '登陆时间',
  `logfile_isOnLine` int(11) NOT NULL COMMENT '是否在线0在线1退出',
  `logfile_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '描述',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  `logfile_escdate` datetime default NULL COMMENT '退出时间',
  PRIMARY KEY  (`id`),
  KEY `FK_Reference_28` (`client_id`),
  CONSTRAINT `FK_Reference_28` FOREIGN KEY (`client_id`) REFERENCES `player_client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_logfile
-- ----------------------------
INSERT INTO `player_logfile` VALUES ('1', '1', 'liaohan', '192.0.0.1', '132', '2015-05-15 11:04:48', '0', null, '0', '2015-05-15 11:08:33');
INSERT INTO `player_logfile` VALUES ('2', '3', 'xiaoxiao', '192.0.0.1', '2311', '2015-05-19 12:56:34', '0', null, '0', null);

-- ----------------------------
-- Table structure for player_szbonus
-- ----------------------------
DROP TABLE IF EXISTS `player_szbonus`;
CREATE TABLE `player_szbonus` (
  `id` int(11) NOT NULL auto_increment COMMENT '分红id',
  `client_id` int(11) NOT NULL,
  `client_logn` varchar(10) collate utf8_unicode_ci NOT NULL,
  `szbonus_bl` int(11) NOT NULL COMMENT '分红比例',
  `szbonus_zq` int(11) NOT NULL COMMENT '分红周期',
  `szbonus_qssj` datetime NOT NULL COMMENT '起始时间',
  `szbonus_ffsj` time NOT NULL COMMENT '发放时间',
  `szbonus_isyx` int(11) NOT NULL default '0' COMMENT '是否有效 0有效1无效',
  `update_user` int(11) default '0' COMMENT '修改人',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  `isdelete` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_szbonus
-- ----------------------------
INSERT INTO `player_szbonus` VALUES ('1', '1', 'liaohan', '12', '15', '2015-05-17 14:06:03', '02:00:00', '0', '1', '2015-05-17 14:06:03', '0');
INSERT INTO `player_szbonus` VALUES ('6', '2', 'zdl1', '12', '15', '2015-05-17 14:06:39', '02:00:00', '0', '0', '2015-05-17 14:06:39', '0');

-- ----------------------------
-- Table structure for player_tczb
-- ----------------------------
DROP TABLE IF EXISTS `player_tczb`;
CREATE TABLE `player_tczb` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `client_id` int(11) NOT NULL,
  `client_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '账户名',
  `tczb_num` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '编号',
  `tczb_type` int(11) NOT NULL COMMENT '账变类型3充值4提现',
  `tczb_amount` decimal(10,0) NOT NULL default '0' COMMENT '账变金额',
  `tczb_balance1` decimal(10,0) NOT NULL default '0' COMMENT '账变前余额',
  `tczb_balance2` decimal(10,0) NOT NULL default '0' COMMENT '账变后余额',
  `tczb_djje1` decimal(10,0) NOT NULL,
  `tczb_djje2` decimal(10,0) NOT NULL,
  `tczb_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `yhk_id` varchar(10) collate utf8_unicode_ci default NULL COMMENT '玩家银行id',
  `yhk_num` varchar(19) collate utf8_unicode_ci default NULL COMMENT '玩家银行账户号',
  `yhk_name` varchar(10) collate utf8_unicode_ci default NULL COMMENT '玩家银行账户名称',
  `xtyhk_id` varchar(10) collate utf8_unicode_ci default NULL COMMENT '系统银行id',
  `xtyhk_num` varchar(19) collate utf8_unicode_ci default NULL COMMENT '系统银行账户号',
  `xtyhk_name` varchar(10) collate utf8_unicode_ci default NULL COMMENT '系统银行账户名称',
  `czdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '账变时间',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_tczb
-- ----------------------------
INSERT INTO `player_tczb` VALUES ('1', '1', 'liaohan', '123456', '3', '100', '2120', '2220', '0', '0', null, null, null, null, '2', '12370197483589', '翠花', '2015-05-19 15:31:52', '0');
INSERT INTO `player_tczb` VALUES ('2', '1', 'liaohan', '123456', '4', '100', '2220', '2120', '100', '0', null, '4', '62228838012319', '提现玩家', null, null, null, '2015-05-19 15:45:50', '0');

-- ----------------------------
-- Table structure for player_transfer
-- ----------------------------
DROP TABLE IF EXISTS `player_transfer`;
CREATE TABLE `player_transfer` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `transfer_type` int(11) NOT NULL COMMENT '字典表''zblx''',
  `bonus_id` int(11) default NULL COMMENT '分红表id',
  `game_id` int(11) default NULL COMMENT '游戏id',
  `client_id` int(11) NOT NULL COMMENT '玩家账户id',
  `client_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '账户名',
  `transfer_je` decimal(10,0) NOT NULL COMMENT '账变金额',
  `transfer_ye1` decimal(10,0) NOT NULL COMMENT '账户转账前可用余额',
  `transfer_ye2` decimal(10,0) NOT NULL COMMENT '账户转账后可用余额',
  `transfer_djje1` decimal(10,0) NOT NULL COMMENT '账户转账前冻结资金',
  `transfer_djje2` decimal(10,0) NOT NULL COMMENT '账户转账后冻结资金',
  `transfer_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `transfer_date` datetime NOT NULL COMMENT '账变时间',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`),
  KEY `FK_Reference_26` (`bonus_id`),
  CONSTRAINT `FK_Reference_26` FOREIGN KEY (`bonus_id`) REFERENCES `player_bonus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_transfer
-- ----------------------------
INSERT INTO `player_transfer` VALUES ('2', '1', '1', null, '1', 'liaohan', '100', '3220', '3320', '0', '0', null, '2015-05-19 15:05:59', '0');

-- ----------------------------
-- Table structure for player_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `player_withdraw`;
CREATE TABLE `player_withdraw` (
  `id` int(11) NOT NULL auto_increment,
  `client_id` int(11) NOT NULL,
  `client_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '账户名称',
  `Withdraw_num` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '提现编号',
  `Withdraw_amount` decimal(10,0) NOT NULL COMMENT '提现金额',
  `Withdraw_sxf` decimal(10,0) NOT NULL COMMENT '提现手续费',
  `Withdraw_balance` decimal(10,0) NOT NULL COMMENT '提现前余额',
  `Withdraw_freeze` decimal(10,0) NOT NULL COMMENT '提现前冻结金额',
  `Withdraw_date` datetime NOT NULL COMMENT '发起时间',
  `yhk_id` int(11) NOT NULL COMMENT '玩家银行卡id',
  `yhk_num` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '玩家银行卡号',
  `yhk_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '玩家银行账户名',
  `yhk_adress` varchar(20) collate utf8_unicode_ci default NULL COMMENT '开户行地址',
  `xtyhk_id` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '系统银行id',
  `xtyhk_num` varchar(19) collate utf8_unicode_ci NOT NULL COMMENT '系统银行账户号',
  `xtyhk_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '系统银行账户名称',
  `Withdraw_shstate` int(11) NOT NULL default '0' COMMENT '审核状态0申请1取消2通过3拒绝4到账5到账失败',
  `Withdraw_shuser` int(11) default NULL COMMENT '审核人',
  `Withdraw_shdate` datetime default NULL COMMENT '审核处理时间',
  `Withdraw_fkuser` int(11) default NULL COMMENT '出纳人',
  `Withdraw_cndate` datetime default NULL COMMENT '交易完成时间',
  `Withdraw_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`),
  KEY `FK_Reference_21` (`yhk_id`),
  CONSTRAINT `FK_Reference_21` FOREIGN KEY (`yhk_id`) REFERENCES `player_yhk` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_withdraw
-- ----------------------------
INSERT INTO `player_withdraw` VALUES ('3', '1', 'liaohan', '123456', '100', '0', '1000', '10', '2015-05-16 21:35:40', '4', '62228838012319', '提现玩家', '开户行地址', '', '', '', '1', null, null, null, null, null, '0');
INSERT INTO `player_withdraw` VALUES ('4', '1', 'liaohan', '123456', '100', '10', '2220', '0', '2015-05-17 23:10:15', '4', '62228838012319', '提现玩家', '开户行地址', '', '', '', '2', '1', '2015-05-17 23:10:35', null, null, '1231231', '0');

-- ----------------------------
-- Table structure for player_yhk
-- ----------------------------
DROP TABLE IF EXISTS `player_yhk`;
CREATE TABLE `player_yhk` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `clien_id` int(11) NOT NULL,
  `bank_type` int(11) NOT NULL COMMENT '银行类型',
  `yhk_mc` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '玩家提现方式',
  `yhk_num` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '银行账号（第三方支付号）',
  `yhk_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '银行账户名',
  `yhk_adress` varchar(20) collate utf8_unicode_ci default NULL COMMENT '开户行地址',
  `yhk_status` int(11) NOT NULL default '0' COMMENT '状态0正常 1暂停 ',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of player_yhk
-- ----------------------------
INSERT INTO `player_yhk` VALUES ('2', '1', '2', '建设银行', '1312313123124324', '李傲寒', '的伟大的我打我', '0', '2015-05-15 01:06:44', '0');
INSERT INTO `player_yhk` VALUES ('3', '1', '2', '', '2', '3', '4', '1', '2015-05-15 12:31:41', '1');
INSERT INTO `player_yhk` VALUES ('4', '1', '3', '农业银行', '62228838012319', '提现玩家', '开户行地址', '0', '2015-05-16 12:59:30', '0');

-- ----------------------------
-- Table structure for sys_book
-- ----------------------------
DROP TABLE IF EXISTS `sys_book`;
CREATE TABLE `sys_book` (
  `id` int(11) NOT NULL auto_increment,
  `booktype_id` int(11) NOT NULL COMMENT '字典类型id',
  `book_no` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '字典编码',
  `book_value` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '字典值',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` int(11) default '0' COMMENT '修改人',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `AK_Key_2` (`book_no`),
  KEY `FK_Reference_22` (`booktype_id`),
  CONSTRAINT `FK_Reference_22` FOREIGN KEY (`booktype_id`) REFERENCES `sys_booktype` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_book
-- ----------------------------
INSERT INTO `sys_book` VALUES ('1', '1', 'gsyh', '工商银行', '1', '2015-05-15 00:24:11', '1', '2015-05-15 00:24:42', '0');
INSERT INTO `sys_book` VALUES ('2', '1', 'jsyh', '建设银行', '1', '2015-05-15 00:26:39', '0', '2015-05-15 00:26:39', '0');
INSERT INTO `sys_book` VALUES ('3', '1', 'nyyh', '农业银行', '1', '2015-05-15 00:26:55', '0', '2015-05-15 00:26:55', '0');
INSERT INTO `sys_book` VALUES ('4', '2', '1', '红利', '1', '2015-05-15 00:53:41', '1', '2015-05-19 14:43:16', '0');
INSERT INTO `sys_book` VALUES ('5', '2', '2', '优惠', '1', '2015-05-15 00:53:54', '1', '2015-05-19 14:43:21', '0');
INSERT INTO `sys_book` VALUES ('6', '2', '3', '账户充值', '1', '2015-05-19 15:22:23', '0', '2015-05-19 15:22:23', '0');
INSERT INTO `sys_book` VALUES ('7', '2', '4', '账户提现', '1', '2015-05-19 15:22:34', '0', '2015-05-19 15:22:34', '0');

-- ----------------------------
-- Table structure for sys_booktype
-- ----------------------------
DROP TABLE IF EXISTS `sys_booktype`;
CREATE TABLE `sys_booktype` (
  `id` int(11) NOT NULL auto_increment COMMENT '系统字典类型',
  `booktype_code` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '字典类型编码',
  `booktype_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '字典名称',
  `booktype_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` int(11) default '0' COMMENT '修改人',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `AK_uniq_bookcode` (`booktype_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_booktype
-- ----------------------------
INSERT INTO `sys_booktype` VALUES ('1', 'yhlx', '银行类型', '', '1', '2015-05-15 00:14:17', '0', '2015-05-15 00:14:17', '0');
INSERT INTO `sys_booktype` VALUES ('2', 'zblx', '账变类型', '', '1', '2015-05-15 00:53:13', '1', '2015-05-19 14:42:56', '0');

-- ----------------------------
-- Table structure for sys_logfile
-- ----------------------------
DROP TABLE IF EXISTS `sys_logfile`;
CREATE TABLE `sys_logfile` (
  `id` int(11) NOT NULL COMMENT 'id',
  `sysuser_id` int(11) NOT NULL COMMENT '登录人id',
  `logfile_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '登录名',
  `logfile_ip` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT 'ip地址',
  `logfile_logdate` datetime NOT NULL COMMENT '登陆时间',
  `logfile_isonline` int(11) NOT NULL default '0' COMMENT '是否在线0在线1退出',
  `logfile_esctime` datetime default NULL COMMENT '退出时间',
  `logfile_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '描述',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`),
  KEY `FK_Reference_23` (`sysuser_id`),
  CONSTRAINT `FK_Reference_23` FOREIGN KEY (`sysuser_id`) REFERENCES `sys_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_logfile
-- ----------------------------
INSERT INTO `sys_logfile` VALUES ('1', '1', 'liaohan', '192.168.1.1', '2015-05-14 14:11:16', '1', '2015-05-14 14:11:56', '12321', '0');

-- ----------------------------
-- Table structure for sys_notice
-- ----------------------------
DROP TABLE IF EXISTS `sys_notice`;
CREATE TABLE `sys_notice` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '公告标题',
  `content` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '公告内容',
  `state` int(11) NOT NULL default '0' COMMENT '状态0未审核1允许2拒绝',
  `start_date` datetime NOT NULL COMMENT '开始时间',
  `end_date` datetime NOT NULL COMMENT '结束时间',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `update_user` int(11) default '0' COMMENT '修改人',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_notice
-- ----------------------------
INSERT INTO `sys_notice` VALUES ('1', '标题', '内容L21', '0', '2015-05-16 00:00:00', '2015-05-18 00:00:00', '0', '1', '1', '2015-05-16 22:24:13', '2015-05-16 22:13:01');

-- ----------------------------
-- Table structure for sys_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `role_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '权限组名称',
  `role_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `role_status` int(11) NOT NULL default '0' COMMENT '状态0正常 1暂停 2作废',
  `role_statustime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '状态日期',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` int(11) default '0' COMMENT '修改人',
  `update_date` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT '修改时间 ',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_role
-- ----------------------------
INSERT INTO `sys_role` VALUES ('1', '管理员', 'Administrator', '0', '2015-05-14 14:09:04', '1', '2015-05-14 14:09:04', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `sys_role` VALUES ('2', '3', '4', '0', '2015-05-14 14:09:35', '1', '2015-05-14 14:09:12', '1', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `user_logn` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '登录名',
  `user_pw` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '登录密码',
  `user_name` varchar(15) collate utf8_unicode_ci default NULL COMMENT '昵称',
  `user_sex` int(11) NOT NULL default '0' COMMENT '性别0 男 1 女',
  `user_adress` varchar(20) collate utf8_unicode_ci default NULL COMMENT '地址',
  `user_mobile` varchar(15) collate utf8_unicode_ci NOT NULL COMMENT '手机',
  `user_email` varchar(15) collate utf8_unicode_ci NOT NULL COMMENT '电子邮箱',
  `user_QQnum` varchar(15) collate utf8_unicode_ci default NULL COMMENT 'QQ号码',
  `user_ip` varchar(14) collate utf8_unicode_ci default NULL COMMENT '登陆ip',
  `user_createdate` datetime NOT NULL COMMENT '创建日期',
  `user_status` int(11) NOT NULL default '0' COMMENT '状态0正常 1暂停 2作废',
  `user_statustime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '状态日期',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `AK_uniq_logname` (`user_logn`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', '123456', 'leo', '0', null, '1866575432', '1231', '', '192.168.1.1', '2015-05-14 14:03:59', '0', '2015-05-17 23:44:50', '0');

-- ----------------------------
-- Table structure for sys_xtyhk
-- ----------------------------
DROP TABLE IF EXISTS `sys_xtyhk`;
CREATE TABLE `sys_xtyhk` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `bank_type` int(11) NOT NULL COMMENT '银行类型 字典类型表（yhlx）',
  `xtyhk_mc` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '系统充值方式',
  `xtyhk_num` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '银行账号（第三方支付号）',
  `xtyhk_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '银行账户名',
  `xtyhk_type` int(11) NOT NULL default '0' COMMENT '用途0充值1提现',
  `xtyhk_adress` varchar(20) collate utf8_unicode_ci default NULL COMMENT '开户行地址',
  `xtyhk_status` int(11) NOT NULL default '0' COMMENT '状态0正常 1暂停 2作废',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_xtyhk
-- ----------------------------
INSERT INTO `sys_xtyhk` VALUES ('1', '1', '工商银行', '12392131213', 'ghmc', '0', 'ghdz', '0', '2015-05-15 12:14:13', '0');
INSERT INTO `sys_xtyhk` VALUES ('2', '2', '建设银行', '12370197483589', '翠花', '0', '的哇低洼大', '0', '2015-05-15 15:54:19', '0');
INSERT INTO `sys_xtyhk` VALUES ('3', '3', '农业银行', '32131312313', '大大的哇', '1', '达瓦大大王大娃娃', '1', '2015-05-15 15:54:49', '0');
INSERT INTO `sys_xtyhk` VALUES ('4', '1', '工商银行2', '2', '3', '0', '4', '1', '2015-05-15 16:08:16', '0');

-- ----------------------------
-- Table structure for sys_zh
-- ----------------------------
DROP TABLE IF EXISTS `sys_zh`;
CREATE TABLE `sys_zh` (
  `id` int(11) NOT NULL auto_increment,
  `zh_name` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '系统账户名',
  `zh_desc` varchar(30) collate utf8_unicode_ci default NULL COMMENT '备注',
  `zh_balance` decimal(10,0) NOT NULL COMMENT '余额',
  `zh_iszzh` int(11) NOT NULL default '1' COMMENT '是否主账户0主账户1子账户',
  `create_user` int(11) NOT NULL default '0' COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` int(11) default '0' COMMENT '修改人',
  `isdelete` int(11) NOT NULL default '0' COMMENT '是否删除',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '修改时间 ',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of sys_zh
-- ----------------------------
INSERT INTO `sys_zh` VALUES ('2', '主账户', '主账户', '8745', '0', '1', '2015-05-15 20:50:58', '0', '0', '2015-05-17 23:10:35');

-- ----------------------------
-- View structure for allzb
-- ----------------------------
DROP VIEW IF EXISTS `allzb`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `allzb` AS select transfer_type,client_id,client_logn,transfer_je,transfer_ye1,transfer_ye2,transfer_djje1,transfer_djje2,transfer_date,isdelete from player_transfer 
UNION
select tczb_type as 'transfer_type',client_id ,client_logn,
tczb_amount as 'transfer_je',tczb_balance1 as 'transfer_ye1',tczb_balance2 'transfer_ye2', tczb_djje1 as 'transfer_djje1',tczb_djje2 as 'transfer_djje2',czdate as 'transfer_date',isdelete
from player_tczb ;

-- ----------------------------
-- View structure for bl_zq
-- ----------------------------
DROP VIEW IF EXISTS `bl_zq`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `bl_zq` AS select a.*,b.bonuszq_zq,b.bonuszq_kssj,b.bonuszq_jssj from player_bonusbl a,player_bonuszq b where a.bonuszq_id = b.id ;

-- ----------------------------
-- View structure for loadsh_user_xtyh
-- ----------------------------
DROP VIEW IF EXISTS `loadsh_user_xtyh`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `loadsh_user_xtyh` AS select a.*,b.user_logn,c.xtyhk_mc 
from player_load a left join sys_user b on  a.load_shuser = b.id
LEFT JOIN sys_xtyhk c on  a.xtyhk_id = c.id ;

-- ----------------------------
-- View structure for withdraw_user_yhk
-- ----------------------------
DROP VIEW IF EXISTS `withdraw_user_yhk`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `withdraw_user_yhk` AS select a.*,b.user_logn,c.yhk_mc from player_withdraw a  LEFT JOIN  sys_user b on a.Withdraw_shuser = b.id 
LEFT JOIN player_yhk c on a.yhk_id = c.id ;

-- ----------------------------
-- View structure for xtyhk_tczb
-- ----------------------------
DROP VIEW IF EXISTS `xtyhk_tczb`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `xtyhk_tczb` AS select a.*,b.tczb_num,b.client_logn,b.tczb_amount,b.czdate from sys_xtyhk a,player_tczb b where a.id = b.xtyhk_id and b.tczb_type = 0 ;

-- ----------------------------
-- View structure for xtyh_book
-- ----------------------------
DROP VIEW IF EXISTS `xtyh_book`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `xtyh_book` AS SELECT a.*,book_value from sys_xtyhk a,sys_book b where a.isdelete = 0 and a.bank_type = b.id ;

-- ----------------------------
-- View structure for yhk_book
-- ----------------------------
DROP VIEW IF EXISTS `yhk_book`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `yhk_book` AS SELECT a.*,book_value from player_yhk a,sys_book b where a.isdelete = 0 and a.bank_type = b.id ;

-- ----------------------------
-- View structure for yhk_tczb
-- ----------------------------
DROP VIEW IF EXISTS `yhk_tczb`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `yhk_tczb` AS select a.*,b.tczb_num,b.client_logn,b.tczb_amount,b.czdate  
from player_yhk a, player_tczb b where a.id = b.yhk_id  and b.tczb_type = 1 ;

-- ----------------------------
-- View structure for zxclient_log
-- ----------------------------
DROP VIEW IF EXISTS `zxclient_log`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `zxclient_log` AS select a.*,fid from player_logfile a,player_client b where a.client_id = b.id  and a.logfile_isOnLine = 0 ;
