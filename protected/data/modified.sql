CREATE TABLE `ew_log` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `level` VARCHAR(128) NULL DEFAULT NULL,
    `category` VARCHAR(128) NULL DEFAULT NULL,
    `logtime` INT(11) UNSIGNED NULL DEFAULT NULL,
    `message` TEXT NULL,
    `userId` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 表的结构 `YiiSession`
--

CREATE TABLE IF NOT EXISTS `YiiSession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  `userId` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `ew_log` ADD `ip` VARCHAR(128) NOT NULL COMMENT '写log时用户的ip' ;

CREATE TABLE `ew_media_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` char(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL DEFAULT '' COMMENT '内容',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upTime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文本课时';