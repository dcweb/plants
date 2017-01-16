/*
Navicat MySQL Data Transfer

Source Server         : Combell_newserver
Source Server Version : 50623
Source Host           : 178.208.48.50:3306
Source Database       : dcms_groupdc_be

Target Server Type    : MYSQL
Target Server Version : 50623
File Encoding         : 65001

Date: 2016-11-04 11:42:57
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `plants_to_property`
-- ----------------------------
DROP TABLE IF EXISTS `plants_to_property`;
CREATE TABLE `plants_to_property` (
  `plant_id` int(10) unsigned NOT NULL,
  `plant_property_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`plant_id`,`plant_property_id`),
  KEY `FK_property` (`plant_property_id`),
  CONSTRAINT `FK_plant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_property` FOREIGN KEY (`plant_property_id`) REFERENCES `plants_property` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of plants_to_property
-- ----------------------------
INSERT INTO `plants_to_property` VALUES ('323', '4');
INSERT INTO `plants_to_property` VALUES ('323', '16');
INSERT INTO `plants_to_property` VALUES ('323', '17');
INSERT INTO `plants_to_property` VALUES ('323', '23');
INSERT INTO `plants_to_property` VALUES ('323', '25');

-- ----------------------------
-- Table structure for `plants_setting`
-- ----------------------------
DROP TABLE IF EXISTS `plants_setting`;
CREATE TABLE `plants_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_settingplant` (`plant_id`),
  CONSTRAINT `FK_settingplant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of plants_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `plants_property_language`
-- ----------------------------
DROP TABLE IF EXISTS `plants_property_language`;
CREATE TABLE `plants_property_language` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) unsigned DEFAULT NULL,
  `property_id` int(11) unsigned NOT NULL,
  `property` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_propertyid` (`property_id`),
  KEY `FK_propertylang` (`language_id`),
  CONSTRAINT `FK_propertyid` FOREIGN KEY (`property_id`) REFERENCES `plants_property` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_propertylang` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of plants_property_language
-- ----------------------------
INSERT INTO `plants_property_language` VALUES ('1', '1', '23', 'groentje', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:34:21');
INSERT INTO `plants_property_language` VALUES ('2', '2', '23', 'vert', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:11:33');
INSERT INTO `plants_property_language` VALUES ('3', '1', '19', 'geel', null, '0000-00-00 00:00:00', '2016-10-26 11:07:48');
INSERT INTO `plants_property_language` VALUES ('4', '2', '19', 'jaune', null, '0000-00-00 00:00:00', '2016-10-26 11:07:49');
INSERT INTO `plants_property_language` VALUES ('5', '1', '20', 'oranje', null, '0000-00-00 00:00:00', '2016-10-26 11:07:51');
INSERT INTO `plants_property_language` VALUES ('6', '2', '20', 'orange', null, '0000-00-00 00:00:00', '2016-10-26 11:07:52');
INSERT INTO `plants_property_language` VALUES ('7', '1', '21', 'rood', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `plants_property_language` VALUES ('8', '2', '21', 'rouge', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `plants_property_language` VALUES ('9', '1', '22', 'qsdf', 'bartr', '2016-10-27 12:12:03', '2016-10-27 12:12:03');
INSERT INTO `plants_property_language` VALUES ('12', '1', '14', 'zuur', 'bartr', '2016-10-27 12:20:53', '2016-10-27 12:20:53');
INSERT INTO `plants_property_language` VALUES ('13', '1', '4', 'zwart', 'bartr', '2016-10-27 12:21:49', '2016-10-27 12:21:49');
INSERT INTO `plants_property_language` VALUES ('14', '1', '3', 'zomer', 'bartr', '2016-10-27 12:21:57', '2016-10-27 12:21:57');
INSERT INTO `plants_property_language` VALUES ('15', '1', '5', 'vierkant', 'bartr', '2016-10-27 12:22:07', '2016-10-27 12:22:07');
INSERT INTO `plants_property_language` VALUES ('16', '1', '8', 'kegel', 'bartr', '2016-10-27 12:22:18', '2016-10-27 12:22:18');
INSERT INTO `plants_property_language` VALUES ('17', '1', '12', 'den hof', 'bartr', '2016-10-27 12:22:25', '2016-10-27 12:22:25');
INSERT INTO `plants_property_language` VALUES ('18', '1', '24', 'keuken', 'bartr', '2016-10-27 12:22:32', '2016-10-27 12:22:32');
INSERT INTO `plants_property_language` VALUES ('19', '1', '10', '7', 'bartr', '2016-10-27 12:22:39', '2016-10-27 12:22:39');
INSERT INTO `plants_property_language` VALUES ('20', '1', '11', 'zone5', 'bartr', '2016-10-27 12:24:37', '2016-10-27 12:24:37');
INSERT INTO `plants_property_language` VALUES ('21', '1', '6', 'bruin', 'bartr', '2016-10-27 12:24:47', '2016-10-27 12:24:47');
INSERT INTO `plants_property_language` VALUES ('22', '1', '18', 'beglie', 'bartr', '2016-10-27 12:24:55', '2016-10-27 12:24:55');
INSERT INTO `plants_property_language` VALUES ('23', '1', '7', 'xxx', 'bartr', '2016-10-27 12:25:10', '2016-10-27 12:25:10');
INSERT INTO `plants_property_language` VALUES ('24', '1', '15', 'pavementNL', 'bartr', '2016-10-27 12:25:21', '2016-10-27 12:25:21');
INSERT INTO `plants_property_language` VALUES ('25', '1', '16', 'januari', 'bartr', '2016-10-27 12:25:28', '2016-10-27 12:25:28');
INSERT INTO `plants_property_language` VALUES ('26', '1', '17', 'december', 'bartr', '2016-10-27 12:25:44', '2016-10-27 12:25:44');
INSERT INTO `plants_property_language` VALUES ('27', '1', '13', 'zand', 'bartr', '2016-10-27 12:25:55', '2016-10-27 12:25:55');
INSERT INTO `plants_property_language` VALUES ('28', '1', '9', 'volle zon', 'bartr', '2016-10-27 12:26:04', '2016-10-27 12:26:04');
INSERT INTO `plants_property_language` VALUES ('29', '1', '1', 'boom', 'bartr', '2016-10-27 12:26:12', '2016-10-27 12:26:12');
INSERT INTO `plants_property_language` VALUES ('30', '2', '25', 'FR iets anders', 'bartr', '2016-10-27 13:10:24', '2016-10-27 13:10:24');

-- ----------------------------
-- Table structure for `plants_property`
-- ----------------------------
DROP TABLE IF EXISTS `plants_property`;
CREATE TABLE `plants_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of plants_property
-- ----------------------------
INSERT INTO `plants_property` VALUES ('1', 'type', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:26:12');
INSERT INTO `plants_property` VALUES ('3', 'flowering_period', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:21:57');
INSERT INTO `plants_property` VALUES ('4', 'flowering_color', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:20:36');
INSERT INTO `plants_property` VALUES ('5', 'flowering_shape', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:22:07');
INSERT INTO `plants_property` VALUES ('6', 'leaf_color', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:24:47');
INSERT INTO `plants_property` VALUES ('7', 'ornamental', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:25:10');
INSERT INTO `plants_property` VALUES ('8', 'form', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:22:18');
INSERT INTO `plants_property` VALUES ('9', 'sun', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:26:04');
INSERT INTO `plants_property` VALUES ('10', 'hardiness', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:22:39');
INSERT INTO `plants_property` VALUES ('11', 'hardiness_zone', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:24:37');
INSERT INTO `plants_property` VALUES ('12', 'habitat', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:22:25');
INSERT INTO `plants_property` VALUES ('13', 'soil_type', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:25:55');
INSERT INTO `plants_property` VALUES ('14', 'acidity', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:20:53');
INSERT INTO `plants_property` VALUES ('15', 'pavement', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:25:21');
INSERT INTO `plants_property` VALUES ('16', 'planting_period', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:25:28');
INSERT INTO `plants_property` VALUES ('17', 'pruning_period', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:25:44');
INSERT INTO `plants_property` VALUES ('18', 'location', 'bartr', '0000-00-00 00:00:00', '2016-10-27 12:24:55');
INSERT INTO `plants_property` VALUES ('19', 'flowering_color', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `plants_property` VALUES ('20', 'flowering_color', null, '0000-00-00 00:00:00', '2016-10-26 11:07:43');
INSERT INTO `plants_property` VALUES ('21', 'flowering_color', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `plants_property` VALUES ('22', 'flowering_color', 'bartr', '2016-10-27 12:10:40', '2016-10-27 12:10:40');
INSERT INTO `plants_property` VALUES ('23', 'flowering_color', 'bartr', '2016-10-27 12:11:33', '2016-10-27 12:11:33');
INSERT INTO `plants_property` VALUES ('24', 'habitat', 'bartr', '2016-10-27 12:16:20', '2016-10-27 12:16:20');
INSERT INTO `plants_property` VALUES ('25', 'type', 'bartr', '2016-10-27 13:10:24', '2016-10-27 13:10:24');

-- ----------------------------
-- Table structure for `plants_language`
-- ----------------------------
DROP TABLE IF EXISTS `plants_language`;
CREATE TABLE `plants_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) unsigned DEFAULT NULL,
  `plant_id` int(11) unsigned DEFAULT NULL,
  `common_name` varchar(250) DEFAULT NULL,
  `description_1` varchar(255) DEFAULT NULL,
  `description_2` varchar(255) DEFAULT NULL,
  `origin_1` varchar(255) DEFAULT NULL,
  `bark` varchar(255) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `admin` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_plantlanguage` (`language_id`),
  KEY `FK_plantid` (`plant_id`),
  CONSTRAINT `plants_language_ibfk_1` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `plants_language_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=967 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plants_language
-- ----------------------------
INSERT INTO `plants_language` VALUES ('964', '1', '323', 'plant', '<p>desc1</p>\r\n', '<p>desc2 lalala</p>\r\n', 'op1', 'bark', 'plant', 'bartr', '2016-10-25 09:35:18', '2016-10-26 07:28:40');
INSERT INTO `plants_language` VALUES ('965', '2', '323', 'plantfr', '', '', '', '', 'plantfr', 'bartr', '2016-10-25 09:37:45', '2016-10-26 07:28:40');
INSERT INTO `plants_language` VALUES ('966', '1', '324', 'nl c1', '<p>d1</p>\r\n', '<p>d2</p>\r\n', 'o1', 'bnl', 'nl-c1', 'bartr', '2016-10-26 07:36:15', '2016-10-26 07:36:15');

-- ----------------------------
-- Table structure for `plants`
-- ----------------------------
DROP TABLE IF EXISTS `plants`;
CREATE TABLE `plants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `online` tinyint(4) DEFAULT '0' COMMENT '0 offline 1 online',
  `family_name` varchar(255) DEFAULT NULL COMMENT 'can be latin name - plants_language wil hold translation',
  `genus_name` varchar(255) DEFAULT NULL,
  `epithet_name` varchar(255) DEFAULT NULL,
  `cultivar_name` varchar(255) DEFAULT NULL,
  `description_3` text,
  `description_4` text,
  `origin_2` varchar(255) DEFAULT NULL,
  `height_min` int(11) DEFAULT NULL,
  `height_max` int(11) DEFAULT NULL,
  `evergreen` tinyint(4) DEFAULT NULL,
  `planting_depth_min` int(11) DEFAULT NULL,
  `planting_depth_max` int(11) DEFAULT NULL,
  `latitude` decimal(13,7) DEFAULT NULL,
  `longitude` decimal(13,7) DEFAULT NULL,
  `comment_1` varchar(255) DEFAULT NULL,
  `comment_2` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `admin` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=326 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plants
-- ----------------------------
INSERT INTO `plants` VALUES ('323', null, '1', '2', '0', '1', 'roosas', null, 'e', 'c', '<p>d3</p>\r\n', '<p>d4</p>\r\n', 'o', '0', '0', '0', '0', '0', '0.0000000', '0.0000000', '<p>c1</p>\r\n', '<p>c2</p>\r\n', null, null, '0000-00-00 00:00:00', '2016-10-28 09:30:59');
INSERT INTO `plants` VALUES ('324', null, '3', '4', '0', '1', 'gtaxus', null, 'etaxus', 'ctaxus', '<p>desc3</p>\r\n', '<p>desc4</p>\r\n', 'o2', '150', '200', '0', '100', '150', '6.2130000', '5.0000000', '<p>c1</p>\r\n', '<p>c2</p>\r\n', null, null, '2016-10-26 07:36:15', '2016-10-26 08:08:46');
INSERT INTO `plants` VALUES ('325', null, '5', '6', '0', '0', '', null, '', '', '', '', '', '0', '0', '0', '0', '0', '0.0000000', '0.0000000', '', '', null, null, '2016-10-28 09:29:03', '2016-10-28 09:29:03');
