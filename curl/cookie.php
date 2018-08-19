<?php

$cookiefile = 'cookie.txt';
$url = 'http://valta.ru/catalog/';

$res = get_content($url);
print_r ($res);

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