<?php
header ('content-type: text/html;');
require 'phpquery.php';

$url = 'https://yarvet.ru/catalog/korma_1/filter/pro-is-4c6e279b-ec74-11e7-810a-00155d3c0500/apply/';

parse_content($url);


function get_content ($url_content){
	$ch = curl_init($url_content);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}

function parse_content ($url){

		$file=get_content($url);

		$site="https://yarvet.ru";

		$doc = phpQuery::newDocument($file);

		$f_links = 'pr_links.txt';
		$handle = fopen($f_links, 'a') or die('Cannot open file:  '.$f_links);


		foreach ($doc->find('.js-product-item .item-name a') as $product) {
			$product = pq($product);
			$pr_url = $site.$product->attr('href');

			echo $product;

			fwrite($handle, $pr_url."\n");

			echo "<br>";
		}

		$next = $doc->find(".pagination .active")->next();
		$next = pq($next);
		$next = $next->find("a")->attr('href');
		echo $next."<br>-------------------<br>";
		if(!empty($next)){
			$next = $site.$next;
			parse_content($next);
		}
}




?>