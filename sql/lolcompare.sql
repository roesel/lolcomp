-- --------------------------------------------------------
-- Hostitel:                     127.0.0.1
-- Verze serveru:                5.6.20 - MySQL Community Server (GPL)
-- OS serveru:                   Win32
-- HeidiSQL Verze:               8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportování struktury databáze pro
DROP DATABASE IF EXISTS `lolcompare`;
CREATE DATABASE IF NOT EXISTS `lolcompare` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci */;
USE `lolcompare`;


-- Exportování struktury pro tabulka lolcompare.players_clas5v5
DROP TABLE IF EXISTS `ranked_solo5x5`;
CREATE TABLE IF NOT EXISTS `ranked_solo5x5` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp kdy byl vytvořen daný záznam.',
  -- odsud dál specificky
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `losses` int(255) NOT NULL DEFAULT '0' COMMENT 'Losses',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Solo ranked 5v5';

-- Exportování struktury pro tabulka lolcompare.players_clas5v5
DROP TABLE IF EXISTS `unranked`;
CREATE TABLE IF NOT EXISTS `unranked` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp kdy byl vytvořen daný záznam.',
  -- odsud dál specificky
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Unranked';


-- Export dat nebyl vybrán.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
