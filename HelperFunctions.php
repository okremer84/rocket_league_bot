<?php


class HelperFunctions
{
    const SORT_BY_WINS = 1;
    const SORT_BY_NAME = 2;

    public static function get_team_id(int $player1_id, int $player2_id = 0, int $player3_id = 0, int $player4_id = 0) : int {
        $db = DB::get_instance();
        $stmt = $db->prepare("SELECT id FROM teams
                                    WHERE
                                    (player1_id = :player1_id AND player2_id = :player2_id AND player3_id = :player3_id AND player4_id = :player4_id)");

        $stmt->execute([
            ':player1_id' => $player1_id,
            ':player2_id' => $player2_id,
            ':player3_id' => $player3_id,
            ':player4_id' => $player4_id,
        ]);

        $team_id = (int)$stmt->fetchColumn();
        return $team_id;
    }

    public static function insert_new_teams(array $team_a, array $team_b) : void {
        $db = DB::get_instance();
        $stmt = $db->prepare("INSERT INTO teams (player1_id, player2_id, player3_id, player4_id) VALUES (:player1_id, :player2_id, :player3_id, :player4_id), (:player1_team_b_id, :player2_team_b_id, :player3_team_b_id, :player4_team_b_id) ON DUPLICATE KEY UPDATE player1_id = player1_id");
        $stmt->execute([
            ':player1_id' => $team_a[0],
            ':player2_id' => $team_a[1],
            ':player3_id' => $team_a[2],
            ':player4_id' => $team_a[3],
            ':player1_team_b_id' => $team_b[0],
            ':player2_team_b_id' => $team_b[1],
            ':player3_team_b_id' => $team_b[2],
            ':player4_team_b_id' => $team_b[3],
        ]);
    }

    public static function get_results() : array {
        $db = DB::get_instance();
        $stmt = $db->prepare("SELECT 
                                            t1.id team_1_id,
                                            t2.id team_2_id,
                                            winning_team_id,
                                            p1.player_name team1_p1_name,
                                            p2.player_name team1_p2_name,
                                            p3.player_name team1_p3_name,
                                            p4.player_name team1_p4_name,
                                            p5.player_name team2_p1_name,
                                            p6.player_name team2_p2_name,
                                            p7.player_name team2_p3_name,
                                            p8.player_name team2_p4_name,
                                            mvp.player_name mvp_name,
                                            m.created_at
                                        FROM
                                            matches m
                                                JOIN
                                            teams t1 ON m.team1_id = t1.id
                                                JOIN
                                            teams t2 ON m.team2_id = t2.id
                                                JOIN
                                            players p1 ON t1.player1_id = p1.id
                                                LEFT JOIN
                                            players p2 ON t1.player2_id = p2.id
                                                LEFT JOIN
                                            players p3 ON t1.player3_id = p3.id
                                                LEFT JOIN
                                            players p4 ON t1.player4_id = p4.id
                                                JOIN
                                            players p5 ON t2.player1_id = p5.id
                                                LEFT JOIN
                                            players p6 ON t2.player2_id = p6.id
                                                LEFT JOIN
                                            players p7 ON t2.player3_id = p7.id
                                                LEFT JOIN
                                            players p8 ON t2.player4_id = p8.id
                                                JOIN
                                            players mvp ON m.mvp_id = mvp.id
                                            ORDER BY m.created_at DESC  
                                        ;");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $matches = [];
        foreach ($result as $match) {
            $curr_match = [];
            if ($match['winning_team_id'] == $match['team_1_id']) {
                $curr_match['winning_team'][] = $match['team1_p1_name'];
                $curr_match['winning_team'][] = empty($match['team1_p2_name']) ? null : $match['team1_p2_name'];
                $curr_match['winning_team'][] = empty($match['team1_p3_name']) ? null : $match['team1_p3_name'];
                $curr_match['winning_team'][] = empty($match['team1_p4_name']) ? null : $match['team1_p4_name'];
                $curr_match['losing_team'][] = empty($match['team2_p1_name']) ? null : $match['team2_p1_name'];
                $curr_match['losing_team'][] = empty($match['team2_p2_name']) ? null : $match['team2_p2_name'];
                $curr_match['losing_team'][] = empty($match['team2_p3_name']) ? null : $match['team2_p3_name'];
                $curr_match['losing_team'][] = empty($match['team2_p4_name']) ? null : $match['team2_p4_name'];
            } else {
                $curr_match['winning_team'][] = $match['team2_p1_name'];
                $curr_match['winning_team'][] = empty($match['team2_p2_name']) ? null : $match['team2_p2_name'];
                $curr_match['winning_team'][] = empty($match['team2_p3_name']) ? null : $match['team2_p3_name'];
                $curr_match['winning_team'][] = empty($match['team2_p4_name']) ? null : $match['team2_p4_name'];
                $curr_match['losing_team'][] = empty($match['team1_p1_name']) ? null : $match['team1_p1_name'];
                $curr_match['losing_team'][] = empty($match['team1_p2_name']) ? null : $match['team1_p2_name'];
                $curr_match['losing_team'][] = empty($match['team1_p3_name']) ? null : $match['team1_p3_name'];
                $curr_match['losing_team'][] = empty($match['team1_p4_name']) ? null : $match['team1_p4_name'];
            }
            $curr_match['mvp'] = $match['mvp_name'];
            $curr_match['created_at'] = $match['created_at'];

            $matches[] = $curr_match;
        }

        return $matches;
    }

    public static function get_players_data(int $sort_by = self::SORT_BY_WINS) {
        $db = DB::get_instance();
        $sql = "SELECT id, player_name, num_wins, num_losses, num_mvps, points FROM players WHERE plays_rocket_league";
        if ($sort_by == self::SORT_BY_WINS) {
            $sql .= " ORDER BY points DESC, num_wins DESC, num_losses ASC";
        } elseif ($sort_by == self::SORT_BY_NAME) {
            $sql .= " ORDER BY player_name ASC";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $players = $stmt->fetchAll();
        return $players;
    }

    public static function cast_to_int(array &$team) {
        $team[0] = (int)$team[0];
        $team[1] = empty($team[1]) ? 0 : (int)$team[1];
        $team[2] = empty($team[2]) ? 0 : (int)$team[2];
        $team[3] = empty($team[3]) ? 0 : (int)$team[3];
    }

    public static function insert_new_match(array $team_a, array $team_b, int $team_a_id, int $team_b_id, int $mvp, int $winning_team_id) : void {
        $team_a_ids = "";
        $team_b_ids = "";
        $winning_team = $team_a;
        if ($winning_team_id == 2) {
            $winning_team = $team_b;
        }

        foreach ($team_a as $team_a_player) {
            if (!empty($team_a_player)) {
                $team_a_ids .= $team_a_player . ',';
            }
        }

        foreach ($team_b as $team_b_player) {
            if (!empty($team_b_player)) {
                $team_b_ids .= $team_b_player . ',';
            }
        }

        $team_a_ids = rtrim($team_a_ids, ',');
        $team_b_ids = rtrim($team_b_ids, ',');

        $db = DB::get_instance();
        $stmt = $db->prepare("INSERT INTO matches (team1_id, team2_id, mvp_id, winning_team_id) VALUES (:team1_id, :team2_id, :mvp_id, :winning_team_id)");
        $stmt->execute([
            ':team1_id' => $team_a_id,
            ':team2_id' => $team_b_id,
            ':mvp_id' => $mvp,
            ':winning_team_id' => $winning_team_id,
        ]);


        if ($winning_team_id == $team_a_id) {
            $stmt = $db->prepare("UPDATE players SET num_wins = num_wins + 1, points = points + 2 WHERE id IN ($team_a_ids)");
            $stmt->execute();
            $stmt = $db->prepare("UPDATE players SET num_losses = num_losses + 1 WHERE id IN ($team_b_ids)");
            $stmt->execute();
        } else {
            $stmt = $db->prepare("UPDATE players SET num_wins = num_wins + 1, points = points + 2 WHERE id IN ($team_b_ids)");
            $stmt->execute();
            $stmt = $db->prepare("UPDATE players SET num_losses = num_losses + 1 WHERE id IN ($team_a_ids)");
            $stmt->execute();
        }

        $stmt = $db->prepare("UPDATE players SET num_mvps = num_mvps + 1, points = points + 1 WHERE id = :mvp_id");
        $stmt->execute(['mvp_id' => $mvp]);
    }
}