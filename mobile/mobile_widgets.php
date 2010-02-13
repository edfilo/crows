<?

//form youtube query

if($youtube_user){
$youtube_query_call='http://gdata.youtube.com/feeds/api/users/'.$youtube_user.'/uploads?orderby=published&start-index=1&max-results=50&v=2';
}

if($youtube_keywords){
$youtube_query_call='http://gdata.youtube.com/feeds/api/videos?q='.urlencode($youtube_keywords).'&orderby=rating&start-index=1&max-results=50&v=2';
}

if($youtube_playlist_id){
$youtube_query_call='http://gdata.youtube.com/feeds/api/playlists/'.$youtube_playlist_id.'?start-index=1&max-results=50&v=2';
}

//$youtube_query_call=$youtube_query_call.'


function youtubePlaylist($query){
	
$query=$query.'&alt=rss';

$curl = curl_init();

  
curl_setopt ($curl, CURLOPT_URL,$query);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($curl);
curl_close ($curl);

//echo($query)

$xml = new SimpleXMLElement($result);


	
	foreach($xml->channel->item as $episode){

		echo('<a href="'.$episode->link.'"><div class="mobile_row">'.$episode->title.'<div class="more">&gt;</div></div></a>');
    //print_r($episode);
	}
	
//print($result);






}





function report($story_id){ 

      $handle = fopen("../reports.csv", "r");
		while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
	
				$reports[]=$data;
			    $reports=array_reverse($reports);
			    
			    
				
		}
	    $id=0;
    	foreach($reports as $report){
		//name location lat long description date title link photo video
		        $id++;
		        $date = $report[0];
		        $title = $report[1];
				$name = $report[2];
				$location = $report[3];
				$lat = $report[4];
				$long = $report[5];
				$description = $report[6];
				$link = $report[7];
				$photo = $report[8];
				$video = $report[9];

    	if($story_id==$id){
					
					?>
					<div id="mobile_text">
					<h1><?=stripslashes($title);?></h1>
					<?if($name){echo('by '.stripslashes($name));}?><br>
					<?=stripslashes($date);?><br>
					<?if($location){echo(stripslashes($location));}?><br><br>
					<?=stripslashes($description);?><br>

					<?if($link){?>
					     <a href="<?=stripslashes($link);?>"><?=stripslashes($link);?></a>
					<?}?>
					
					<?if($photo){?>
					     <img src="<?=stripslashes($photo);?>">
					<?}?>
					
					<?if($video){?>
					    <?=stripslashes($video);?>
					<?}?>
					</div>
					<?
					
				}
    
    	}
    	
}
?>
    
<?function map($latitude,$longitude,$zoom,$default_map_type){
	global $map_key;
	
	if(!$map_key){
		echo('You do not have a google maps api key set in config.php, go get one <a href="http://code.google.com/apis/maps/signup.html" target="_blank">here</a>');
		return;
	}
	
	//echo('xxx'.$zoom.$latitude.$longitude.$zoom.$default_map_type);
	include('mobile_map.html');
	
	
	
}
?>   


<?function reportform(){
	global $recaptcha_public_key;
	global $enable_public_reporting;
	global $recaptcha;
	
	?>

   

  <?if(!$enable_public_reporting){
  	   return;
  }?>
 
 <?include('mobile_report_form.html');?>

     
 
 
<?}?>  


  
  <?

 function reports(){
		
 		$rowcount=count(file("../reports.csv"));
 		if($rowcount==0){
 			echo('no reports yet.');
 		}
 	
 	
		$handle = fopen("../reports.csv", "r");
		while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
	
				$reports[]=$data;
			    $reports=array_reverse($reports);
			    
			    
				
		} 	
 	    $id=0;
		foreach($reports as $report){
		//name location lat long description date title link photo video
		     	$id++;
		        $date = $report[0];
		        $title = $report[1];
				$name = $report[2];
				$location = $report[3];
				$lat = $report[4];
				$long = $report[5];
				$description = $report[6];
				$link = $report[7];
				$photo = $report[8];
				$video = $report[9];
				
				
			
				
				
				?>
				
				<div class="mobile_row"><a href="index.php?view=report&story_id=<?=$id;?>"><?=stripslashes($title);?><div class="more">&gt;</div></a></div>
				
				<?
			
		}
		
 }		
		


