SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `ip` text,
  `port` text,
  `username` text,
  `password` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerID` int(11) NOT NULL DEFAULT '0',
  `nodeID` int(11) NOT NULL DEFAULT '0',
  `name` text,
  `jarFile` text,
  `maxRam` text,
  `ip` text,
  `port` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `hidden` int(11) DEFAULT NULL,
  `cleanName` text,
  `value` text,
  `isDropdown` int(11) DEFAULT NULL,
  `dropdownOptions` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `settings` (`id`, `name`, `hidden`, `cleanName`, `value`, `isDropdown`, `dropdownOptions`) VALUES
(1, 'site_name', 0, 'Site''s Name', 'StartPanel', 0, NULL),
(2, 'bs_theme', 0, 'Bootstrap Theme', 'default', 1, 'default&cerulean&cosmo&cyborg&darkly&flatly&journal&litera&lumen&lux&materia&minty&pulse&sandstone&simplex&sketchy&slate&solar&spacelab&superhero&united&yeti'),
(3, 'minRam', 1, 'Minimum RAM', '128', 0, NULL),
(4, 'maxRam', 0, 'Maximum RAM', '10240', 0, NULL);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  `email` text,
  `isAdmin` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `isAdmin`) VALUES
(1, 'Administrator', '$2y$10$tU5tn4xs.n7/eDWpcjCv2eltyEX5s4h74jzFMOr6MxynxHE8qXKCC', 'admin@localhost', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
