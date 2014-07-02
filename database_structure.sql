# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.34)
# Database: snelkoppeling
# Generation Time: 2014-07-02 23:28:07 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table answers
# ------------------------------------------------------------

CREATE TABLE `answers` (
  `person_id` int(64) NOT NULL,
  `ans` int(64) NOT NULL,
  `quest` int(64) NOT NULL,
  PRIMARY KEY (`person_id`,`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table blocked_ip
# ------------------------------------------------------------

CREATE TABLE `blocked_ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table desired
# ------------------------------------------------------------

CREATE TABLE `desired` (
  `des_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(64) NOT NULL,
  `ans` int(2) NOT NULL,
  `quest` int(64) NOT NULL,
  PRIMARY KEY (`des_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table gegevens
# ------------------------------------------------------------

CREATE TABLE `gegevens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `age` int(3) NOT NULL,
  `state` int(2) NOT NULL,
  `sexse` int(2) DEFAULT NULL,
  `gender` int(2) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `picture` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(64) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `verified` int(1) unsigned zerofill NOT NULL,
  `about_me` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table importance
# ------------------------------------------------------------

CREATE TABLE `importance` (
  `person_id` int(11) NOT NULL,
  `imp` int(2) NOT NULL,
  `quest` int(64) NOT NULL,
  PRIMARY KEY (`person_id`,`quest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table matches
# ------------------------------------------------------------

CREATE TABLE `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `A` int(11) NOT NULL,
  `B` int(11) NOT NULL,
  `match` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table quest_ans
# ------------------------------------------------------------

CREATE TABLE `quest_ans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quest_id` int(11) NOT NULL,
  `answer` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table questions
# ------------------------------------------------------------

CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
