<?php
header ('content-type: text/html;');
require 'phpquery.php';

$linkfile = "pr_links.txt";
$lines = file($linkfile);
$num_links = count($lines);

for ($i = 0; $i < 2; $i++) {
$link = str_replace("\n", NULL, $lines[$i]);
parse_image($link);
}

function get_content ($url_content){
	$ch = curl_init($url_content);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}

function parse_image($url){

	$file=get_content($url);

	$site="https://yarvet.ru";


		$pr_doc = phpQuery::newDocument($file);
		$pr_doc = pq($pr_doc);

		$imgurl = $site.$pr_doc->find('.item__image img')->attr('src');
		if(!copy($imgurl,'/home/andrey/www/home.ru/parse/yarvet/tinimg/'.basename($imgurl))){
					echo "не удалось скопировать ...\n";
			}
		else echo $imgurl."<br>";
}



?>