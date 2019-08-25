<?php
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('/');
$twig = new \Twig\Environment($loader, [
    'cache' => '/temp/cache',
]);

$data['name'] = "Omer";

echo $twig->render('scores.tpl', [
    'data' => empty($data) ? '' : $data,
]);