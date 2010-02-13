<?
/*
 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 * http://www.crowsne.st/license
 */

include('../config.php');

header("Content-type: text/xml");

$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.7'));  
curl_setopt ($curl, CURLOPT_URL,$news_feed_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($curl);
curl_close ($curl);

print($result);

?>