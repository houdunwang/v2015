/*
Navicat MySQL Data Transfer

Source Server         : pay.hdphp.com
Source Server Version : 50635
Source Host           : 120.55.180.124:3306
Source Database       : pay_hdphp_com

Target Server Type    : MYSQL
Target Server Version : 50635
File Encoding         : 65001

Date: 2017-06-21 17:41:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ceshitable
-- ----------------------------
DROP TABLE IF EXISTS `ceshitable`;
CREATE TABLE `ceshitable` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  `price` varchar(10) DEFAULT NULL,
  `titleimg` varchar(50) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ceshitable
-- ----------------------------
INSERT INTO `ceshitable` VALUES ('1', '后盾网前段视频教程', '0.01', 'images/titlepic.png', '只讲真功夫，绝不浪得虚名', '后盾网隶属于北京后盾计算机技术培训有限责任公司，是专注于培养中国互联网顶尖PHP程序语言专业人才的专业型培训机构，拥有五年培训行业经验。后盾网拥有国内最顶尖的讲师和技术团队，团队成员项目经验均在8年以上，团队曾多次为国内外上市集团、政府机关的大型项目提供技术支持，其中包括新浪、搜狐、腾讯、宝洁公司、联想、丰田、工商银行、中国一汽等众多大众所熟知的知名企业。');
INSERT INTO `ceshitable` VALUES ('2', '后盾网PHP视频教程', '0.01', 'images/titlepic.png', '只讲真功夫，绝不浪得虚名', '后盾网隶属于北京后盾计算机技术培训有限责任公司，是专注于培养中国互联网顶尖PHP程序语言专业人才的专业型培训机构，拥有五年培训行业经验。后盾网拥有国内最顶尖的讲师和技术团队，团队成员项目经验均在8年以上，团队曾多次为国内外上市集团、政府机关的大型项目提供技术支持，其中包括新浪、搜狐、腾讯、宝洁公司、联想、丰田、工商银行、中国一汽等众多大众所熟知的知名企业。');
INSERT INTO `ceshitable` VALUES ('3', '后盾网LINUX视频教程', '0.01', 'images/titlepic.png', '只讲真功夫，绝不浪得虚名', '后盾网隶属于北京后盾计算机技术培训有限责任公司，是专注于培养中国互联网顶尖PHP程序语言专业人才的专业型培训机构，拥有五年培训行业经验。后盾网拥有国内最顶尖的讲师和技术团队，团队成员项目经验均在8年以上，团队曾多次为国内外上市集团、政府机关的大型项目提供技术支持，其中包括新浪、搜狐、腾讯、宝洁公司、联想、丰田、工商银行、中国一汽等众多大众所熟知的知名企业。');
