<?

/*
 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 * http://www.crowsne.st/license
 */

include_once('../config.php');


header("Content-type: text/json");


$searchterm=$_POST['searchterm'];
$page=$_POST['page'];


$cachefile='cache/'.$searchterm.$page;

if($twitter_cache_on){
	  $reqfilename=$searchterm.$page;

	 
      $cachefile = "../cache/".$reqfilename;
      $cachetime = $twitter_cache_minutes * 60; 


      // Serve from the cache if it is younger than $cachetime

      if (file_exists($cachefile) && (time() - $cachetime
         < filemtime($cachefile))) 
      {

         include($cachefile);



         exit;
  
      }

      ob_start(); // start the output buffer
}


$twitterquery='http://search.twitter.com/search.json?q='.urlencode($searchterm).'&rpp=100&page='.$page;

//call twitter 
$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.7'));  
curl_setopt ($curl, CURLOPT_URL,$twitterquery);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($curl);
curl_close ($curl);


if (substr($result,0,1)!= '{'){
	$cache=false;
	
	if(file_exists($cachefile)){
		
		include($cachefile);
		exit();
	}else{
	

		exit('{"results":[{"text":"Twitter API fail","to_user_id":null,"from_user":"misdme","id":3602887548,"from_user_id":16660851,"iso_language_code":"en","source":"failwhale!!!","profile_image_url":"","created_at":"Fri, 28 Aug 2009 14:58:25 +0000"}]}');

	}
}

print($result);

//write to cache
if($twitter_cache_on){
       // open the cache file for writing
       $fp = fopen($cachefile, 'w'); 


       // save the contents of output buffer to the file
	    fwrite($fp, ob_get_contents());

		// close the file

        fclose($fp); 

		// Send the output to the browser
        ob_end_flush(); 
}
?>
					