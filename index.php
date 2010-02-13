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


include_once('config.php');

//mobile detection
include('mobile_device_detect.php');
if(array_key_exists('nomobile', $_GET) && !($_GET['nomobile'])) { mobile_device_detect(true,true,true,true,true,true,'mobile/index.php',false); }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-loose.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN"> 




<head>

	<title><?=$page_title;?></title>
	
	<meta name="description" content="<?=$page_description; ?>" />
	<meta name="keywords" content="<?= $page_keywords; ?>" />
	<meta HTTP-EQUIV="Content-Language" CONTENT="EN" />
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

	<script type="text/javascript" src="js/swfobject.js"></script>
	
	
	<script type="text/javascript" src="js/ext/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="js/ext/ext-all.js"></script>

	<!--cachefly links using these instead of the above 2 lines may improve performance on slower servers-->
	<!--<script type="text/javascript" src="http://extjs.cachefly.net/ext-3.0.0/adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="http://extjs.cachefly.net/ext-3.0.0/ext-all.js"></script>-->
                 
	
	<link rel="stylesheet" type="text/css" href="js/ext/resources/css/ext-all.css">
	<link rel="stylesheet" type="text/css" href="js/ext/xtheme-gray-extend.css">

    
	<?=($map_key)?'<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key='.$map_key.'" type="text/javascript"></script>':'';?>

	<?if($recaptcha && ((!$recaptcha_private_key)||(!$recaptcha_public_key)))die('You have recaptcha enabled but no keys set,  sign up for custom recaptcha keys by visiting http://recaptcha.net/api/getkey');?>
	
	
	<script type="text/javascript" src="crows.js?ed=<?=rand();?>"></script>
	<link rel="stylesheet" type="text/css"  href="crows.css">

	<script>
	
	Crows.default_tag='<?=$hashtags[0];?>';
	Crows.twitter=[<?
	$i=0;
	foreach($hashtags as $hashtag){
		if($i>0){echo(',');}
		echo("'".$hashtag."'");
	    $i++;
	}
	?>];
	Crows.twitter_account='<?=$twitter_account;?>';
	Crows.player_embed_code='<?=$embed_code;?>';
	Crows.player_feed_url='<?=$player_feed_url;?>';
	Crows.bootmode='<?=$bootmode;?>';
	Crows.maptype='<?=$map_type;?>';
	Crows.default_episode_id='<?=$default_episode_id;?>';
	Crows.latitude=<?=$latitude;?>;
	Crows.longitude=<?=$longitude;?>;
	Crows.main_url='<?=$main_url;?>';
	Crows.zoom=<?=$zoom;?>;
	
	<?=($default_map_type&&$map_key)?'Crows.default_map_type='.$default_map_type.';':'';?>
	Crows.report_form_message='<?=$report_form_message;?>';
	Crows.report_widget_text='<?=$report_widget_text;?>';
    Crows.recaptcha=<?=($recaptcha)?'true':'false';?>;
	Crows.rss_feed='<?=$podcast_feed_url;?>';
	Crows.enable_public_reporting='<?=($enable_public_reporting)?'true':'false'?>';
	<?=($map_key)?'Crows.map=true;':''?>
	<?=($flickr_api_key)?'Crows.flickr=true;':''?>
	Crows.flickr_mode='<?=$flickr_mode;?>';
	<?=($recaptcha_public_key)?'Crows.recaptcha_public_key=\''.$recaptcha_public_key.'\';':'';?>
	
	</script>

	<?=($recaptcha)?'<script type="text/javascript" src="http://api.recaptcha.net/js/recaptcha_ajax.js"></script>':'';?>

	<?if(!$enable_public_reporting){?><style type="text/css">.report_link{display:none;}</style><?}?>
	


</head>

<body  style="background-image:url(<?=$background_image_url;?>);">

<div id="header" style="background-color:<?=$trim_background_color;?>;color:<?=$trim_font_color;?>;">

	<div id="header_container">
	 
		<div id="top_left" class="left" style="width:<?=$top_left_width;?>px">
			<?=($logo_url)?'<img class="left" src="'.$logo_url.'">':'';?>
			<span class="large_text"><?=$top_left_heading;?></span>
			<br><span class="small_text"><?=$top_left_html;?></span>
		</div>
	
		<div id="top_center" class="left" style="width:<?=$top_center_width;?>px">
	     	<span class="large_text"><?=$top_center_heading;?></span> 
	     	<br><span class="small_text"><?=$top_center_html;?></span>
	     </div>
	    
		 <div id="top_right" class="left" style="width:<?=$top_right_width;?>px">
		     <span class="large_text"><?=$top_right_heading;?></span>
		     <br><span class="small_text"><?=$top_right_html;?></span>
		 </div>
		 
	</div>
		 
    <br style="clear:both;" />
    
</div><!--header div-->


<div id="container">
 
    <?//widget rendering
    
    foreach($widgets as $widget){?>
    	
    	<div id="<?=$widget['type'];?>_container" style="width:<?=$widget['width'];?>px;" class="widget_container left">
    		
	    		<div class="large_text left block"><?=$widget['heading'];?>&nbsp;</div>
	    	    <div class="right block controls" id="<?=$widget['type'];?>_controls"></div>
	    	
	    	
	    		<div class="widget clear" id="<?=$widget['type'];?>" style="width:<?=$widget['width'];?>px;height:<?=$widget['height'];?>px;">
	    		
	    		</div>
    	
    	
    	</div>
    	
    <?}?>


</div><!--container div-->

<br style="clear:both;"/><br/><br>

<div style="clear:both;background-color:<?=$trim_background_color;?>;color:<?=$trim_font_color;?>;" id="footer">	

	<br>contact <a href="mailto:<?=$contact_email;?>"><?=$contact_email;?></a>
	
 	<br>powered by <a style="color:<?=$trim_font_color;?>;" href="http://crowsne.st">Crows</a>
 	
 	<br><a href="mobile" style="color:<?=$trim_font_color;?>;"> Accessible / Mobile Site</a>

</div>

</body>

</html>
