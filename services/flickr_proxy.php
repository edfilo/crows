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


include_once('../config.php');

$page=$_POST['page'];
$user_id=$_POST['user_id'];

if($user_id){
	$flickr_api_url='http://api.flickr.com/services/rest/?method=flickr.people.getInfo&api_key='.$flickr_api_key.'&format=json&user_id='.$user_id.'&nojsoncallback=1';
}


$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL,$flickr_api_url.'&format=json&page='.$page);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($curl);
curl_close ($curl);

print($result);
?>

