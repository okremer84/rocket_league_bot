<?php

$pool_a = ['Omer', 'Dave', 'Alain', 'Wes'];
$pool_b = ['Philip', 'Amy', 'Rushabh', 'Andrea'];

shuffle($pool_a);
shuffle($pool_b);
$where_is_tj = mt_rand(1, 4);
$team_num = 1;
$result_str = "";
foreach ($pool_a as $player) {
    $result_str .= "Team $team_num: $player and " . $pool_b[$team_num - 1];
    $result_str .= "\n";
    $team_num++;
}

header('Content-Type: application/json');
        echo json_encode(array(
                'response_type' => 'in_channel',
                'attachments' => array(
                    [
                        "title" => "Today's Teams are:",
                        "text" => $result_str
                    ])
             ));

