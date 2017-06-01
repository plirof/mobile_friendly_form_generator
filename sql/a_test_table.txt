--
-- Table structure for table `a_test_table` contains a wide variety of column types
--

DROP TABLE IF EXISTS `a_test_table`;
CREATE TABLE `a_test_table` (
  `smallint_column` smallint(5) NOT NULL AUTO_INCREMENT COMMENT 'comment for smallint_column',
  `varchar_column` varchar(255) DEFAULT NULL COMMENT 'comment for varchar_column',
  `email_varchar_column` varchar(255) NOT NULL COMMENT 'enter an email address e.g. none@foo.net',
  `http_varchar_column` varchar(255) NOT NULL COMMENT 'Enter a domain name e.g. google.com',
  `float_column` float(8,2) NOT NULL DEFAULT '1.23' COMMENT 'comment for float_column',
  `date_column` date NOT NULL COMMENT 'comment for date_column',
  `enum_column` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0' COMMENT 'comment for enum_column',
  `set_column` set('a','b','c') NOT NULL COMMENT 'comment for set_column',
  `text_column` text NOT NULL COMMENT 'comment for text_column',
  `timestamp_column` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'comment for timestamp_column',
  `flag_hidden_enum` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'comment for flag_hidden_enum',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'comment for deleted',
  PRIMARY KEY (`smallint_column`),
  KEY `idx_deleted` (`deleted`),
  KEY `idx_hidden` (`flag_hidden_enum`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

