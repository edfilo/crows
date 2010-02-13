<?
/*
 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 * http://www.crowsne.st/license
 */

include_once('../config.php');

include_once('mobile_widgets.php');



 
$story_id= preg_match('/^[0-9]/i',$_GET['story_id'])? $_GET['story_id']:null;
$view = preg_match('/^[a-z0-9]/i',$_GET['view']) ? $_GET['view'] :null;
$hashtag = preg_match('/^[a-z0-9#@]/i',$_GET['hashtag']) ? $_GET['hashtag'] : null;
$flickr_user = preg_match('/^[a-z0-9#@]/i',$_GET['flickr_user']) ? $_GET['flickr_user'] : null;
$flickr_id=preg_match('/^[a-z0-9#@]/i',$_GET['flickr_id']) ? $_GET['flickr_id'] :null;
$flickr_enlarge_url=$_GET['flickr_enlarge_url'];

  
?>

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


	<title><?=$page_title;?></title>

	<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <meta name="description" content="<?=$page_description;?>">
	<meta name="keywords" content="<?=$page_keywords;?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link rel="stylesheet" type="text/css" href="mobile.css">

	
</head>

<body class="<?=$view;?>">
	
	<div id="header"  style="background-color:<?=$trim_background_color;?>;color:<?=$trim_font_color;?>">
		<div id="logo"><a href="../mobile"><?=($logo_url)?'<img src="../'.$logo_url.'">':'HOME'?></a></div>
		<div><?=$top_left_heading;?></div>
	</div>
	
       <!--
		
		<?=$top_center_heading;?>
		<br>
	    <?=$top_center_html;?>
	    <br>
		<?=$top_right_heading;?>
		<br>
		 <?=$top_right_html;?>
		<br style="clear:both;">
	-->
	
    <?
    
    //no view variable passed in render main mobile menu
    if(!$view){
    	
    	?>
    		
    		<?=($enable_public_reporting)?'<a href="?view=reportform"><div class="mobile_row"><div class="mobile_heading">Report</div><div class="more">&gt;</div></div></a>':''?>
    			
    		<?
    	
    	foreach($widgets as $widget){
    		    
    		    
    		    $mobile_heading=($widget['heading'])?$widget['heading']:str_replace('_',' ',$widget['type']);
    		
    		    switch($widget['type']){
    		    	case 'twitter':
	    		    	foreach($hashtags as $hashtag){?>
	    					 <a href="?view=twitter&hashtag=<?=urlencode($hashtag);?>"><div class="mobile_row"><div class="mobile_heading"><?=$hashtag;?> <?=$mobile_heading;?></div><div class="more">&gt;</div></div></a>
	    				<?}
	    		    	break;
    		    	case 'player':
    		    		break;
    		    	
    		    	default:
    		    	?>
    		
    			<a href="?view=<?=$widget['type'];?>"><div class="mobile_row"><div class="mobile_heading"><?=$mobile_heading;?></div><div class="more">&gt;</div></div></a>
    		<?
    		    	
    		    	
    		    }

    		
    			
    	}
    	
    	
    }
   
    
    

    	
    	switch($view){
    		case 'report':
    			report($story_id);
    			break;
    		case 'reports':
    			echo('<h2>'.$widget['heading'].'</h2>');
    			reports();
    			break;
    			
    		case 'podcast_playlist':
    			echo('<h2>'.$widget['heading'].'</h2>');
    			podcast_playlist($podcast_feed_url);
    			break;
    			
    			
    		case 'youtube_playlist':
    			echo('<h2>'.$widget['heading'].'</h2>');
    			if($youtube_tags){$type='tags';$value=$youtube_tags;}
    			if($youtube_playlist_id){$type='playlist';$value=$youtube_playlist_id;}
    			if($youtube_user){$type='user';$value=$youtube_user;}
    			youtubePlaylist($youtube_query_call);
    			break;
    			
    		case 'flickr':
    			flickr();
    			break;
    			
    		case 'enlarged_flickr':
    			enlargedFlickr($flickr_user,$flickr_id,$flickr_enlarge_url);
    			break;
    			
    		case 'map':
    			
    			map($latitude,$longitude,$zoom,$default_map_type);
    			
    			break;
    		
    		case 'twitter':
    			
    			twitter($hashtag);
    			
    			break;
    		case 'reportform':
    			
    			reportform();
    			
    			break;
    		
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
