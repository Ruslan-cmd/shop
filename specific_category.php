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

    if (isset($_GET['page'])){
        $page = $_GET['page']; //данный параментр я получаю, нажимая на ссылку, чтобы правильно сформировать запрос из БД
    }else $page = 1; //текущая страница
    $kol = 3;  //количество записей для вывода
    $art = ($page * $kol) - $kol; // определяю, с какой записи выводить
    $test = $_GET['category_id'];
    $sql = "select
       p.id as product_id,
p.header as product_name,
ps.photo_url as photo_url,
ps.ALT as alt,
ps.main_photo as main_photo
from categories_products_pivot cpp
join products p
ON p.id = cpp.product_id
JOIN photos_products_pivot ppp
on ppp.product_id=p.id
JOIN photos ps
on ps.id = ppp.photo_id
where ps.main_photo=1 AND cpp.category_id = " . $test . " limit " . $art . ", " . $kol;
    $res = mysqli_query($link, $sql);
    $cat = mysqli_fetch_all($res,
        MYSQLI_ASSOC);
    return $cat;
}
function getCount($link){
    $test = $_GET['category_id'];
    $sql = "SELECT products_count as product_count
FROM categories_meta  where id =".$test;
    $res = mysqli_query($link, $sql);
    $cat = mysqli_fetch_all($res,
        MYSQLI_ASSOC);
    return $cat;
}

$kol = 3;  //количество записей для вывода ( необходимо для вывода ссылок и подсчета их колличества)
//счетчик
$countTest = getCount($link);
foreach ($countTest as $test){
    $count1= $test['product_count'];
    break;
}
$count1 = strval($count1);

$headCategory = getMainCategory($link);
$productCard = getProductCard($link);
// определяю параметр категории и параметр общего колличества записей (нужно для прогрузки, как и с index.php плюс параметр счетчика)
$test = $_GET['category_id'];
$count = $_GET['count'];
$str_pag = ceil($count1 / $kol); // определяю колличество страниц для формирования ссылок

//for ($i = 1; $i <= $str_pag; $i++){
   // echo "<a href=specific_category.php?category_id=".$test."&page=".$i."&count=".$count."> Страница ".$i." </a>";
//}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style_main_category.css">
    <script type='text/javascript' src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Категория</title>
</head>
<body>
<p><a name="top"></a></p>
<p><a class="back" href="index.php">Назад</a></p>
<?php foreach ($headCategory as $item) { ?>
    <header class="main-header">
        <h1><?php echo $item['category_name'] ?></h1>
        <p><?php echo $item['category_description'] ?></p>
        <section class="pagination">
        <?php  for ($i = 1; $i <= $str_pag; $i++){?>
            <a href="specific_category.php?category_id=<?= $test?>&page=<?= $i ?>">Страница<?=$i?></a>
        <?php }?>
        </section>
    </header>
<?php } ?>
<main class="main-section">
    <?php foreach ($headCategory as $item) { ?>
    <?php foreach ($productCard as $product) { ?>
<section class="product-card">
<header class="product-card-header">
<p class="category-name"><?= $item['category_name'] ?></p>
    <p class="product-name"><a href="specific_product.php?product_id=<?=$product['product_id']?>&category_id=<?=$test?>"><?= $product['product_name'] ?></a></p>
</header>
    <article class="product-card-photo">
        <img src="img/<?= $product['photo_url'] ?>"
             width="300px" height="400px" alt="<?= $product['alt'] ?>">
    </article>
</section>
        <?php } ?>
    <?php } ?>
</main>
<footer>
    <p><a  class="top" href="#top">Вверх</a></p>
</footer>

</body>