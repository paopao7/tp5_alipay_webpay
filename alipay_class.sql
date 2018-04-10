/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50522
Source Host           : localhost:3306
Source Database       : alipay_class

Target Server Type    : MYSQL
Target Server Version : 50522
File Encoding         : 65001

Date: 2018-04-10 15:47:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pay_config
-- ----------------------------
DROP TABLE IF EXISTS `pay_config`;
CREATE TABLE `pay_config` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(30) DEFAULT '' COMMENT 'app_id',
  `merchant_private_key` text COMMENT '私钥',
  `alipay_public_key` text COMMENT '公钥',
  `notify_url` varchar(255) DEFAULT '' COMMENT '异步通知地址',
  `return_url` varchar(255) DEFAULT '' COMMENT '跳转地址',
  `charset` varchar(30) DEFAULT '' COMMENT '编码',
  `sign_type` varchar(30) DEFAULT '' COMMENT '签名方式',
  `gatewayUrl` varchar(255) DEFAULT '' COMMENT '支付宝网关',
  `update_time` int(30) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='支付宝配置表';

-- ----------------------------
-- Records of pay_config
-- ----------------------------
INSERT INTO `pay_config` VALUES ('1', '', '', '', '', '', 'UTF-8', 'RSA2', 'https://openapi.alipay.com/gateway.do', null);

-- ----------------------------
-- Table structure for pay_record
-- ----------------------------
DROP TABLE IF EXISTS `pay_record`;
CREATE TABLE `pay_record` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(100) DEFAULT '' COMMENT '订单编号',
  `user_id` int(30) DEFAULT '0' COMMENT '账户id',
  `type` varchar(50) DEFAULT '' COMMENT '充值类型',
  `money` float(10,2) DEFAULT '0.00' COMMENT '充值金额',
  `status` int(1) DEFAULT '0' COMMENT '是否回调成功（0：初始值 1：成功）',
  `create_time` int(30) DEFAULT '0' COMMENT '时间',
  `update_time` int(30) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='充值记录表';

-- ----------------------------
-- Records of pay_record
-- ----------------------------

-- ----------------------------
-- Table structure for pay_tmp
-- ----------------------------
DROP TABLE IF EXISTS `pay_tmp`;
CREATE TABLE `pay_tmp` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `post_data` text,
  `create_time` varchar(30) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pay_tmp
-- ----------------------------

-- ----------------------------
-- Table structure for pay_users
-- ----------------------------
DROP TABLE IF EXISTS `pay_users`;
CREATE TABLE `pay_users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT '' COMMENT '账户名称',
  `money` float(10,2) DEFAULT '0.00' COMMENT '账户余额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='账户表';

-- ----------------------------
-- Records of pay_users
-- ----------------------------
INSERT INTO `pay_users` VALUES ('1', '188888888888', '100000.03');
