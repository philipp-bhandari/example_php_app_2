<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <title><?= $page ?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/style.css">
    <script src="static/js/script.js"></script>
</head>
<body>

<div class="container-fluid">
<?php

# Описание навигационной панели
$nav_main = <<<NAV1
<li class="nav-item"><a class="nav-link active" href="%s">Список адресов</a></li>
<li class="nav-item"><a class="nav-link" href="%s">Управление</a></li>
NAV1;

$nav_user = <<<NAV2
<li class="nav-item"><a class="nav-link" href="%s">Добавить массово</a></li>
<li class="nav-item"><a class="nav-link" href="%s">Выход</a></li>
NAV2;

$nav_main = sprintf($nav_main, MAIN, MANAGE);
$nav_user = sprintf($nav_user, MASS, LOGOUT);

echo '<ul class="nav">' . $nav_main;
if($user_data) { echo $nav_user; }
echo'</ul>';

# Вывод системных сообщений
if($user_data) { echo 'Вы залогинены: <strong>' . $user_data['login'] . '</strong>'; }
if($message) { echo $message; }

# Отображение страниц
if ($url == MAIN){
    echo '<h2>Список IP-адресов</h2>';
    if($user_data) {
        echo '<button data-action="add_ip" type="button" class="btn btn-dark">Добавить в список</button>';
    }
    echo '<table class="table table-hover"><thead class="thead-dark">';
    echo '<tr><th scope="col">IP</th><th scope="col">Port</th>';

    if($user_data) { echo '<th scope="col">Manage</th>'; }

    echo '</tr></thead>';

    foreach ($ip_list as $ip) {
        echo "<tr><td>$ip[0]</td>";
        echo "<td>$ip[1]</td>";

        if($user_data) {
            echo "<td><a data-action='edit' class='manage_buttons' data-id='$ip[2]' href='edit?id=$ip[2]'><img style='max-width: 15px' src='static/img/edit.jpg'></a>";
            echo "<a data-action='delete' class='manage_buttons' data-id='$ip[2]' href='delete?id=$ip[2]'><img style='max-width: 20px' src='static/img/delete.png'></a></td>";
        }
        echo "</tr>";
    }
    echo '</table>';

} elseif($url == MANAGE && !$user_data) {
    $form = <<<FORM
    <h2>Предоставьте данные</h2>
        <div class="card-body" style="max-width: 400px">
            <form method="POST">
            
                <div class="input-group form-group">
                    <label>Логин: <input name="login" type="text" class="form-control" placeholder="username"></label>
                </div>
                <div class="input-group form-group">
                    <label>Пароль: <input name="pass" type="password" class="form-control" placeholder="password"></label>
                </div>
                <button type="submit" class="btn btn-dark">Войти</button>
                </form>
        </div>
FORM;
    echo $form;

} elseif($url == MANAGE && $user_data) {
    $role = $roles[$user_data['role']];
    $self_id = $user_data['id'];
    echo "<h3>Роль: $role</h3>";

    if($user_data['role'] == '1') {
        $users_list = get_users_list($self_id);

        if($users_list) {
            echo '<h2>Список пользователей:</h2>';
            echo '<button data-action="add_user" type="button" class="btn btn-dark">Добавить в список</button>';
            echo "<table class='table table-hover'><thead class='thead-dark'>";
            echo "<tr><th scope='col'>Логин</th>";
            echo "<th scope='col'>ID</th><th scope='col'>Роль</th>";
            echo "<th scope='col'>Manage</th></tr>";

            foreach ($users_list as $user) {
                $login = $user['login'];
                $id = $user['id'];
                $user_role = $roles[$user['role']];

                echo "<tr><td>$login</td>";
                echo "<td>$id</td>";
                echo "<td>$user_role</td>";
                echo "<td><p><a data-id='$id' data-action='use_login' href='change_user?id=$id'>Войти</a></p>";
                echo "<p><a data-id='$id' data-action='delete_user' href='delete_user?id=$id'>Удалить</a></p></td></tr>";
            }

            echo "</table>";
        }
    }
} elseif($url == LOGOUT) {
    $login = MANAGE;
    echo 'Для входа в систему перейдите по ссылке: ';
    echo "<a href='$login'>Вход</a>";

} elseif($url == MASS) {
    $input = <<<INP
    <form enctype="multipart/form-data" method="post">
        <p class="file_input"><input type="file" name="csv_file" accept=".csv">
        <input type="submit" value="Отправить"></p>
    </form>
INP;
    echo '<h2>Массовая загрузка - файл csv</h2>';
    if($user_data) {
        echo $input;
    } else {
        echo '<p class="errors">Недостаточно прав для выполнения действия</p>';
    }
}
?>
</div>
</body>
</html>