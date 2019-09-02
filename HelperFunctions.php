<?php


class HelperFunctions
{
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

    public static function cast_to_int(array &$team) {
        $team[0] = (int)$team[0];
        $team[1] = empty($team[1]) ? 0 : (int)$team[1];
        $team[2] = empty($team[2]) ? 0 : (int)$team[2];
        $team[3] = empty($team[3]) ? 0 : (int)$team[3];
    }

    public static function insert_new_match(int $team_a_id, int $team_b_id, int $mvp, int $winning_team_id) : void {
        $db = DB::get_instance();
        $stmt = $db->prepare("INSERT INTO matches (team1_id, team2_id, mvp_id, winning_team_id) VALUES (:team1_id, :team2_id, :mvp_id, :winning_team_id)");
        $stmt->execute([
            ':team1_id' => $team_a_id,
            ':team2_id' => $team_b_id,
            ':mvp_id' => $mvp,
            ':winning_team_id' => $winning_team_id,
        ]);
    }
}