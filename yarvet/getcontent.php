<?php
header ('content-type: text/html;');
require 'phpquery.php';

$site="https://yarvet.ru";
$linkfile = "pr_links.txt";
$lines = file($linkfile);
$num_links = count($lines);


for ($i = 0; $i < $num_links; $i++) {
$link = str_replace("\n", NULL, $lines[$i]);
parsepage($link);
}

function get_content ($url_content){
	$ch = curl_init($url_content);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}

function parsepage($url){

		global $site;

		$file=get_content($url);


		$pr_doc = phpQuery::newDocument($file);
		$pr_doc = pq($pr_doc);
		$csvarr = array();
		$good = new stdClass;

		$good->name = $pr_doc->find('.page-title')->text();
		$good->art = $pr_doc->find('.item__info li:eq(1)')->text();
		$good->art = mb_substr($good->art, 19);
		$good->art = trim($good->art);

		$good->category = $pr_doc->find('.item__for li:eq(1)')->text();
		$good->category = trim($good->category);

		$good->description = $pr_doc->find('#description')->text();
		$good->description = trim($good->description);
		$good->imgurl = $site.$pr_doc->find('.item__image img')->attr('src');
		$good->price = '';
		

		$empty='';
		echo $good->name."<br>";
		if(!copy($good->imgurl,'/home/andrey/www/home.ru/parse/yarvet/tinimg/'.basename($good->imgurl))){
					echo "не удалось скопировать ...\n";
			}
		else echo $good->imgurl."<br>------------------<br>";

		if ($good->name !='' && $good->art != ''){
		array_push($csvarr, $good->art,$good->name,$good->category,$good->price,$good->description,basename($good->imgurl),$url);	
		$fp = fopen('file.csv', 'a');
		fputcsv($fp, $csvarr);

		fclose($fp);
		}

		phpQuery::unloadDocuments();
}



?>