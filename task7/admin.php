<?php

 $files = [
 'authorization.php',
 'database.php',
];

function safe_require_once($file) {
global $files;
 if (in_array($file, $files)) {
  require_once($file);
 } else {
 echo "Недопустимый файл";
 }
}
safe_require_once('database.php');   
safe_require_once('authorization.php'); 


print('Вы успешно авторизовались и видите защищенные паролем данные.');

?>

    <form action="" method="POST">
            <input name="delete"/>
          <input type="submit" name = "button" value="Delete" />
            <input name="update"/>
          <input type="submit" name = "button" value="Update" />
    </form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['button'] == "Delete")
    {
        if(!empty($_POST['delete']))
    {
    $user_id = $_POST['delete'];
    $result = get_user_id($user_id);

if ($result) {
    $result = delete_by_id($user_id);
    echo "Данные успешно удалены. <br>";
    header('Location: admin.php');
    exit();
}
else {
    echo "Id не найден в базе данных. <br>";
}
    }
    else{
            echo "Заполните id <br>";
        }
    }
        if($_POST['button'] == "Update")
    {
        if(!empty($_POST['update']))
        {
        session_start();
      $user_id = $_POST['update'];
    $result = get_user_id($user_id);
    if ($result) {
    $data = get_login($user_id);
    $_SESSION['login'] = $data['login'];

    $_SESSION['uid'] = $user_id;
    header('Location: index.php');
        exit();
    }
    else {
    echo "Id не найден в базе данных. <br>";
}
    }
        else{
            echo "Заполните id <br>";
        }
    }
}
$results = get_all_user();

    foreach ($results as $row) {
        echo "Пользователь с login " . $row['login'] ." и id ". $row['id'] . "<br>";
        echo "Full name: " . $row['name'] . "<br>";
        echo "Telephone: " . $row['phone'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Date: " . $row['data'] . "<br>";
        echo "Gender: " . $row['pol'] . "<br>";
        echo "Biography: " . $row['bio'] . "<br>";
        echo "Agreement: " . $row['ok'] . "<br>";
        echo "Languages: " . $row['languages'] . "<br><br>";
    }
    echo "Статистика языков: " . "<br />";
    $query = "SELECT l.language_name, count(*) AS count_users
            FROM application a 
            INNER JOIN application_languages al ON a.id = al.application_id
            INNER JOIN programming_languages l ON al.language_id = l.id
            GROUP BY l.language_name";

 $languages = get_status_language();
    foreach ($languages as $row) {
        echo "Язык {$row['language_name']} любят {$row['count_users']} пользователя <br>";
    }
?>
