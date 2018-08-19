<?php
header ('content-type: text/html;');
require 'phpquery.php';

$linkfile = "pr_links.txt";
$lines = file($linkfile);
$num_links = count($lines);

for ($i = 0; $i < $num_links; $i++) {
$link = str_replace("\n", NULL, $lines[$i]);
parsepage($link);
}

function parsepage($url){

	$file=file_get_contents($url);

	$site="http://tintin.ru/wp-content/uploads/2018/hunter/";


		$pr_doc = phpQuery::newDocument($file);
		$pr_doc = pq($pr_doc);
		$csvarr = array();

		$name = $pr_doc->find('.prod-name')->text();
		$art = $pr_doc->find('.prod-art')->text();
		$art = mb_substr($art, 9);

		$category = $pr_doc->find('.main-detals div:eq(2)')->text();
		$price = $pr_doc->find('.product-controlls .total-price:eq(0)')->text();
		$price = mb_substr($price, 0, -3);

		$description = $pr_doc->find('.product-description div:eq(1)')->html();

		$images = $pr_doc->find('.botom-image');
		$empty='';
		$img='';


		if ($images != ''){
			foreach ($images->find('ul li img') as $image) {
				$image = pq($image);
				$img = $img.$site.basename($image->attr('src-big')).", ";
			}
			$img = mb_substr($img, 0, -2);
			
		}
		else{
			$image = $pr_doc->find('.main-image img')->attr('src');
			$img = $site.basename($image);
		}

		array_push($csvarr, $art,$name,$category,$price,$description,$img);	
		$fp = fopen('file.csv', 'a');
		fputcsv($fp, $csvarr);

		fclose($fp);
}



?>