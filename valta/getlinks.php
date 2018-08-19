<?php
header ('content-type: text/html;');
require 'phpquery.php';

$cookiefile = 'cookie.txt';
$url = 'http://valta.ru/catalog/?h=55d9bec401cd2fb46ce912ca307ecc2f';
$file=get_content($url);

$site="http://valta.ru";



$doc = phpQuery::newDocument($file);


$f_links = 'pr_links.txt';
$handle = fopen($f_links, 'a') or die('Cannot open file:  '.$f_links);


foreach ($doc->find('.barview-wrapp .barview .content .product-link .p-lnk') as $product) {
	$product = pq($product);
	$pr_url = $site.$product->attr('href');

	echo $pr_url;

	fwrite($handle, $pr_url."\n");

	echo "<br>";
}

function get_content ($url_content){
	global $cookiefile;

	$ch = curl_init($url_content);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_HEADER, true );
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile );
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile );
	curl_setopt($ch, CURLOPT_COOKIESESSION, true );
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}




?>