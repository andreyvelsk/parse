<?php
header ('content-type: text/html;');
require 'phpquery.php';

$url = 'http://valta.ru/catalog/?h=aac626fcfe8be2c0a9623f07c37bf869';
$file=file_get_contents($url);

/*
$pattern='#<span class="woocommerce-Price-amount amount".+?</span>#s';

preg_match($pattern, $file,$matches);
print_r($matches);
*/

$site="http://valta.ru";

function print_arr($arr){
	echo '<pre>' . print_r($arr,true) . '</pre>';
}

$doc = phpQuery::newDocument($file);



foreach ($doc->find('.barview-wrapp .barview .content .product-link .p-lnk') as $product) {
	$product = pq($product);
	$pr_url = $site.$product->attr('href');
	
	$pr_file = file_get_contents($pr_url);
	$pr_doc = phpQuery::newDocument($pr_file);
	$pr_doc = pq($pr_doc);
	$name = $pr_doc->find('.prod-name')->text();
	$art = $pr_doc->find('.prod-art')->text();
	$category = $pr_doc->find('.main-detals div:eq(2)')->text();
	$price = $pr_doc->find('.product-controlls .total-price:eq(0)')->text();
	$description = $pr_doc->find('.product-description div:eq(1)')->html();

	$images = $pr_doc->find('.botom-image');

	if ($images != ''){
		foreach ($images->find('ul li img') as $image) {
			$image = pq($image);
			echo basename($site.$image->attr('src-big'));
			echo "<br>";
		}
	}
	else{
		$image = $site.$pr_doc->find('.main-image img')->attr('src');
		echo $image;
		echo "<br>";
	}

	$csvstring = $name;

	echo $name;
	echo "<br>";
	echo $art;
	echo "<br>";
	echo $category;
	echo "<br>";
	echo $price;
	echo "<br>";
	echo $description;
	echo "<br>";
	echo "<hr>";
}




?>