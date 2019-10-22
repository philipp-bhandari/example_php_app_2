<?php
require 'config.php';

function apply_sql($sql) {
    global $connect;
    $res = $connect->query($sql);
    if ($res) {
        echo 'success';
    } else {
        echo $connect->error;
    }
}

function change_user($main_user_id, $another_user_id) {
    global $connect;
    $sql = "SELECT `token` FROM `users` WHERE `id`='$main_user_id'";
    $result = $connect->query($sql);
    $token = null;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $token = $row['token'];
        }
    }

    if($token) {
        $sql_del = "UPDATE `users` SET `token`=NULL WHERE `id`='$main_user_id';";
        $sql_add = "UPDATE `users` SET `token`='$token' WHERE `id`='$another_user_id';";
        $q_1 = $connect->query($sql_del);
        $q_2 = $connect->query($sql_add);

        if($q_1 && $q_2){
            echo 'success';
        } else {
            echo $connect->error;
        }
    } else {
        echo $connect->error;
    }
}

function change_ip_data($id, $ip, $port) {
    $sql = "UPDATE `proxys` SET `ip`='$ip', `port`='$port' WHERE `id`='$id'";
    apply_sql($sql);
}

function delete_ip($id) {
    $sql = "DELETE FROM `proxys` WHERE `id`=$id";
    apply_sql($sql);
}

function delete_user($id) {
    $sql = "DELETE FROM `users` WHERE `id`=$id";
    apply_sql($sql);
}

if(isset($_POST['ip_change']) && isset($_POST['port_change']) && isset($_POST['id'])) {
    change_ip_data($_POST['id'], $_POST['ip_change'], $_POST['port_change']);
}
if(isset($_POST['delete_ip'])) {
    delete_ip($_POST['delete_ip']);
}
if(isset($_POST['login_id'])) {
    change_user($user_data['id'], $_POST['login_id']);
}

if(isset($_POST['delete_id'])) {
    delete_user($_POST['delete_id']);
}
