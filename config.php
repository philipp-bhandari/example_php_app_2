<?php
require 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$connect = new mysqli('localhost', 'root', '', 'ports');
$connect->query("SET NAMES 'utf8' ");

$url = parse_url($_SERVER['REQUEST_URI'])['path'];

$user_data = null;

if(isset($_COOKIE['PHPSESSID'])) {
    $token = $_COOKIE['PHPSESSID'];

    if($token) {
        $user_data = is_correct_auth($token); # return id, login, role
    }

}

$roles = [
    '1' => 'Администратор',
    '2' => 'Редактор'
];

$message = null;

define('MAIN', '/');
define('MANAGE', '/manage');
define('LOGOUT', '/logout');
define('MASS', '/mass');