<?php
require_once 'vendor/autoload.php';
require_once 'DB.php';
require_once 'HelperFunctions.php';

$loader = new \Twig\Loader\FilesystemLoader('tpl');
$twig = new \Twig\Environment($loader, [
    'cache' => 'temp',
    'auto_reload' => true,
]);

if (!empty($_POST)) {
    $team_a = $_POST['team_a'];
    $team_b = $_POST['team_b'];
    $who_won = (int)$_POST['who_won'];
    $mvp = (int)$_POST['mvp'];
    if (empty($team_a[0]) || empty($team_b[0])) {
        echo "Needs at least 1 player in either teams";
        die();
    };

    HelperFunctions::cast_to_int($team_a);
    HelperFunctions::cast_to_int($team_b);

    foreach ($team_a as $team_a_player) {
        if (in_array($team_a_player, $team_b) && $team_a_player != 0) {
            echo "Selected the same player on both teams";
            die();
        }
    }

    if ($who_won == 1) {
        if (!in_array($mvp, $team_a)) {
            echo "MVP is not in winning team!";
            die();
        }
    } else {
        if (!in_array($mvp, $team_b)) {
            echo "MVP is not in winning team!";
            die();
        }
    }

    HelperFunctions::insert_new_teams($team_a, $team_b);

    $team_a_id = HelperFunctions::get_team_id($team_a[0], $team_a[1], $team_a[2], $team_a[3]);
    $team_b_id = HelperFunctions::get_team_id($team_b[0], $team_b[1], $team_b[2], $team_b[3]);

    $winning_team_id = $team_b_id;
    if ($who_won == 1) {
        $winning_team_id = $team_a_id;
    }

    HelperFunctions::insert_new_match($team_a, $team_b, $team_a_id, $team_b_id, $mvp, $winning_team_id);

    echo "Done inserting a new result<br/>";

}

$data['players'] = HelperFunctions::get_players_data(HelperFunctions::SORT_BY_NAME);
$data['player_count'] = count($data['players']);

echo $twig->render('scores.tpl', [
    'data' => empty($data) ? '' : $data,
]);