function podcast_playlist($feed){

    $user_agent= $_SERVER['HTTP_USER_AGENT'];
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.7'));  
	curl_setopt ($curl, CURLOPT_URL,$feed);
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec ($curl);
	curl_close ($curl);
	$xml = new SimpleXMLElement($result);
	
	foreach($xml->channel->item as $episode){

	   $namespaces = $episode->getNameSpaces(true);

		echo('<a href="'.$episode->link.'"><div class="mobile_row">'.$episode->title.'<div class="more">&gt;</div></div></a>');
	   
	}
	
}

  

function enlargedFlickr($flickr_user,$flickr_id,$flickr_enlarge_url){


	global $flickr_api_key;
	
	if(!$flickr_api_key){
		echo('You dont have a flickr api key set in the config.php,  go get one <a href="http://www.flickr.com/services/apps/create/apply/" target="_blank">here</a>');
		return;
	}
	
	$rsp = file_get_contents('http://api.flickr.com/services/rest/?method=flickr.people.getInfo&api_key='.$flickr_api_key.'&format=php_serial&user_id='.urlencode($flickr_user));
	$person=(unserialize($rsp));
	
	//echo('<pre>'.var_dump($person['person']).'</pre>');
	echo($person['person']['realname']['_content']);
	echo('<br>'.$person['person']['location']['_content']);
	
	?>
	
	<br><a href="http://flickr.com/<?=$flickr_user;?>/<?=$flickr_id;?>">
	  
	<div class="mobile_row">photographer's flickr page <div class="more">&gt;</div></div>
   <br style="clear:both;">
	<img src="<?=urldecode($flickr_enlarge_url);?>">
	</a>
	
	<?
}
  
function flickr(){

global $flickr_api_key;
global $flickr_api_url;
	//$url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
if(!$flickr_api_key){
		echo('You dont have a flickr api key set in the config.php,  go get one <a href="http://www.flickr.com/services/apps/create/apply/" target="_blank">here</a>');
		return;
	}
	
	
$rsp = file_get_contents($flickr_api_url.'&format=php_serial');

$rsp_obj = unserialize($rsp);



foreach($rsp_obj['photos']['photo'] as $photo){
	
	$url_small='http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_s.jpg';
    $url_medium='http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'.jpg';	
	?>

   

   <a href="?view=enlarged_flickr&flickr_id=<?=urlencode($photo['id']);?>&flickr_user=<?=urlencode($photo['owner']);?>&flickr_enlarge_url=<?=urlencode($url_medium);?>"><div class="flickr_thumb" id="flickr_<?=$photo['id'];?>"><img class="link" src="<?=$url_small;?>"></div></a>
	
<?}

//onclick="Crows.enlargePhoto(\'http://farm{farm}.static.flickr.com/{server}/{id}_{secret}.jpg\',\'{[values.title.replace(/\'/g,"")]}\',\'{owner}\',\'{id}\');"
	
}



function twitter($searchterm){
	

$twitterquery='http://search.twitter.com/search.atom?q='.urlencode($searchterm).'&rpp=100&page='.$page;
//echo($twitterquery);
//call twitter 
$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.7'));  
curl_setopt ($curl, CURLOPT_URL,$twitterquery);
//curl_setopt($ch, CURLOPT_USERAGENT, 'G20 Coverage for pgh indy media center');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($curl);
curl_close ($curl);
//print($result);
$xml = new SimpleXMLElement($result);

	foreach($xml->entry as $tweet){?>

    	<div class="mobile_row tweet"><a href="<?=$tweet->author->uri;?>"><?=$tweet->author->name;?></a><?=$tweet->content;?></div>
   
 
		
	<?}
	
	
//echo($result);
/*
if (substr($result,0,1)!= '{'){
	$cache=false;
	
	if(file_exists($cachefile)){
		
		include($cachefile);
		exit();
	}else{
	

		exit('{"results":[{"text":"Twitter API fail","to_user_id":null,"from_user":"misdme","id":3602887548,"from_user_id":16660851,"iso_language_code":"en","source":"failwhale!!!","profile_image_url":"","created_at":"Fri, 28 Aug 2009 14:58:25 +0000"}]}');

	}
}
	*/
	
	
	
}







?>
	   