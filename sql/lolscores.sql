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
DROP DATABASE IF EXISTS `lolscores`;
CREATE DATABASE IF NOT EXISTS `lolscores` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci */;
USE `lolscores`;


-- Jednotlive mody -------------------------------------------------

-- Exportování struktury pro tabulka lolscores.aram_unranked5x5
DROP TABLE IF EXISTS `stats_aram_unranked5x5`;
CREATE TABLE IF NOT EXISTS `stats_aram_unranked5x5` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Aram unranked 5v5';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.aram_unranked5x5
DROP TABLE IF EXISTS `stats_ascension`;
CREATE TABLE IF NOT EXISTS `stats_ascension` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Ascension';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.aram_unranked5x5
DROP TABLE IF EXISTS `stats_c_a_p5x5`;
CREATE TABLE IF NOT EXISTS `stats_c_a_p5x5` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='CAP';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.aram_unranked5x5
DROP TABLE IF EXISTS `stats_coop_vs_a_i`;
CREATE TABLE IF NOT EXISTS `stats_coop_vs_a_i` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `max_champions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Max champions killed',
  `average_node_capture` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node capture',
  `average_node_neutralize` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node neutralize',
  `average_team_objective` int(255) NOT NULL DEFAULT '0' COMMENT 'Average team objective',
  `average_total_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Average total player score',
  `average_combat_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Average combat player score',
  `average_objective_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Average objective player score',
  `average_node_capture_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node capture assist',
  `average_node_neutralize_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node neutralize assist',
  `max_node_capture` int(255) NOT NULL DEFAULT '0' COMMENT 'Max node capture',
  `max_node_neutralize` int(255) NOT NULL DEFAULT '0' COMMENT 'Max node neutralize',
  `max_team_objective` int(255) NOT NULL DEFAULT '0' COMMENT 'Max team objective',
  `max_total_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Max total player score',
  `max_combat_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Max combat player score',
  `max_objective_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Max objective player score',
  `max_node_capture_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Max  node capture assist',
  `max_node_neutralize_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Max  node neutralize assist',
  `total_node_neutralize` int(255) NOT NULL DEFAULT '0' COMMENT 'Total node neutralize',
  `total_node_capture` int(255) NOT NULL DEFAULT '0' COMMENT 'Total node capture',
  `average_champions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Average champions killed',
  `average_num_deaths` int(255) NOT NULL DEFAULT '0' COMMENT 'Average num deaths',
  `average_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Average assists',
  `max_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Max assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Coop vs AI';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.ranked_solo5x5
DROP TABLE IF EXISTS `stats_coop_vs_a_i3x3`;
CREATE TABLE IF NOT EXISTS `stats_coop_vs_a_i3x3` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Coop vs AI 3v3';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.ranked_solo5x5
DROP TABLE IF EXISTS `stats_nightmare_bot`;
CREATE TABLE IF NOT EXISTS `stats_nightmare_bot` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Nightmare bot';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.aram_unranked5x5
DROP TABLE IF EXISTS `stats_odin_unranked`;
CREATE TABLE IF NOT EXISTS `stats_odin_unranked` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `max_champions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Max champions killed',
  `average_node_capture` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node capture',
  `average_node_neutralize` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node neutralize',
  `average_team_objective` int(255) NOT NULL DEFAULT '0' COMMENT 'Average team objective',
  `average_total_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Average total player score',
  `average_combat_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Average combat player score',
  `average_objective_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Average objective player score',
  `average_node_capture_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node capture assist',
  `average_node_neutralize_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Average node neutralize assist',
  `max_node_capture` int(255) NOT NULL DEFAULT '0' COMMENT 'Max node capture',
  `max_node_neutralize` int(255) NOT NULL DEFAULT '0' COMMENT 'Max node neutralize',
  `max_team_objective` int(255) NOT NULL DEFAULT '0' COMMENT 'Max team objective',
  `max_total_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Max total player score',
  `max_combat_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Max combat player score',
  `max_objective_player_score` int(255) NOT NULL DEFAULT '0' COMMENT 'Max objective player score',
  `max_node_capture_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Max  node capture assist',
  `max_node_neutralize_assist` int(255) NOT NULL DEFAULT '0' COMMENT 'Max  node neutralize assist',
  `total_node_neutralize` int(255) NOT NULL DEFAULT '0' COMMENT 'Total node neutralize',
  `total_node_capture` int(255) NOT NULL DEFAULT '0' COMMENT 'Total node capture',
  `average_champions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Average champions killed',
  `average_num_deaths` int(255) NOT NULL DEFAULT '0' COMMENT 'Average num deaths',
  `average_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Average assists',
  `max_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Max assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Odin unranked';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.aram_unranked5x5
