<?php
header ('content-type: text/html;');
require 'phpquery.php';

$linkfile = "pr_links.txt";
$lines = file($linkfile);
$num_links = count($lines);

for ($i = 0; $i <= 340; $i++) {
$link = str_replace("\n", NULL, $lines[$i]);
parsepage($link);
}

function parsepage($url){

	$file=file_get_contents($url);

	$site="http://valta.ru";


		$pr_doc = phpQuery::newDocument($file);
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