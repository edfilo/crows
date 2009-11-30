<?
/*
 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 * http://www.crowsne.st/license
 */


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
