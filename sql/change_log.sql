-- Table structure for table `change_log`
-- http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.logging.html
-- This schema must be installed in order for the form generator to work as planned.
-- Highly recommended, especially for multi-user environments. Disaster prevention.

CREATE TABLE IF NOT EXISTS `change_log` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(50) NOT NULL DEFAULT '',
  `host` varchar(255) NOT NULL DEFAULT '',
  `operation` varchar(50) NOT NULL DEFAULT '',
  `tab` varchar(50) NOT NULL DEFAULT '',
  `rowkey` varchar(255) NOT NULL DEFAULT '',
  `col` varchar(255) NOT NULL DEFAULT '',
  `oldval` mediumtext,
  `newval` mediumtext,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_tab` (`tab`),
  KEY `idx_col` (`col`),
  KEY `idx_operation` (`operation`),
  KEY `idx_rowkey` (`rowkey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='See the change_log features of phpMyEdit';
