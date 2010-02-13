<?
/*


 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 */

/*
This file is part of Crows.

Crows is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Crows is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Crows.  If not, see <http://www.gnu.org/licenses/>.
 */


/**********************
* LAYOUT
* -to remove a widget: comment out the appropriate line with "//"
* -to reorder widgets on the page: change the order of the widgets code
* -to align widgets: adjust height and width values, 
*    for a standard 2 column layout recommended widget widths are 
*    485 (single column widget) or 1000 (widgets span both columns)
*/
    

$widgets[]=array( 'type' => 'map', 'width' => 1000, 'height' => 500, 'heading' => 'Map');
         
$widgets[]=array( 'type' => 'reports', 'width' => 1000, 'height' => 370, 'heading' => 'Public Reports');

//$widgets[]=array( 'type' => 'player', 'width' => 480, 'height' => 270, 'heading' =>'');
        
$widgets[]=array( 'type' => 'youtube_playlist', 'width' => 485, 'height' => 400, 'heading' => 'YouTube');

$widgets[]=array( 'type' => 'podcast_playlist', 'width' => 485, 'height' => 400, 'heading' => 'Podcast');

$widgets[]=array( 'type' => 'twitter', 'width' => 1000, 'height' => 400, 'heading' => 'Tweets');
            
$widgets[]=array( 'type' => 'flickr', 'width' => 1000, 'height' => 500, 'heading' => 'Flickr');

  



/***************
*reporting page
*/

$enable_public_reporting=true;

//setting a private reporting password will let you access reporting at: yourcrowdomain.com/private
$private_reporting_password='crow';

$recaptcha=false;
//sign up for custom recaptcha keys by visiting http://recaptcha.net/api/getkey
$recaptcha_private_key='';
$recaptcha_public_key = ''; // you get this from the signup page

//editorial message or guidlines to reporters shown in report form
$report_form_message='* Please do not paste text copied from other websites,  use the link field to link to that page.  Also place text from word documents into a blank notepad first and recopy to remove ugly formatting.';
$report_widget_text = 'Add to map/Reports.';

//database type, you probably want sqlite unless you don't have it installed
//
//valid options: "sqlite", "csv"
$database_type = "sqlite";

//main url, used for the link in the rss feed
$main_url = "http://crowsne.st/";

  

/***************
* site info
*/

$page_title = 'Welcome to Crows';
$page_description = 'CrowdSourced Syndication';
$contact_email='contact@crowsne.st';





//***************
//site appearance
//***************
//site colors and images  (place your logo in images folder)
$logo_url='images/white_crow.jpg';
$trim_background_color='black';
$trim_font_color='white';
$background_image_url='';
$background_color='white';


//left heading
$top_left_width=400;
$top_left_heading='Crow Demo';
$top_left_html='CrowdSourced Syndication 1.0';


//center heading
$top_center_width=350;
$top_center_heading='Top Middle Heading';
$top_center_html='top middle text';

//right heading
$top_right_width=200;
$top_right_heading='Top Right Heading';
$top_right_html='top right text';






/****************
* youtube widget
*/

// choose one of the 3 youtube modes
// 'playlist' shows videos from a specific users video playlist (youtube playlists can contain anyones video)
// 'keywords' search youtube by keywords
// 'user'  show all of a users uploaded videos 

$youtube_mode='playlist';

$youtube_user='CrowsCrowdSource';
$youtube_keywords='crows';
$youtube_playlist_id='9AE68C8042D171F0';

//video order - possible values for orderby are 'relevance', 'published', 'viewCount' and 'rating'
$youtube_orderby='rating';




/****************
* podcast widget
*/

//a pocast rss feed,  podcast feeds are available from podcast hosts such as libsyn.com

$podcast_feed_url='http://crows.pghimc.libsynpro.com/rss';
 



//***************
//google maps widget
//***************
 
//map api key
//sign up for a map key at http://code.google.com/apis/maps/signup.html
$map_key='';


//default map type,  possible values are G_NORMAL_MAP G_SATELLITE_MAP G_HYBRID_MAP G_PHYSICAL_MAP G_SATELLITE_3D_MAP
$default_map_type='G_SATELLITE_MAP';

//map center point

$latitude=40.45675;
$longitude=-79.96649;

//map zoom level 
$zoom=13;




/***************
*twitter widget
*/

//twitter tags, keywords,  or accounts  to follow

$hashtags=array(
'#crows',
'crows',
'@crowsource'

);

//master twitter account for the follow link
$twitter_account='crowsource';

//raising the cache minutes to reduce straing on twitter api (recommended 10 minutes)
$twitter_cache_on=true;
$twitter_cache_minutes=10;





/***************
* flickr widget
*/


//get your flickr api key at http://www.flickr.com/services/apps/create/apply/
$flickr_api_key='';

$flickr_photos_per_page=60;

//   flickr mode  possible values are: 
//- 'tagsearch' (searches for photos to show by tag)
//- 'photoset'  (show an individual photoset belonging to a user)
//- 'favorites' (shows a list photos favorited by an individual user)

$flickr_mode='tagsearch';

//method by which to sort photos,  possible  values are date-posted-asc, date-posted-desc, date-taken-asc, date-taken-desc, interestingness-desc, interestingness-asc, and relevance.
$flickr_sortby='interestingness-desc';

//flickr tag - separate multiple tags with commas
$flickr_tags='crows';
$flickr_tag_mode='all'; //set this to 'any' to return matches for any tag, set to 'all' to return photos which match all tags

//photoset id - set this if your using photoset mode get this from the end of the url of your photosets flickr page
$flickr_photoset_id='';

//user id  - set this if your using favorites mode,  get your flickr id here http://idgettr.com/ 
$flickr_favorites_user_id='';






/*********************
* advanced api settings
* you dont need to change these settings unless you are familiar with apis...
*/

if($flickr_mode=='tagsearch')$flickr_api_url='http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$flickr_api_key.'&sort='.$flickr_sortby.'&tags='.urlencode($flickr_tags).'&per_page='.$flickr_photos_per_page.'&media=photos&nojsoncallback=1&tag_mode='.$flickr_tag_mode;
if($flickr_mode=='photoset')$flickr_api_url='http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key='.$flickr_api_key.'&sort='.$flickr_sortby.'&photoset_id='.$flickr_photoset_id.'&per_page='.$flickr_photos_per_page.'&media=photos&nojsoncallback=1';
if($flickr_mode=='favorites')$flickr_api_url='http://api.flickr.com/services/rest/?method=flickr.favorites.getPublicList&api_key='.$flickr_api_key.'&sort='.$flickr_sortby.'&user_id='.urlencode($flickr_favorites_user_id).'&per_page='.$flickr_photos_per_page.'&media=photos&nojsoncallback=1';


if($youtube_mode=='user')$youtube_api_url='http://gdata.youtube.com/feeds/api/users/'.$youtube_user.'/uploads?start-index=1&max-results=50&v=2';
if($youtube_mode=='keywords')$youtube_api_url='http://gdata.youtube.com/feeds/api/videos?q='.urlencode($youtube_keywords).'&start-index=1&max-results=50&v=2';
if($youtube_mode=='playlist')$youtube_api_url='http://gdata.youtube.com/feeds/api/playlists/'.$youtube_playlist_id.'?start-index=1&max-results=50&v=2';



?>
