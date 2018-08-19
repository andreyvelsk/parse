<?php
header ('content-type: text/html;');
require 'phpquery.php';

$url = 'http://valta.ru/catalog/?h=d451b7e1b0942abcc3035d7181fb5576';
$file=file_get_contents($url);

$site="http://valta.ru";

function print_arr($arr){
	echo '<pre>' . print_r($arr,true) . '</pre>';
}

$doc = phpQuery::newDocument($file);


$f_links = 'pr_links.txt';
$handle = fopen($f_links, 'a') or die('Cannot open file:  '.$f_links);
fwrite($handle, $data);


foreach ($doc->find('.barview-wrapp .barview .content .product-link .p-lnk') as $product) {
	$product = pq($product);
	$pr_url = $site.$product->attr('href');

	echo $pr_url;

	fwrite($handle, $pr_url."\n");

	echo "<br>";
}




?>