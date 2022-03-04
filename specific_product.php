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
function getMainProduct($link)
{
    $test = $_GET['product_id'];
    $sql = 'select p.header as product_name,
p.price as price,
p.old_price as old_price,
p.promo_price as promo_price,
p.description as description,
c.name as category_name,
       c.id as category_id
from products p
JOIN categories_products_pivot cpp
on cpp.product_id=p.id
JOIN categories c
on c.id=cpp.category_id
WHERE p.id='.$test;
    $res = mysqli_query($link, $sql);
    $cat = mysqli_fetch_all($res,
        MYSQLI_ASSOC);
    return $cat;
}
function getPhotoProduct($link){
    $test = $_GET['product_id'];
    $sql = 'select p.header,
ps.photo_url as photo_url,
ps.ALT as alt
from products p
join photos_products_pivot ppp
on ppp.product_id=p.id
JOIN photos ps
on ps.id = ppp.photo_id
WHERE p.id='.$test;
    $res = mysqli_query($link, $sql);
    $cat = mysqli_fetch_all($res,
        MYSQLI_ASSOC);
    return $cat;
}
$photoProduct = getPhotoProduct($link);
$mainProduct = getMainProduct($link);
 ?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<script type='text/javascript' src="https://code.jquery.com/jquery-3.6.0.js"></script>
<title>Форма регистрации</title>
    <script type='text/javascript'>
        $(document).ready(function(){

            $('body').on('click', '#first-photo', function(){
                $("#first-photo").clone().replaceAll($("#right-photo")).css({
                    'margin-top':'40%',
                    'width':'50%',
                    'height':'400px'
                }).attr({
                    id: "right-photo",
                });
            });
        });
    </script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('body').on('click', '.number-minus', function(){
            var a = $('.number-minus');
            var i = ($('.number-text')).val();
            var input = $('.number-text');
            if (i<=1){return false}
            else i--;
            input.val(i);
            input.change();
        });
        $('body').on('click', '.number-plus', function(){
            var a = $('.number-plus');
            var i = ($('.number-text')).val();
            var input = $('.number-text');
            i++;
            input.val(i);
            input.change();
        });
    });
</script>
<script>
$(document).ready(function() {
    $('body').on('click', '.market', function(){
        var X = ($('.number-text')).val();
        alert('В корзину добавлено: ' +X+ ' '+ 'товаров');
    });
});
</script>
</head>
<body>
<?php $test = $_GET['category_id'] ?>
<p><a class="back" href="specific_category.php?category_id=<?=$test?>"">Назад</a></p>
<main class = 'main-block'>

<aside class= 'photo-slide'>
<article class='left-photos'>
    <?php foreach ($photoProduct as $photo){ ?>
<img src="img/<?=$photo['photo_url']?>" class='first-photo' id='first-photo' alt="<?= $photo['alt']?>">
    <?php  } ?>
</article>
    <?php foreach ($photoProduct as $photo){ ?>
<img  src="img/<?=$photo['photo_url']?>" class='right-photo' id='right-photo' alt="<?= $photo['alt']?>">
    <?php break; } ?>

</aside>
<main class='main-information'>
<header class= 'clothing-name'>
    <?php foreach ($mainProduct as $product){ ?>
<h1 id='h'><?= $product['product_name'] ?></h1>
    <?php  break; } ?>
    <?php foreach ($mainProduct as $product){ ?>
<nav class='navigation-menu'>
<p><a href='specific_category.php?category_id=<?=$product['category_id']?>'><?= $product['category_name']?></a></p>
</nav>
    <?php } ?>
</header>
    <?php foreach ($mainProduct as $product){ ?>
<main class='middle-section'>
<section class='price'>
<p class='old-price'>
<?= $product['old_price'] ?>&#8381;
</p>
<p class='new-price'>
    <?= $product['price'] ?> &#8381;
</p>
<p class='promo-price'>
    <?= $product['promo_price'] ?> &#8381; <span>- с промокодом</span>
</p>
</section>
<section class='availability-block'>
<p class='availabile'>В наличии в магазине <span class='first-icon'></span> <a href='#'>Lamoda</a></p>
<br>
<p class='delivery'>Бесплатная доставка<span class='second-icon'></span></p>
</section>
<section class='counter' data-step="1" data-min="1" data-max="100">
	<a href="#" class="number-minus">-</a>
	<input disabled class="number-text" type="text" name="count" value="1">
	<a href="#" class="number-plus">+</a>
</section>
<section class='button'>
<a href='#' class="market"><b>Купить</b></a>
<a href='#' class="favorites"><b>В избранное</b></a>
</section>
<section class='description'>
<p><?= $product['description'] ?></p>
</section>
</main>
    <?php break; } ?>
<footer class='social-networks'>
<section class='text'>
<p>Поделиться:</p></section>
<section class='vk'> </section>
<section class='google'> </section>
<section class='facebook'> </section>
<section class='twitter'> </section>
<section class='dialog'>123</section>
</footer>
</main>
</main>
</body>
