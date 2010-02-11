<?
/*
 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 */

/*
* This file is part of Crows.
*
* Crows is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Crows is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Crows.  If not, see <http://www.gnu.org/licenses/>.
*  */


$password=$_POST['password'];

include_once('config.php');

if(!$enable_public_reporting&&($password!=md5($private_reporting_password))){
	die('password incorrect');
}


if($recaptcha){
require_once('recaptchalib.php');

$resp = recaptcha_check_answer ($recaptcha_private_key,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
	
  die ('captchafail');
}
}


$report['location']=urlencode($_POST['location']);
//TODO: change headline to title
$report['title']=$_POST['headline'];
$report['name']=$_POST['name'];
$report['text']=$_POST['text'];
   
$report['link']=$_POST['link'];
$report['image']=$image=$_POST['image'];
$report['embed']=$_POST['embed'];
   
  
foreach($report as $key=>$value){
	$report[$key] =str_replace('|','',$value);
	$report[$key] = ereg_replace("\n|\r|\r\n|\n\r", "<br>", $value);

}
  

    
if($report['location']!=''){
$url = "http://maps.google.com/maps/geo?q=".$report['location']."&output=csv&key=".$map_key;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER,0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
$data = curl_exec($ch);
curl_close($ch);


if (substr($data,0,3) == "200"){
	
	$data = explode(",",$data);
	$precision = $data[1];
	$report['latitude'] = $data[2];
	$report['longitude'] = $data[3];
	
}else{
	die('mapfail');
}

}

	
$report['date']=date('D n/j/Y g:i a');
$report['location'] = urldecode($report['location']);

  
switch($database_type) {

	case "csv":
		$line = $report['date'].'|'.$report['title'].'|'.$report['name'].'|'.$report['location'].'|'.$report['latitude'].'|'.$report['longitude'].'|'.$report['text'].'|'.$report['link'].'|'.$report['image'].'|'.$report['embed'];




		$fp = fopen('reports.csv', 'a') or die('writefail');


		fputcsv($fp, split('\|', $line),'|');

		fclose($fp);
		break;
	case "sqlite":
			$dbhandle = new SQLite3('db/database.sqlite3');
			//$dbhandle->exec("CREATE TABLE reports (id INTEGER PRIMARY KEY, date STRING, title STRING, name STRING, location STRING, lat STRING, long STRING, report STRING, link STRING, photo STRING, embed STRING");
			//die("INSERT INTO reports (date, title, name, location, lat, long, report, link, photo, embed) values ('{$report['date']}','{$report['title']}','{$report['name']}','{$report['location']}','{$report['latitude']}','{$report['longitude']}','{$report['text']}','{$report['link']}','{$report['image']}','{$report['embed']}'");
			$report = array_map("sqlite_escape_string", $report);
			$dbhandle->exec("INSERT INTO reports (date, title, name, location, lat, long, report, link, photo, embed) values ('{$report['date']}','{$report['title']}','{$report['name']}','{$report['location']}','{$report['latitude']}','{$report['longitude']}','{$report['text']}','{$report['link']}','{$report['image']}','{$report['embed']}')");

		break;
}

echo('success');

?>
