<?php
header ('content-type: text/html;');
require 'phpquery.php';

$url = 'http://valta.ru/catalog/?h=d451b7e1b0942abcc3035d7181fb5576';
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

	$images = $pr_doc->find('.botom-image');

	if ($images != ''){
		foreach ($images->find('ul li img') as $image) {
			$image = pq($image);
			$imgurl = $site.$image->attr('src-big');
			if(!copy($imgurl,'/home/andrey/tinimg/'.basename($imgurl))){
				echo "не удалось скопировать ...\n";
			}
		}
	}
	else{
		$imgurl = $site.$pr_doc->find('.main-image img')->attr('src');
		if(!copy($imgurl,'/home/andrey/tinimg/'.basename($imgurl))){
				echo "не удалось скопировать ...\n";
		}
	}
}




?>