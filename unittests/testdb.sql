DROP TABLE IF EXISTS `testTable1`;
CREATE TABLE `testTable1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `column1` varchar(15) DEFAULT NULL,
  `column2` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `column1` (`column1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `testTable2`;
CREATE TABLE `testTable2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `column1` text CHARACTER SET latin1,
  `column2` int(11) NOT NULL,
  `column3` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `column2` (`column2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `testTable1` (`id`, `column1`, `column2`) VALUES
(1, 'test1', 25),
(2, 'test2', 47);

INSERT INTO `testTable2` (`id`, `column1`, `column2`, `column3`) VALUES
(1, 'Just a little text.', 65, 'oopsa!'),
(2, 'Just another little text.', 42, 'yes');