/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : 127.0.0.1:3306
Source Database       : miao

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2016-09-21 22:57:14
*/

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `parent_id`   INT(11)               DEFAULT NULL,
  `name`        VARCHAR(255) NOT NULL,
  `title`       VARCHAR(255) NOT NULL,
  `sort`        INT(11)               DEFAULT NULL,
  `is_show`     TINYINT(1)   NOT NULL DEFAULT '1',
  `show_in_nav` TINYINT(1)   NOT NULL DEFAULT '0',
  `created_at`  DATETIME              DEFAULT NULL,
  `updated_at`  DATETIME              DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARSET = utf8
  COMMENT = '分类表';

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category`
VALUES ('1', NULL, 'software', '编程', '1', '1', '1', '2016-09-14 11:52:22', '2016-09-14 11:52:22');
INSERT INTO `category` VALUES ('2', NULL, 'travel', '旅行', '2', '1', '1', '2016-09-14 11:52:22', '2016-09-14 11:52:22');
INSERT INTO `category` VALUES ('3', NULL, 'anime', '动漫', '4', '1', '0', '2016-09-14 11:52:22', '2016-09-14 11:52:22');
INSERT INTO `category`
VALUES ('4', NULL, 'delicacy', '美食', '5', '0', '0', '2016-09-14 11:52:22', '2016-09-14 11:52:22');
INSERT INTO `category`
VALUES ('5', NULL, 'succulent', '多肉植物', '6', '1', '1', '2016-09-14 11:52:22', '2016-09-14 11:52:22');
INSERT INTO `category`
VALUES ('6', NULL, 'photography', '摄影', '3', '1', '1', '2016-09-14 11:52:22', '2016-09-14 11:52:22');
INSERT INTO `category` VALUES ('7', NULL, 'cat', '喵', '7', '1', '1', '2016-09-14 11:52:22', '2016-09-14 11:52:22');
INSERT INTO `category` VALUES ('8', '1', 'php', 'php', '8', '1', '0', '2016-09-14 11:52:22', '2016-09-14 11:52:22');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id`         INT(11)     NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(70) NOT NULL,
  `user_name`  VARCHAR(70) NOT NULL,
  `password`   VARCHAR(40) NOT NULL,
  `email`      VARCHAR(70) NOT NULL,
  `phone`      VARCHAR(20)          DEFAULT NULL,
  `created_at` DATETIME             DEFAULT NULL,
  `updated_at` DATETIME             DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COMMENT = '用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES
  ('1', 'Robbie', 'robbie', '12345678', 'kunloon@qq.com', '18580756623', '2016-09-21 22:41:23', '2016-09-21 22:41:23');
INSERT INTO `user`
VALUES ('2', 'liu', 'liu', '12345678', 'liu@qq.com', '13667648212', '2016-09-21 22:41:23', '2016-09-21 22:41:23');

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id`            INT(11)      NOT NULL AUTO_INCREMENT,
  `category_id`   INT(11)      NOT NULL,
  `name`          VARCHAR(255) NOT NULL,
  `title`         VARCHAR(255) NOT NULL,
  `user_id`       INT(11)      NOT NULL,
  `content`       TEXT         NOT NULL,
  `cover_img_url` VARCHAR(255)          DEFAULT NULL,
  `is_show`       TINYINT(1)            DEFAULT '1',
  `view_count`    INT(11)               DEFAULT 0,
  `comment_count` INT(11)               DEFAULT 0,
  `deleted_at`    DATETIME              DEFAULT NULL,
  `created_at`    DATETIME              DEFAULT NULL,
  `updated_at`    DATETIME              DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)

)
  ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8
  COMMENT = '文章表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '1', 'good-blog', '北京3日游', '1',
                                   '这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客',
                                   'http://demo13.ledkongzhiqi.com/wp-content/themes/HuXiu/timthumb.php?src=http://demo13.ledkongzhiqi.com/wp-content/uploads/2016/02/151709987296.jpg&h=125.2&w=220&zc=1',
                                   '1', NULL, '2016-09-20 15:25:39', '2016-09-20 15:25:39');
INSERT INTO `article` VALUES ('2', '1', '', '摄影：一只花猫', '1',
                                   '这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客',
                                   'http://demo13.ledkongzhiqi.com/wp-content/themes/HuXiu/timthumb.php?src=http://demo13.ledkongzhiqi.com/wp-content/uploads/2016/01/100139792.png&h=160&w=280&zc=1',
                                   '1', NULL, '2016-09-20 15:25:39', '2016-09-20 15:25:39');
INSERT INTO `article` VALUES ('3', '1', '', 'Ruby的一些坑', '2',
                                   '这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客',
                                   'http://demo13.ledkongzhiqi.com/wp-content/themes/HuXiu/timthumb.php?src=http://demo13.ledkongzhiqi.com/wp-content/uploads/2016/01/212848535509.jpg&h=125.2&w=220&zc=1',
                                   '1', NULL, '2016-09-20 15:25:39', '2016-09-20 15:25:39');
INSERT INTO `article` VALUES ('4', '1', 'test1', 'PHP是世界上最好的语言，没有之一', '2',
                                   '这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客',
                                   'http://demo13.ledkongzhiqi.com/wp-content/themes/HuXiu/timthumb.php?src=http://demo13.ledkongzhiqi.com/wp-content/uploads/2016/02/u36253753983445398622fm21gp0.jpg&h=125.2&w=220&zc=1',
                                   '1', NULL, '2016-09-20 15:25:39', '2016-09-20 15:25:39');
INSERT INTO `article` VALUES ('5', '1', 'good2', '一个好博客应该有的标题', '2',
                                   '这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客这是一个好博客',
                                   'http://demo13.ledkongzhiqi.com/wp-content/themes/HuXiu/timthumb.php?src=http://demo13.ledkongzhiqi.com/wp-content/uploads/2016/02/QQ%E6%88%AA%E5%9B%BE20160403173437.jpg&h=125.2&w=220&zc=1',
                                   '0', NULL, '2016-09-20 15:25:39', '2016-09-20 15:25:39');