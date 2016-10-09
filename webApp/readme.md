##基于 angular.js+gulp+require.js+api+前台后完全分享的webapp开发

* admin 后台
* app 前台

## 配置
要安装下面的SQL,然后配置system/database.php数据库连接配置

## 接口配置
根据目录结构修改 admin/apidoc.json配置

## 数据表

```
DROP TABLE IF EXISTS `hd_core_attachment`;

CREATE TABLE `hd_core_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `filename` varchar(300) NOT NULL COMMENT '文件名',
  `path` varchar(300) NOT NULL COMMENT '相对路径',
  `extension` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `createtime` int(10) NOT NULL COMMENT '上传时间',
  `size` mediumint(9) NOT NULL COMMENT '文件大小',
  `data` varchar(100) NOT NULL DEFAULT '' COMMENT '辅助信息',
  `hash` char(50) NOT NULL DEFAULT '' COMMENT '标识用于区分资源',
  PRIMARY KEY (`id`),
  KEY `data` (`data`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件';

LOCK TABLES `hd_core_attachment` WRITE;
/*!40000 ALTER TABLE `hd_core_attachment` DISABLE KEYS */;

INSERT INTO `hd_core_attachment` (`id`, `name`, `filename`, `path`, `extension`, `createtime`, `size`, `data`, `hash`)
VALUES
	(1,'getheadimg','9941473349495','attachment/2016/09/08/9941473349495.jpg','jpg',1473349495,6029,'','1'),
	(2,'getheadimg','84511473349507','attachment/2016/09/08/84511473349507.jpg','jpg',1473349507,6029,'hd','2'),
	(3,'IMG_0833','76451473349514','attachment/2016/09/08/76451473349514.png','png',1473349514,2010243,'hd','2'),
	(4,'sun','59231473349530','attachment/2016/09/08/59231473349530.png','png',1473349530,27861,'hd','2'),
	(5,'IMG_0833','11771473349605','attachment/2016/09/08/11771473349605.png','png',1473349605,2010243,'','1'),
	(6,'getheadimg','83951473349703','attachment/2016/09/08/83951473349703.jpg','jpg',1473349703,6029,'hd','2'),
	(7,'sun','32431473349797','attachment/2016/09/08/32431473349797.png','png',1473349797,27861,'hd','2'),
	(8,'getheadimg','59201473349797','attachment/2016/09/08/59201473349797.jpg','jpg',1473349797,6029,'hd','2'),
	(9,'sun','72281473349797','attachment/2016/09/08/72281473349797.jpg','jpg',1473349797,34718,'hd','2'),
	(10,'getheadimg','38601473350191','attachment/2016/09/08/38601473350191.jpg','jpg',1473350191,6029,'hd','2'),
	(11,'sun','21791473350191','attachment/2016/09/08/21791473350191.png','png',1473350191,27861,'hd','2'),
	(12,'sun','52561473350521','attachment/2016/09/09/52561473350521.png','png',1473350521,27861,'hd','2'),
	(13,'IMG_0833','28111473350521','attachment/2016/09/09/28111473350521.png','png',1473350521,2010243,'hd','2'),
	(14,'getheadimg','90371473350663','attachment/2016/09/09/90371473350663.jpg','jpg',1473350663,6029,'','1');

/*!40000 ALTER TABLE `hd_core_attachment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_category`;

CREATE TABLE `hd_category` (
  `cid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(50) NOT NULL DEFAULT '' COMMENT '菜品分类名称',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_category` WRITE;
/*!40000 ALTER TABLE `hd_category` DISABLE KEYS */;

INSERT INTO `hd_category` (`cid`, `catname`)
VALUES
	(3,'风味盖饭'),
	(4,'饮料酒水');

/*!40000 ALTER TABLE `hd_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_goods
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_goods`;

CREATE TABLE `hd_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `price` decimal(6,2) NOT NULL COMMENT '价格',
  `content` text NOT NULL COMMENT '介绍',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '菜品图片',
  `cid` int(11) NOT NULL COMMENT '分类编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_goods` WRITE;
/*!40000 ALTER TABLE `hd_goods` DISABLE KEYS */;

INSERT INTO `hd_goods` (`id`, `title`, `price`, `content`, `thumb`, `cid`)
VALUES
	(1,'土豆丝盖饭',0.00,'<p>sddsds</p>','attachment/2016/09/08/9941473349495.jpg',3),
	(2,'鱼香肉丝盖饭',0.00,'<p>sddsdsds</p>','attachment/2016/09/08/11771473349605.png',3),
	(3,'可口可乐',3.00,'<p>sdsdsd</p>','attachment/2016/09/08/9941473349495.jpg',4);

/*!40000 ALTER TABLE `hd_goods` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_shop
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_shop`;

CREATE TABLE `hd_shop` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `content` text NOT NULL COMMENT '店铺介绍',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_shop` WRITE;
/*!40000 ALTER TABLE `hd_shop` DISABLE KEYS */;

INSERT INTO `hd_shop` (`id`, `title`, `tel`, `content`, `thumb`)
VALUES
	(1,'金百万小吃','18722222000','<p><img src=\"attachment/2016/09/09/52561473350521.png\" style=\"\"/></p><p><img src=\"attachment/2016/09/08/21791473350191.png\" style=\"\"/></p><p><img src=\"attachment/2016/09/08/76451473349514.png\" style=\"\"/></p><p><img src=\"attachment/2016/09/08/84511473349507.jpg\" style=\"\"/></p><p><img src=\"attachment/2016/09/09/52561473350521.png\" style=\"\"/></p><p><img src=\"attachment/2016/09/08/21791473350191.png\" style=\"\"/></p><p><img src=\"attachment/2016/09/08/76451473349514.png\" style=\"\"/></p><p><img src=\"attachment/2016/09/08/84511473349507.jpg\" style=\"\"/></p><p><br/></p>','attachment/2016/09/09/90371473350663.jpg');

/*!40000 ALTER TABLE `hd_shop` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_user`;

CREATE TABLE `hd_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_user` WRITE;
/*!40000 ALTER TABLE `hd_user` DISABLE KEYS */;

INSERT INTO `hd_user` (`id`, `username`, `password`)
VALUES
	(1,'admin','7fef6171469e80d32c0559f88b377245');

/*!40000 ALTER TABLE `hd_user` ENABLE KEYS */;
UNLOCK TABLES;

```