DROP TABLE IF EXISTS `stats_one_for_all5x5`;
CREATE TABLE IF NOT EXISTS `stats_one_for_all5x5` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='One for all 5v5';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.ranked_solo5x5
DROP TABLE IF EXISTS `stats_ranked_solo5x5`;
CREATE TABLE IF NOT EXISTS `stats_ranked_solo5x5` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `losses` int(255) NOT NULL DEFAULT '0' COMMENT 'Losses',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Solo/Duo ranked 5v5';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.ranked_solo5x5
DROP TABLE IF EXISTS `stats_ranked_team3x3`;
CREATE TABLE IF NOT EXISTS `stats_ranked_team3x3` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `losses` int(255) NOT NULL DEFAULT '0' COMMENT 'Losses',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Team ranked 3v3';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.ranked_solo5x5
DROP TABLE IF EXISTS `stats_ranked_team5x5`;
CREATE TABLE IF NOT EXISTS `stats_ranked_team5x5` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `losses` int(255) NOT NULL DEFAULT '0' COMMENT 'Losses',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Team ranked 5v5';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.ranked_solo5x5
DROP TABLE IF EXISTS `stats_summoners_rift6x6`;
CREATE TABLE IF NOT EXISTS `stats_summoners_rift6x6` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Summoners rift 6v6';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.unranked
DROP TABLE IF EXISTS `stats_unranked`;
CREATE TABLE IF NOT EXISTS `stats_unranked` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Unranked';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.unranked
DROP TABLE IF EXISTS `stats_unranked3x3`;
CREATE TABLE IF NOT EXISTS `stats_unranked3x3` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Unranked 3v3';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.unranked
DROP TABLE IF EXISTS `stats_u_r_f`;
CREATE TABLE IF NOT EXISTS `stats_u_r_f` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `wins` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Kills',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='URF';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.unranked
DROP TABLE IF EXISTS `ranked_stats`;
CREATE TABLE IF NOT EXISTS `ranked_stats` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `total_sessions_won` int(255) NOT NULL DEFAULT '0' COMMENT 'Wins',
  `total_sessions_lost` int(255) NOT NULL DEFAULT '0' COMMENT 'Loses',
  `total_assists` int(255) NOT NULL DEFAULT '0' COMMENT 'Assists',
  `total_champion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Champion kills',
  `total_physical_damage_dealt` int(255) NOT NULL DEFAULT '0' COMMENT 'Physical damage dealt',
  `total_magic_damage_dealt` int(255) NOT NULL DEFAULT '0' COMMENT 'Magic damage dealt',
  `total_damage_dealt` int(255) NOT NULL DEFAULT '0' COMMENT 'Damage dealt',
  `total_damage_taken` int(255) NOT NULL DEFAULT '0' COMMENT 'Damage taken',
  `total_deaths_per_session` int(255) NOT NULL DEFAULT '0' COMMENT 'Deaths per session',
  `total_sessions_played` int(255) NOT NULL DEFAULT '0' COMMENT 'Sessions played',
  `total_minion_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Minion kills',
  `total_turrets_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Turrets',
  `total_neutral_minions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Neutral minions killed',
  `total_heal` int(255) NOT NULL DEFAULT '0' COMMENT 'Heal',
  `total_gold_earned` int(255) NOT NULL DEFAULT '0' COMMENT 'Gold earned',
  `total_first_blood` int(255) NOT NULL DEFAULT '0' COMMENT 'First blood',
  `total_double_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Double kills',
  `total_triple_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Triple kills',
  `total_quadra_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Quadra kills',
  `total_penta_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Penta kills',
  `total_unreal_kills` int(255) NOT NULL DEFAULT '0' COMMENT 'Unreal kills',
  `killing_spree` int(255) NOT NULL DEFAULT '0' COMMENT 'Total killing spree',
  `max_champions_killed` int(255) NOT NULL DEFAULT '0' COMMENT 'Max kills',
  `max_largest_critical_strike` int(255) NOT NULL DEFAULT '0' COMMENT 'Largest critical strike',
  `max_largest_killing_spree` int(255) NOT NULL DEFAULT '0' COMMENT 'Largest killing spree',
  `max_time_spent_living` int(255) NOT NULL DEFAULT '0' COMMENT 'Max time spent living',
  `max_time_played` int(255) NOT NULL DEFAULT '0' COMMENT 'Max time played',
  `max_num_deaths` int(255) NOT NULL DEFAULT '0' COMMENT 'Max number of deaths',
  `most_champion_kills_per_session` int(255) NOT NULL DEFAULT '0' COMMENT 'Most champion kills',
  `ranked_premade_games_played` int(255) NOT NULL DEFAULT '0' COMMENT 'Ranked premade games played',
  `bot_games_played` int(255) NOT NULL DEFAULT '0' COMMENT 'Bot games played',
  `ranked_solo_games_played` int(255) NOT NULL DEFAULT '0' COMMENT 'Ranked solo games played',
  `normal_games_played` int(255) NOT NULL DEFAULT '0' COMMENT 'Normal games played',
  `modify_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Modify date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Ranked general stats';

-- Export dat nebyl vybrán.


-- Vseobecne parametre -----------------------------------------------


-- Exportování struktury pro tabulka lolscores.general
DROP TABLE IF EXISTS `general`;
CREATE TABLE IF NOT EXISTS `general` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Name',
  `profile_icon_id` int(255) NOT NULL DEFAULT '0' COMMENT 'Profile icon',
  `summoner_level` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner level',
  `revision_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Revision date',
  `date_stats` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Stats date',
  UNIQUE KEY `Index 1` (`id`,`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='General';

-- Export dat nebyl vybrán.

-- Exportování struktury pro tabulka lolscores.group
DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(255) NOT NULL DEFAULT '0' COMMENT 'Summoner ID',
  `region` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Region',
  `codename` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '0' COMMENT 'Codename',
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last updated',
  UNIQUE KEY `Index 1` (`region`,`codename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT COMMENT='General';

-- Export dat nebyl vybrán.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
