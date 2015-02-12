
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(160) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(6) NOT NULL,
  `hours` decimal(6,2) DEFAULT NULL,
  `rate` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(160) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `description` varchar(160) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `times` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stop` datetime DEFAULT '0000-00-00 00:00:00',
  `break` decimal(5,2) NOT NULL DEFAULT '0.00',
  `task` varchar(100) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `note` varchar(160) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 ;

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Gruender', '2008-02-28 13:39:54', '2008-02-28 13:40:06'),
(2, 'Mitarbeiter', NULL, NULL);

