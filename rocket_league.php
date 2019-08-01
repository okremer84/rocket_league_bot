<?php
header('Content-Type: application/json');
header("HTTP/1.1 200 OK");
/*
 * example for today's $_POST
 * Array
(
   [token] => Sye6vTyaJkzTfKWdyM3y0OL9
   [team_id] => T03K5BM9K
   [team_domain] => betterhelp
   [channel_id] => D1H3Q8TPE
   [channel_name] => directmessage
   [user_id] => U1GLRECF2
   [user_name] => omer
   [command] => /create_teams
   [text] =>
   [response_url] => https://hooks.slack.com/commands/T03K5BM9K/712677150928/To8pFBehsuBZAagClXeITUk7
   [trigger_id] => 701286759315.3651395325.06f28b3967c8a4e418eaa437e3318101
)
 */

// Sending messages from the bot back to #rocketleague

//$slack_webhook_url = "https://hooks.slack.com/services/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";
//$ch = curl_init($slack_webhook_url);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
//curl_setopt($ch, CURLOPT_CRLF, true);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($slack_call, CURLOPT_HTTPHEADER, [
//        "Content-Type: application/json",
//        "Content-Length: " . strlen($json_string)]
//);
//$result = curl_exec($ch);
//curl_close($ch);

// Return immediate response
header("Content-Type: application/json");
fastcgi_finish_request();

$pool_a = ['Omer', 'Dave', 'Alain', 'Wes'];
$pool_b = ['Philip', 'Amy', 'Rushabh', 'Andrea'];

shuffle($pool_a);
shuffle($pool_b);
$team_num = 1;
$result_str = "";
foreach ($pool_a as $player) {
    $result_str .= "Team $team_num: $player and " . $pool_b[$team_num - 1];
    $result_str .= "\n";
    $team_num++;
}

$response = json_encode(array(
        'response_type' => 'in_channel',
        'attachments' => array(
            [
                "title" => "Today's Teams are:",
                "text" => $result_str
            ])
     ));

$ch = curl_init($_POST['response_url']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
curl_setopt($ch, CURLOPT_CRLF, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Content-Length: " . strlen($response)]
);
$result = curl_exec($ch);
curl_close($ch);
