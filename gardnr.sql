SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `gardnr` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gardnr`;


CREATE TABLE IF NOT EXISTS `moduledata` (
`id` int(10) unsigned NOT NULL,
  `moduleid` int(11) NOT NULL,
  `datatime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `temp` float NOT NULL,
  `light` float NOT NULL,
  `moisture` float NOT NULL,
  `soiltemp` float NOT NULL,
  `humidity` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `modules` (
`id` int(10) unsigned NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `lastping` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `version` varchar(16) NOT NULL,
  `ipaddress` varchar(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;


INSERT INTO `modules` (`id`, `nickname`, `lastping`, `version`, `ipaddress`) VALUES
(1, 'Module 1', '0000-00-00 00:00:00', '0', '0'),
(2, 'Module 2', '0000-00-00 00:00:00', '0', '0'),
(3, 'Module 3', '0000-00-00 00:00:00', '0', '0'),
(4, 'Module 4', '0000-00-00 00:00:00', '0', '0'),
(5, 'Module 5', '0000-00-00 00:00:00', '0', '0'),
(6, 'Module 6', '0000-00-00 00:00:00', '0', '0'),
(7, 'Module 7', '0000-00-00 00:00:00', '0', '0'),
(8, 'Module 8', '0000-00-00 00:00:00', '0', '0'),
(9, 'Module 9', '0000-00-00 00:00:00', '0', '0'),
(10, 'Module 10', '0000-00-00 00:00:00', '0', '0'),
(11, 'Module 11', '0000-00-00 00:00:00', '0', '0'),
(12, 'Module 12', '0000-00-00 00:00:00', '0', '0'),
(13, 'Module 13', '0000-00-00 00:00:00', '0', '0'),
(14, 'Module 14', '0000-00-00 00:00:00', '0', '0'),
(15, 'Module 15', '0000-00-00 00:00:00', '0', '0'),
(16, 'Module 16', '0000-00-00 00:00:00', '0', '0');



CREATE TABLE IF NOT EXISTS `settings` (
  `temperature` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `settings` (`temperature`) VALUES
(1);


ALTER TABLE `moduledata`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `modules`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

ALTER TABLE `moduledata`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `modules`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;

