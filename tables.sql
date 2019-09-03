CREATE TABLE `matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team1_id` int(10) unsigned NOT NULL,
  `team2_id` int(10) unsigned NOT NULL,
  `mvp_id` int(10) unsigned DEFAULT NULL,
  `winning_team_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
);


CREATE TABLE `players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slack_id` varchar(45) NOT NULL,
  `player_name` varchar(255) NOT NULL,
  `github_username` varchar(255) DEFAULT NULL,
  `num_wins` int(11) NOT NULL DEFAULT 0,
  `num_losses` int(11) NOT NULL DEFAULT 0,
  `num_mvps` int(11) NOT NULL DEFAULT 0,
  `points` int(11) NOT NULL DEFAULT 0,
  `steam_username` varchar(255) DEFAULT NULL,
  `plays_rocket_league` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
);


CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player1_id` int(10) unsigned NOT NULL DEFAULT 0,
  `player2_id` int(10) unsigned NOT NULL DEFAULT 0,
  `player3_id` int(10) unsigned NOT NULL DEFAULT 0,
  `player4_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_team` (`player1_id`,`player2_id`,`player3_id`,`player4_id`),
  KEY `fk_player1_idx` (`player1_id`),
  KEY `fk_player2_idx` (`player2_id`),
  KEY `fk_player3_idx` (`player3_id`),
  KEY `fk_player4_idx` (`player4_id`)
);