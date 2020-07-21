SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `cs__words`;
CREATE TABLE `cs__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `de__words`;
CREATE TABLE `de__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `en__words`;
CREATE TABLE `en__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `es__words`;
CREATE TABLE `es__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `fr__words`;
CREATE TABLE `fr__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `hy__words`;
CREATE TABLE `hy__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `it__words`;
CREATE TABLE `it__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `lid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  `domain` varchar(2) NOT NULL,
  `popularity` int(10) unsigned DEFAULT NULL,
  `active` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `nl__words`;
CREATE TABLE `nl__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `exclude_sitemap` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pl__words`;
CREATE TABLE `pl__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pt__words`;
CREATE TABLE `pt__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ru__words`;
CREATE TABLE `ru__words` (
  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_de`;
CREATE TABLE `trans__cs_de` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_en`;
CREATE TABLE `trans__cs_en` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_es`;
CREATE TABLE `trans__cs_es` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_fr`;
CREATE TABLE `trans__cs_fr` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_it`;
CREATE TABLE `trans__cs_it` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_nl`;
CREATE TABLE `trans__cs_nl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_pl`;
CREATE TABLE `trans__cs_pl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_pt`;
CREATE TABLE `trans__cs_pt` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__cs_ru`;
CREATE TABLE `trans__cs_ru` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__de_en`;
CREATE TABLE `trans__de_en` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__de_fr`;
CREATE TABLE `trans__de_fr` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__de_pl`;
CREATE TABLE `trans__de_pl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_es`;
CREATE TABLE `trans__en_es` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_fr`;
CREATE TABLE `trans__en_fr` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_hy`;
CREATE TABLE `trans__en_hy` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_it`;
CREATE TABLE `trans__en_it` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_nl`;
CREATE TABLE `trans__en_nl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_pl`;
CREATE TABLE `trans__en_pl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_pt`;
CREATE TABLE `trans__en_pt` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__en_ru`;
CREATE TABLE `trans__en_ru` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__es_fr`;
CREATE TABLE `trans__es_fr` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__es_pl`;
CREATE TABLE `trans__es_pl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__fr_it`;
CREATE TABLE `trans__fr_it` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__fr_nl`;
CREATE TABLE `trans__fr_nl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__fr_pl`;
CREATE TABLE `trans__fr_pl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__fr_pt`;
CREATE TABLE `trans__fr_pt` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__fr_ru`;
CREATE TABLE `trans__fr_ru` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__hy_ru`;
CREATE TABLE `trans__hy_ru` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__it_pl`;
CREATE TABLE `trans__it_pl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__nl_pl`;
CREATE TABLE `trans__nl_pl` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__pl_pt`;
CREATE TABLE `trans__pl_pt` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `trans__pl_ru`;
CREATE TABLE `trans__pl_ru` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wid1` int(10) unsigned NOT NULL,
  `wid2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
