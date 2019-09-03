<?php
require_once 'vendor/autoload.php';
require_once 'DB.php';
require_once 'HelperFunctions.php';

$loader = new \Twig\Loader\FilesystemLoader('tpl');
$twig = new \Twig\Environment($loader, [
    'cache' => 'temp',
    'auto_reload' => true,
]);

$matches = HelperFunctions::get_results();
$players = HelperFunctions::get_players_data();
$data['matches'] = $matches;
$data['players'] = $players;

echo $twig->render('results.tpl', [
    'data' => empty($data) ? '' : $data,
]);
