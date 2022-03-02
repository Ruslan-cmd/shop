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
function getProductCard($link)
{
    $test = $_GET['category_id'];
    $sql = 'select
p.header as product_name,
ps.photo_url as photo_url,
ps.ALT as alt
from categories_products_pivot cpp
join products p
ON p.id=cpp.product_id
JOIN photos_products_pivot ppp
on ppp.product_id=p.id
JOIN photos ps
on ps.id = ppp.photo_id
where cpp.category_id ='.$test;
    $res = mysqli_query($link, $sql);
    $cat = mysqli_fetch_all($res,
        MYSQLI_ASSOC);
    return $cat;
}
$headCategory = getMainCategory($link);
$productCard = getProductCard($link);
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_main_category.css">
    <script type='text/javascript' src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Категория</title>
</head>
<body>
<?php foreach ($headCategory as $item) { ?>
    <header class="main-header">
        <h1><?php echo $item['category_name'] ?></h1>
        <p><?php echo $item['category_description'] ?></p>
    </header>
<?php } ?>
<main class="main-section">
    <?php foreach ($headCategory as $item) { ?>
    <?php foreach ($productCard as $product) { ?>
<section class="product-card">
<header class="product-card-header">
<p><?= $item['category_name'] ?></p>
    <p><?= $product['product_name'] ?></p>
</header>
    <article class="product-card-article">

    </article>
</section>
        <?php } ?>
    <?php } ?>
</main>
</body>