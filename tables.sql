CREATE TABLE `matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team1_id` int(10) unsigned NOT NULL,
  `team2_id` int(10) unsigned NOT NULL,
  `mvp_id` int(10) unsigned DEFAULT NULL,
  `winning_team_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE `players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slack_id` varchar(45) NOT NULL,
  `player_name` varchar(255) NOT NULL,
  `github_username` varchar(255) DEFAULT NULL,
  `num_wins` int(11) NOT NULL DEFAULT '0',
  `num_losses` int(11) NOT NULL DEFAULT '0',
  `num_mvps` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  `steam_username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player1_id` int(10) unsigned DEFAULT NULL,
  `player2_id` int(10) unsigned DEFAULT NULL,
  `player3_id` int(10) unsigned DEFAULT NULL,
  `player4_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_team` (`player1_id`,`player2_id`,`player3_id`,`player4_id`),
  KEY `fk_player2_idx` (`player2_id`),
  KEY `fk_player3_idx` (`player3_id`),
  KEY `fk_player4_idx` (`player4_id`),
  CONSTRAINT `fk_player1` FOREIGN KEY (`player1_id`) REFERENCES `players` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_player2` FOREIGN KEY (`player2_id`) REFERENCES `players` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_player3` FOREIGN KEY (`player3_id`) REFERENCES `players` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_player4` FOREIGN KEY (`player4_id`) REFERENCES `players` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);