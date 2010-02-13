<?php
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

include_once('../config.php');

	switch($database_type) {

		case "csv":
			$row = 1;
			
			$rowcount=count(file("../reports.csv"));
			
			$handle = fopen("../reports.csv", "r");
			
			$i=1;
				
			if($rowcount==0){
				$array[0]=array('id'=>1,'title'=>'No reports yet. Make the first!'); 
			}
			
			while(($data = fgetcsv($handle, 0, "|"))!== FALSE) {
				$reports['id']=$i;
				$reports['date']=$data[0].'';
				$reports['title']=$data[1].'';
				$reports['name']=$data[2].'';
				$reports['location']=$data[3].'';
				$reports['lat']=$data[4].'';
				$reports['long']=$data[5].'';
				$reports['report']=$data[6].'';
				$reports['link']=$data[7].'';
				$reports['photo']=$data[8].'';
				$reports['embed']=$data[9].'';
				$array[$i]=$reports;
				$i++;
			}
		 
			
			$array=array_reverse($array);
			break;
		case "sqlite":
			$dbhandle = new SQLite3('../db/database.sqlite3');
			$result = $dbhandle->query('SELECT id, date, title, name, location, lat, long, report, link, photo, embed FROM reports');
			while ($data = $result->fetchArray(SQLITE3_ASSOC)) {
				$reports['id']=$data['id'];
				$reports['date']=$data['date'].'';
				$reports['title']=$data['title'].'';
				$reports['name']=$data['name'].'';
				$reports['location']=$data['location'].'';
				$reports['lat']=$data['lat'].'';
				$reports['long']=$data['long'].'';
				$reports['report']=$data['report'].'';
				$reports['link']=$data['link'].'';
				$reports['photo']=$data['photo'].'';
				$reports['embed']=$data['embed'].'';
				$array[]=$reports;
			}
			$array = array_reverse($array);
			break;

	}


header("Content-type: text/xml");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "\n";
echo '<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">';
echo "\n";
echo '	<channel>';
echo "\n";
echo "		<title>$page_title</title>";
echo "\n";
echo "		<link>$main_url</link>";
echo "\n";
echo '		<atom:link type="application/rss+xml" href="';echo $main_url; echo '/rss/" rel="self"/>';
echo "\n";
echo "		<description>$page_description</description>";
echo "\n";
echo '		<language>en-us</language>';
echo "\n";
foreach($array as $item) {
	echo '		<item>';
	echo "\n";
	echo "			<title><![CDATA[{$item['title']}]]></title>";
	echo "\n";
	echo "			<description><![CDATA[\"{$item['report']}\" - reported by {$item['name']}]]></description>";
	echo "\n";
	echo "			<pubDate>" . date(DATE_RFC2822, strtotime($item['date'])) . "</pubDate>";
	echo "\n";
	echo "			<guid isPermaLink=\"false\">" . md5( $main_url . $item['id']) . "</guid>";
	echo "\n";
	if(empty($item['link'])) {
		echo "			<link>{$main_url}</link>";
	} else {
		echo "			<link>{$item['link']}</link>";
	}
	echo "\n";
	echo "		</item>";
	echo "\n";
}
echo "	</channel>";
echo "\n";
echo '</rss>';
