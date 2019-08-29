<?php
require_once 'vendor/autoload.php';
require_once 'DB.php';

$loader = new \Twig\Loader\FilesystemLoader('/');
$twig = new \Twig\Environment($loader, [
    'cache' => 'temp',
    'auto_reload' => true,
]);

if (!empty($_POST)) {
    var_dump($_POST);
    die();
}

$db = DB::get_instance();
$stmt = $db->prepare("SELECT id, player_name FROM players ORDER BY player_name ASC");
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
$data['player_count'] = count($players);
$data['players'] = $players;
$data['name'] = "Omer";

echo $twig->render('scores.tpl', [
    'data' => empty($data) ? '' : $data,
]);