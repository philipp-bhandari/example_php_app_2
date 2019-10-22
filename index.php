<?php
require 'config.php';

if($url == MAIN) {
    $page = 'Ports';
    $message = check_new_ip();
    $ip_list = get_ip_list();

} elseif($url == MANAGE) {
    $page = 'Manage';
    $message = check_new_user();

    if(isset($_POST['login']) && isset($_POST['pass'])) {
        $login = $_POST['login'];
        $pass = $_POST['pass'];

        $is_correct = check_login($login, $pass);
        if($is_correct) {
            $token = session_id();
            set_user_token($login, $token);
            $user_data = is_correct_auth($token);
        }
    }

} elseif($url == LOGOUT && session_status() == PHP_SESSION_ACTIVE) {
    $page = 'Logout';
    unset($_COOKIE['PHPSESSID']);
    setcookie('PHPSESSID', null, -1, '/');
    session_destroy();
    $user_data = 0;

} elseif($url == MASS) {
    $page = 'Mass Load';
    if(isset($_FILES['csv_file'])) {
        if ($_FILES["csv_file"]["error"] > 0) {
            $message = "<p class='errors'>Ошибка обработки файла: " . $_FILES["file"]["error"] . "</p>";
        } else {
            try{
                $res = save_csv($_FILES["csv_file"]["tmp_name"]);
                if($res) { $message = "<p class='success'>Файл успешно обработан. Данные добавлены в список</p>"; }
            } catch (Exception $e) {
                $message = '<p class="errors">Ошибка: ' . $e->getMessage() . '</p>';
            }
        }
    }
}

include 'template.php';