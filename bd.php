<?php
$host = 'localhost';
$user = 'root';
$pass = '1111';
$db_name = 'mysite';
$link = mysqli_connect($host, $user, $pass, $db_name);

if (!$link) {
    echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
}
function getMainCategory($link)
{
    $test = $_GET['category_id'];
    $sql = 'select c.name as category_name,
c.description as category_description
from categories c
where c.id ='.$test;
    $res = mysqli_query($link, $sql);
    $cat = mysqli_fetch_all($res,
        MYSQLI_ASSOC);
    return $cat;
}
$cat = getMainCategory($link);