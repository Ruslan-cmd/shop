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
function getCategories($link) {
    $sql = "SELECT * FROM `categories_meta`  where `products_count`>0 order by `products_count` DESC  ";
    $res = mysqli_query($link, $sql);
    $cat = mysqli_fetch_all($res,
        MYSQLI_ASSOC);
    return $cat;
}
$cat = getCategories($link);
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_list_categories.css">
    <script type='text/javascript' src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Форма регистрации</title>
</head>
<body>
<header class="main-header">
    <nav class="navigation-menu">
        <?php
        foreach ($cat as $item){
        ?>

             <a href="specific_category.php?category_id=<?=$item['id']?>"><?php echo $item['name'].' '.$item['products_count']?></a>


           <!-- <form action="category<?php echo $item['id']?>.php" method="post">
                <input type="hidden" name="category_id" value="<?php echo $item['id']?>">
                <input class="input" type="submit" name="name" value="<?php echo $item['name'].' '.$item['products_count']?>"/>
            </form> -->

        <?php } ?>


    </nav>
</header>
</body>