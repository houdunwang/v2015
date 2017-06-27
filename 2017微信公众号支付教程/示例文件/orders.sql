/*
Navicat MySQL Data Transfer

Source Server         : pay.hdphp.com
Source Server Version : 50635
Source Host           : 120.55.180.124:3306
Source Database       : pay_hdphp_com

Target Server Type    : MYSQL
Target Server Version : 50635
File Encoding         : 65001

Date: 2017-06-21 17:41:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `orderid` varchar(50) DEFAULT NULL,
  `openid` varchar(30) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `memotext` varchar(100) DEFAULT NULL,
  `cost` varchar(10) DEFAULT NULL,
  `count` smallint(5) DEFAULT NULL,
  `submittime` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('19700101080000_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497501075');
INSERT INTO `orders` VALUES ('20170615123210_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497501130');
INSERT INTO `orders` VALUES ('20170615124228_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497501748');
INSERT INTO `orders` VALUES ('20170615124255_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497501775');
INSERT INTO `orders` VALUES ('20170615124357_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497501837');
INSERT INTO `orders` VALUES ('20170615140845_', 'sdfdsfdsfsdfsdfdsf', '', '', '', '', '0', '1', '1497506925');
INSERT INTO `orders` VALUES ('20170615144353_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509033');
INSERT INTO `orders` VALUES ('20170615144455_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509095');
INSERT INTO `orders` VALUES ('20170615144506_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509106');
INSERT INTO `orders` VALUES ('20170615144522_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509122');
INSERT INTO `orders` VALUES ('20170615144540_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509140');
INSERT INTO `orders` VALUES ('20170615144714_15921776069', 'sdfdsfdsfsdfsdfdsf', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497509234');
INSERT INTO `orders` VALUES ('20170615144753_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509273');
INSERT INTO `orders` VALUES ('20170615144813_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509293');
INSERT INTO `orders` VALUES ('20170615144831_1', 'sdfdsfdsfsdfsdfdsf', '1', '1', '1', '1', '0.01', '1', '1497509311');
INSERT INTO `orders` VALUES ('20170616011031_15921776069', '', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497546631');
INSERT INTO `orders` VALUES ('20170616011502_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497546902');
INSERT INTO `orders` VALUES ('20170616011653_15921776069', '', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547013');
INSERT INTO `orders` VALUES ('20170616011855_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547135');
INSERT INTO `orders` VALUES ('20170616011909_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547149');
INSERT INTO `orders` VALUES ('20170616011951_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547191');
INSERT INTO `orders` VALUES ('20170616012025_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547225');
INSERT INTO `orders` VALUES ('20170616012049_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547249');
INSERT INTO `orders` VALUES ('20170616012146_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547306');
INSERT INTO `orders` VALUES ('20170616012229_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547349');
INSERT INTO `orders` VALUES ('20170616012257_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547377');
INSERT INTO `orders` VALUES ('20170616012435_15921776069', 'oGiQGuGRf3nBc5BkVPVm0RucGM58', '李亚龙', '15921776069', '哈哈', '', '0.01', '1', '1497547475');
