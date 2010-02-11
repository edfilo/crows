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



include('../config.php');

?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


	<title><?=$page_title;?></title>

	<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <meta name="description" content="<?=$page_description;?>">
	<meta name="keywords" content="<?=$page_keywords;?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link rel="stylesheet" type="text/css" href="../mobile/mobile.css">
 
	
</head>


<body>


	<div id="header"  style="background-color:<?=$trim_background_color;?>;color:<?=$trim_font_color;?>">
		<div id="logo"><a href="../mobile"><img src="../<?=$logo_url;?>"></a></div>
		<div><?=$top_left_heading;?></div>
	</div>

<?

$password=$_POST['password'];
if($private_reporting_password==$password){
	
	include('../mobile/mobile_report_form.html');
		
}else{
	
	if($password)echo('password incorrect');
?>	
<br><br>
	<form method="POST">
     Enter Password 
	<input name="password">
	<input type="submit" value="submit">
	</form>
<br><br>
	
<?	
}

?>


<div style="clear:both;background-color:<?=$trim_background_color;?>;color:<?=$trim_font_color;?>;" id="footer">	

	<br>contact <a style="color:<?=$trim_font_color;?>;text-decoration:underline;" href="<?=$contact_email;?>"><?=$contact_email;?></a>
	
 	<br><br>powered by <a style="color:<?=$trim_font_color;?>;text-decoration:underline;" href="crowsne.st">Crows</a>
 	
 	<br><br><a style="color:<?=$trim_font_color;?>;text-decoration:underline;" href="../?nomobile=true">Standard Site</a>
    <br><br>
</div> 

</body>

</html>
