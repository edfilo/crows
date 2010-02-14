/*
 * Crows - Crowd Syndication 1.0
 * Copyright 2009
 * contact@crowsne.st
 * http://www.crowsne.st/license
 */

Ext.BLANK_IMAGE_URL = 'js/ext/resources/images/default/s.gif';
Ext.namespace('Crows');



Crows.parseReport=function(index){
	
	var report=Crows.reportsStore.getById(index);
	
	var html='<div class="bold">'+report.data.title+'</div>';
	
	if(report.data.author){
		html+='<div>posted by '+report.data.author+' '+report.data.date+'</div>';
	}else{
		html+='<div>'+report.data.date+'</div>';
	}
    if(report.data.location){
    	html+='<div>'+report.data.location+'</div>';
    }
	if(report.data.embed){
		html+='</div>'+report.data.embed+'</div>';
	}
	
	if(report.data.link){
	
		html+='<div><a href="'+report.data.link+'">'+report.data.link+'</a></div>';
	}  
	  
	if(report.data.photo){
	 
		html+='<div><img src="'+report.data.photo+'"></div>';
	}
	
	if(report.data.report){
	
		html+='<div>'+report.data.report+'</div>';
	}
	return html;
	
	
}



Crows.launchReport=function(index){
	
	
	var html=Crows.parseReport(index);
	
	if(html.length>2000){var width=850;}else{var width=500;}
	var reportwin=new Ext.Window({
		//id:'contribute_modal'
		closeAction:'destroy'
		//,y:100
		//,animateTarget:'reports'
		,anchorTo:'reports'
		,id:'report_'+Math.random()
		,autoHeight:true
		//,autoWidth:true
		,width:width
		,footer:false
		,scrollable:true
		,closable:true
		,draggable:true
		,html:html
	});
	reportwin.show();
	var position=reportwin.getPosition();
	if (position[1]<50){
		reportwin.setPosition(position[0],50);
	}
	
};

 
Crows.contribute=function(text){
    if(text)text=unescape(text);
   if(Ext.getCmp('contribute_modal'))return;
	    
	var win=new Ext.Window({
		id:'contribute_modal'
		,closeAction:'destroy'
		,width:980
		,y:100
		,title:'REPORT'
		,modal:true
		,autoHeight:true
		,footer:false
		,scrollable:true
		,closable:true
		,draggable:true
		//,html:'<img src="contribute_mockup.png">'
		,items:[
	
					new Ext.form.FormPanel({
						id:'report_form'
						,header:false
						,border:false
						
						,cls:'contribute_panel'
						,labelSeparator:''
						,frame:false
				    	,autoHeight:true
				    	//,height:700
				    	,autoWidth:true
				    	,layout:'column'
				    	,labelAlign:'top'
				    	,items:[
				    	{
				    		columnWidth:.5
				    		,layout:'form'
				    		,items:[
				    		  new Ext.Panel({
				    		  	layout:'column'
				    		  	,autoHeight:true
				    		  	,items:[
				    		  	{columnWidth:.5
				    		  	,layout:'form'
				    		      ,items:[
							    	{
							    		xtype:'textfield'
							    		,fieldLabel:'Headline'
							    		,allowBlank:false
							    		,labelSeparator:''
							    		,id:'headline'
							    		,width:180
							    	}
							    	]},
							    {columnWidth:.5
							    ,layout:'form'
							    ,items:[	
							    	{
							    		xtype:'textfield'
							    		,fieldLabel:'Your Name (optional)'
							    		,allowBlank:true
							    		,labelSeparator:''
							    		,id:'name'
							    		,width:180
							    	}
							    ]}
							    ]
				    		  }),
						    	{
						    		xtype:'textfield'
						    		,fieldLabel:'Location (optional) <span class=\"small_text\">be specific for mapping ie "123 Main St. Pittsburgh, PA"</span>'
						    		,allowBlank:true
						    		,id:'location'
						    		,labelSeparator:''
						    		,width:444 
						    	},
						    	
						    	
						    	{
						    		xtype:'htmleditor' 
						    		,fieldLabel:'Report<br>'
						    		,id:'text'  
						    		,defaultValue:'&nbsp'
						    		,labelSeparator:''
						    		//,value:'fred'
						    		//,allowBlank:false
						    		,width:444
						    		,height:196
						    	}
					]
				    },{
				    	columnWidth:.5	
				    	,layout:'form'
				    	,items:[
				    	{
						    		xtype:'textfield'
						    		,fieldLabel:'Link to a news article or website (optional)'
						    		,allowBlank:true
						    		,labelSeparator:''
						    		,id:'link'
						    		,width:400
						    	},{
						    		xtype:'textfield'
						    		,fieldLabel:'Image Link (optional)'
						    		,allowBlank:true
						    		,labelSeparator:''
						    		,id:'image'
						    		,width:400
						    },{
						    		xtype:'textfield'
						    		,fieldLabel:'Video Embed Code (optional)'
						    		,allowBlank:true
						    		,labelSeparator:''
						    		,id:'embed'
						    		,width:400
						    },{
						    	html:'<div class="report_form_message">'+Crows.report_form_message+'</div>'
						    	,width:400
						    }
				    	
				    	
				    	
				    	]
				    		
				    		
				    }
					]
						    })
						    ,{
						    	
						        layout:'column'
						        ,width:550
						        ,cls:'right'
						        ,id:'submit_panel'
						    	,items:[{
						    	html:'<div class="right" id="recaptcha_div"></div>'
						    	}
						    	,{
						    		xtype:'button'
						    		,text:'submit report'
						    		,cls:'right'
						    		,id:'submit_button'
						    		,height:40
						    		,width:200
						    		,handler:function(){
						    			if(Ext.getCmp('report_form').getForm().isValid()){
						    			Ext.getCmp('contribute_modal').getEl().mask('Submitting Report...');
						    			Ext.Ajax.request({
						    				url:'report_form_handler.php'
						    				,params:{'name':Ext.getCmp('name').getValue()
						    				,'text':Ext.getCmp('text').getValue()
						    				,'location':Ext.getCmp('location').getValue()
						    				,'headline':Ext.getCmp('headline').getValue()
						    				,'link':Ext.getCmp('link').getValue()
						    				,'image':Ext.getCmp('image').getValue()
						    				,'embed':Ext.getCmp('embed').getValue()
						    				,'recaptcha_response_field':(Recaptcha)?Recaptcha.get_response():''
						    				,'recaptcha_challenge_field':(Recaptcha)?Recaptcha.get_challenge():''

						    				}
						    				,success:function(r){
						    					
						    					Ext.getCmp('contribute_modal').getEl().unmask();
						    					if(r.responseText=='mapfail'){
						    						Ext.MessageBox.alert('','We could not find this address, please double check it and retry.');
						    						Ext.getCmp('location').markInvalid('Could not find address');
						    					}
						    					if(r.responseText=='writefail'){
						    						Ext.MessageBox.alert('','Could not write to reports.csv, Please make sure file is writable.');
						    						Ext.getCmp('location').markInvalid('Could not find address');
						    					}		
						    					if(r.responseText=='captchafail'){
						    						Ext.MessageBox.alert('','Please retype the words in the box');
						    						Ext.getCmp('location').markInvalid('Could not find address');
						    					}
						    					if(r.responseText=='success'){
						    						Ext.MessageBox.alert('','Thank you,  your report has been submitted');
						    						Ext.getCmp('contribute_modal').destroy();
						    						Crows.reportsStore.load({
						    							callback:function(){
						    								var newreport=Crows.reportsStore.getById(Crows.reportsStore.getCount());
						    								Crows.showAddress(newreport.data.id,newreport.data.lat,newreport.data.long);
						    							}
						    							
						    						});
						    						
						    					}
						    					
						    					
						    				}
						    			});
						    			}
						    	}
						}
						    	
						    	]
						    }
				  		   ]
		    		});
		   
	if(text)Ext.getCmp('text').setValue(text);
	win.show();
	
	window.scrollTo(0,0);
	
	if(Crows.recaptcha&&Crows.recaptcha_public_key){
		Recaptcha.create(Crows.recaptcha_public_key,
							"recaptcha_div", {
							   theme: "blackglass",
							   callback: Recaptcha.focus_response_field
		});
	}else{
		Recaptcha=false;
	}
	
	
	
}


  

	String.prototype.parseURL = function()
	{
		
	
		
	
	
	
	return this.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/, function(url) {
		return ('<a target="_blank" href="'+url+'" style="color:#2880bc;" class="link">'+url+'</a>');
	});
	};  
	        
	String.prototype.getURL = function()
	{
		
	
	var fred=this.match(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+/);
	return fred[0];
	};












Crows.makeTweets=function(searchterm){
	
	
	Crows.tweetStore.load({
 		 params:{'searchterm':searchterm,'page':1}
  		,callback:function(){
  			

	       

	       Ext.getCmp('tweet_data').refresh();
	       
	
		}
	});
	


}



Crows.newsStore = new Ext.data.XmlStore({

    url: 'services/news_proxy.php',
    autoLoad:false,
    record: 'item', 
    fields: ['id','title','description',{name:'pubDate',type:'date'},'link'],
    listeners:{'load':function(r){
    	//debugger;
    	var i;
    	for(i=0;i<r.data.items.length;i++){
    	   r.data.items[i].data.id=i;
    	   
    	   
    	}
    }
    }
    
});
         
Crows.playPodcast=function(id,title,link){
	title=unescape(title);
	if(!Ext.get('player')){
	var win=new Ext.Window({
		title:title
		,id:'win_'+Math.floor(Math.random()*10001)
		,hideMode:'destroy'
		,autoHeight:true
		,autoWidth:true
		//,html:'<embed id="embed" scale="aspect" height="360" width="640" src="'+link+'">'
		,html:(Crows.rss_feed.match('blip'))?unescape(link):'<embed id="embed" scale="aspect" height="360" width="640" src="'+unescape(link)+'">'
	});

	
	win.show();

	return;
	}
	
	Ext.get('player_controls').update(title);
    Ext.get('player').update();
	Ext.get('player').update('<embed background="black"  id="embed" height="'+(Ext.get('player').getHeight())+'" width="'+(Ext.get('player').getWidth())+'" scale="aspect" src="'+link+'">');
	
}
 
Crows.podcastTemplate=new Ext.XTemplate(
	'<tpl for=".">'
	,'<div class="episode" id="episode_{ItemId}" >'
	,'<div class="thumbnail link" onclick="Crows.playPodcast(\'{ItemId}\',\'{[escape(values.title)]}\',\'{[escape(values.link)]}\');" style="background-image:url({thumbnail});"><img src="images/play.png"></div>'
	,'<div class="info"><span class="title">{title}</span><!--{ItemId}--><br><span class="description">{[Crows.simpleTruncate(values.description,200)]}</span> </div>'
	,'<span class="link map_it" onclick="Crows.mapIt(\'episode\',\'{ItemId}\');"><!--add to map--></span></div>'
	,'</tpl>'	
);

/*
Crows.reportsTemplate=new Ext.XTemplate(
'<tpl for=".">'
,'<div  class="report" onclick="Crows.launchReport(\'{id}\');">'
,'<span class="report_title link bold">{title}</span>&nbsp;&nbsp;'
,'<span class="crowdate">{date}</span>&nbsp;&nbsp;'
//,'{report}'
,'{[Crows.reportTruncate(values.report)]}'
,'</div>'
,'</tpl>'
);
*/
Crows.launchLink = function(link){
	window.open(link,'_blank');
}


Crows.newsTemplate=new Ext.XTemplate(
	'<tpl for=".">'
	,'<div class="newsarticle" id="news_{id}" onclick="Crows.launchLink(\'{link}\');">'
	//,'<div class="thumbnail link" onclick="Crows.playPodcast(\'{ItemId}\',\'{[escape(values.title)]}\',\'{[escape(values.link)]}\');" style="background-image:url({thumbnail});"><img src="images/play.png"></div>'
	,'<span class="link bold title">{title}</span>&nbsp;&nbsp;'
	,'<span class="crowdate">{[fm.date(values.pubDate,"l F j Y g:ia")]}</span>'
	//,'<span class="description">{[values.description]}</span> </div>'
	,'<span class="link map_it" onclick="Crows.mapIt(\'news\',\'{id}\');">{[Crows.report_widget_text]}</span>'
	,'</div>'
	,'</tpl>'	
);
  
Crows.flickrTemplate=new Ext.XTemplate(
'<tpl for=".">',
'<div class="flickr_thumb" id="flickr_{id}"><img class="link" onclick="Crows.enlargePhoto(\'http://farm{farm}.static.flickr.com/{server}/{id}_{secret}.jpg\',\'{[values.title.replace(/\'/g,"")]}\',\'{owner}\',\'{id}\');" src="http://farm{farm}.static.flickr.com/{server}/{id}_{secret}_s.jpg"></div>',
'</tpl>'
);  


String.prototype.stripHTML = function(){
        var matchTag = /<(?:.|\s)*?>/g;
        return this.replace(matchTag, "");
};


Crows.tweetTemplate=new Ext.XTemplate(
'<tpl for=".">'
,'<div class="tweet clear" id="tweet_{id}">'
,'<div class="link pic_{id}" onclick="window.open(\'http://www.twitter.com/{from_user}\',\'_blank\');" style="height:40px;width:40px;float:left;border:solid black 1px;margin:5px;background-repeat:no-repeat;background-position:50% 50%;background-image:url({profile_image_url});"></div>'
,'<span class="link" onclick="window.open(\'http://www.twitter.com/{from_user}\',\'_blank\');">{from_user}</span>&nbsp;'
,'{[values.text.parseURL()]}'
,'<span class="source crowdate">&nbsp;{[fm.date(values.created_at,"l F j Y g:ia")]}</span>&nbsp<span class="map_it link report_link" onclick="Crows.mapIt(\'tweet\',\'{id}\');">{[Crows.report_widget_text]}</span>'
,'<br style="clear:both;"></div>'
,'</tpl>'
);


Crows.simpleTruncate=function(text,value){
	
	text=text.stripHTML();
	if(text.length>value){
		return(text.substring(0,value)+'...');
	}else{
	    return(text);
	}
	
}

Crows.reportTruncate=function(text){
	text=text.stripHTML();
	if(Ext.get('reports').getWidth()>500){
	    if(text.length>110){
		return(text.substring(0,110)+'...');
	    }else{
	    	return text;
	    }
	}else{
		return;
	}
}

Crows.reportsTemplate=new Ext.XTemplate(
'<tpl for=".">'
,'<div  class="report" onclick="Crows.launchReport(\'{id}\');">'
,'<span class="report_title link bold">{title}</span>&nbsp;&nbsp;'
,'<span class="crowdate">{date}</span>&nbsp;&nbsp;'
//,'{report}'
,'{[Crows.reportTruncate(values.report)]}'
,'</div>'
,'</tpl>'
);

   

Crows.mapIt=function(type,id){
	
	var text=Ext.get(type+'_'+id).dom.innerHTML.replace(Crows.report_widget_text,'');
	if(type=='tweet')Crows.contribute(escape(text),name);
	if(type=='flickr')Crows.contribute(escape(text),name);
	if(type=='news')Crows.contribute(escape(text),name);
	

} 
 
Crows.enlargePhoto=function(url,title,owner,id){
   
	var flickr_html=' <a id="photo_credit" target="_blank" href="http://flickr.com/'+owner+'/'+id+'"></a><span class="map_it link report_link" onclick="Crows.mapIt(\'flickr\',\''+id+'\');">'+Crows.report_widget_text+'</span><br><br><div><a class="link" target="_blank" href="http://flickr.com/'+owner+'/'+id+'"><img src="'+url+'"></a></div>';

 if(!Ext.getCmp('enlarge_flickr')){
	Crows.flickrWindow=new Ext.Window({
		autoHeight:true
		,id:'enlarge_flickr'
		,closable:true
		,closeAction:'destroy'
		//,title:title
		,layout: 'anchor' 
		,draggable:true
		,resizable:true
		,autoWidth:true
		

	});
	
 }
   
 
 	Crows.flickrWindow.removeAll();
	Crows.flickrWindow.add({html:flickr_html});
	Crows.flickrWindow.doLayout()
	Crows.flickrWindow.show();
	Crows.flickrWindow.setTitle(title);
    Ext.Ajax.request({
        url:'services/flickr_proxy.php'
        ,params:{'user_id':owner.replace('@','%40')}
        ,success:function(r){
        	
        	var json=Ext.decode(r.responseText);
            if(json.person.location)var location=json.person.location._content;
        	if(json.person.realname)var realname=json.person.realname._content;
        	if(Ext.get('photo_credit')){
        		var credit_string='';
        		if(realname)credit_string+='by <span class="bold credit_link link">'+realname+'</span>';
        		if(location)credit_string+=((realname)?', ':'')+location+' ';
        		if(!realname)credit_string+='<span class="bold credit_link link">credits</span>';
        		Ext.get('photo_credit').update(credit_string);
        	}
        }
    
    });
	
	
}





Crows.tweetStore=new Ext.data.JsonStore({
		url:'services/twitter_proxy.php'
		,autoLoad:false
		,fields: ['id','text','location','from_user','profile_image_url',{name:'created_at',type:'date',dataIndex:'created_at'}]
		,root:'results'
		,id:'id'
});

Crows.reportsStore=new Ext.data.JsonStore({
		url:'services/reports_proxy.php'
		,autoLoad:false
		,fields: ['id','name','location','lat','long','report','date','title','link','video','photo']
		//,root:'results'
		,id:'id'
});

	
Crows.flickrPager=function(direction){
	
	Ext.get('flickr_controls').update();
	
	if(!Crows.flickrCount)Crows.flickrCount=1;
	
	if(direction=='more')Crows.flickrCount++;
	if(direction=='less')Crows.flickrCount--;
	if(direction=='box'){Crows.flickrCount=Ext.getCmp('paging_input').getValue();}
	Crows.flickrStore.load({
		params:{
		   page:Crows.flickrCount
		}
	});
	
}
	
Crows.playEpisode=function playEpisode(episode_id,title,length){
	title=unescape(title);
	//location.href = "#" + episode_id;
	//Ext.get('player').update(Crows.player_embed_code.replace(/root/g,'root/episode/'+episode_id+'.m4v'));
	if(title)Ext.get('episode_title').update(title);

}

Crows.recenterMap=function() {
	Crows.map.setCenter(new GLatLng(Crows.latitude,Crows.longitude),Crows.zoom);
}
	
Crows.makeMap=function(div) {
	if(!Crows.map){
		Ext.get('map').update('You do not have a google maps api key set in config.php, go get one <a href="http://code.google.com/apis/maps/signup.html" target="_blank">here</a>');
		return;
	}
	  if (GBrowserIsCompatible()) {
	   	Crows.map = new GMap2(document.getElementById(div));
	    Crows.map.setCenter(new GLatLng(Crows.latitude,Crows.longitude),Crows.zoom);
		Crows.map.addControl(new GSmallMapControl());
    	Crows.map.addControl(new GMapTypeControl());
	    	geocoder = new GClientGeocoder();

	   	Crows.map.setMapType(Crows.default_map_type); 
	   	Ext.get('map_controls').update('<span class="link" onclick="Crows.bigMap();"></span>');
	  }
}
	
	Crows.showAddress=function(id,lat,long,blink){	
	  var html=Crows.parseReport(id);

	  
	  var icon = new GIcon();
      icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
      icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
      icon.iconSize = new GSize(12, 20);
      icon.shadowSize = new GSize(22, 20);
      icon.iconAnchor = new GPoint(6, 20);
      icon.infoWindowAnchor = new GPoint(5, 1);      
      
      var blinkicon = new GIcon();
      blinkicon.image = "blinkypinb.gif";
      blinkicon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
      blinkicon.iconSize = new GSize(12, 20);
      blinkicon.shadowSize = new GSize(22, 23);
      blinkicon.iconAnchor = new GPoint(6, 20);
      blinkicon.infoWindowAnchor = new GPoint(5, 1); 

      iconblue = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_blue.png"); 
      icongreen = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_green.png"); 
      iconyellow = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_yellow.png"); 
      iconred = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_red.png"); 

      
	

		if(lat){
			var point = new GLatLng(lat,long);
		
			//var myicon = new GIcon(G_DEFAULT_ICON);
			if(blink!='blink')var myicon = new GIcon(iconred);
			
			if(blink=='blink')var myicon = new GIcon(blinkicon);
			  //myicon.image = "http://esa.ilmari.googlepages.com/markeryellow.png";
			  //myicon.iconSize = new GSize(32, 32);
			  //myicon.iconAnchor = new GPoint(15, 32); 
			
			if (point){
				var marker = new GMarker(point,{icon:myicon});
				Crows.map.addOverlay(marker);
				GEvent.addListener(marker, "click", function() {
					if(html.length>2500){var width=600;}else{var width=300;}
					if(html.length>2500){var font=10;}else{var font=12;}
					
			      marker.openInfoWindowHtml('<div style="font-size:'+font+'px;">'+html+'</div>');
			    });
			}
		}
	}
	
Crows.bigMap=function(){
	Ext.get('map').update();
	var bigmap=new Ext.Window({
		html:'<div style="width:100%;height:100%;" id="bigmap"></div>'
		,maximizable:true
		,listeners:{'show':function(){
			bigmap.maximize();
			Crows.makeMap('bigmap');	
		}}
	});
	
	bigmap.show();
	
}

//c1y_wo_4fuQ
Crows.loadYoutube=function(video,title){
	
title=unescape(title);

if(!Ext.get('player')){
	
	var win=new Ext.Window({
		autoHeight:true
		,autoWidth:true
		,title:title
		,html:'<div id="youtube_div"></div>'
	});
	
	win.show();
	
	}else{
	Ext.get('player_controls').update(title);
	Ext.get('player').update('<div id="youtube_div"></div>');
	}
	
	var params = { allowScriptAccess: "always" };
	    		var atts = { id: "youtube_swf",autoplay:'true' };
	    		swfobject.embedSWF('http://www.youtube.com/v/'+video+'?autoplay=0&enablejsapi=1&playerapiid=ytplayer', 'youtube_div', Ext.get('player')?Ext.get('player').getWidth():'640',  Ext.get('player')?Ext.get('player').getHeight():'360', "8", null, null, params, atts);
	



}


Crows.youtubeWidget=function(){
	Ext.Ajax.request({
		url:'services/youtube_proxy.php'
		,success:function(r){
			
			var json=Ext.decode(r.responseText);
			var default_video_id=json.feed.entry[0].media$group.yt$videoid.$t;
			
			var list='';
			
		    for(i=0;i<json.feed.entry.length;i++){
				list+='<div class="youtube left" style="width:'+(Ext.get('youtube_playlist').getWidth()-30)+'px;">';
				    var clean_title=json.feed.entry[i].media$group.media$title.$t;
				    clean_title=escape(clean_title);
					list+='<div class="thumbnail link left" style="background-image:url('+json.feed.entry[i].media$group.media$thumbnail[1].url+');background-position:50% 50%;" onclick="Crows.loadYoutube(\''+json.feed.entry[i].media$group.yt$videoid.$t+'\',\''+clean_title+'\')" >';
					list+='<img class="play_button" src="images/play.png">';
					list+='</div>';

				//list+='<div class="left">'
				list+='<span class="title bold">'+json.feed.entry[i].media$group.media$title.$t+'</span><br>';
				  
   
			      
					

			    
                if(json.feed.entry[i].published){
                	
                	var mydate=Date.parseDate(json.feed.entry[i].published.$t,'Y-m-d\\TH:i:s.u\\Z');
					list+='<div class="crowdate">'+Ext.util.Format.date(mydate,'D F j, Y')+'</div>';
                }else{
                	var mydate=Date.parseDate(json.feed.entry[i].media$group.yt$uploaded.$t,'Y-m-d\\TH:i:s.u\\Z');
					list+='<span class="crowdate">'+Ext.util.Format.date(mydate,'D F j, Y')+'</span>';

                }
                
               list+='<br><span class="description">'+json.feed.entry[i].media$group.media$description.$t+'</span>';
	
                
				list+='</div>';
			}        
			//Crows.loadYoutube(default_video_id);
			
			Ext.get('youtube_playlist').update(list);
			
			
			
		
			


		}
		
	});
		
}

Crows.flickrWidget=function(){
	
	if(Crows.flickr_mode=='photoset')var root='photoset';
	if(Crows.flickr_mode=='tagsearch')var root='photos';
	if(Crows.flickr_mode=='favorites')var root='photos';
	
	
	
	Crows.flickrStore=new Ext.data.JsonStore({
			url:'services/flickr_proxy.php'
			,autoLoad:false
			,totalCount:root+'.total'
			,fields: ['id','owner','secret','server','farm','title']
			,root:root+'.photo'
			,id:'id'
			,listeners:{'load':function(r){
				
			if(Crows.flickr_mode=='photoset'){
				var page=r.reader.jsonData.photoset.page;
			    var pages=r.reader.jsonData.photoset.pages;
			}
			
			if(Crows.flickr_mode=='tagsearch'){
				var page=r.reader.jsonData.photos.page;
			    var pages=r.reader.jsonData.photos.pages;
			}
			
			if(Crows.flickr_mode=='favorites'){
				var page=r.reader.jsonData.photos.page;
			    var pages=r.reader.jsonData.photos.pages;
			}
			    var paging_text='';
			  
			    if(page>1){paging_text+='<span class="bold link" onclick="Crows.flickrPager(\'less\');">&lt;prev</span>';}
			    paging_text+=' page <span id="page_number_box"></span> of '+pages+' ';
			    if((pages>1)||(page==pages))paging_text+='<span class="bold link" onclick="Crows.flickrPager(\'more\');">next&gt;</span>';
			    if(pages==1)paging_text='';
			    
			    
				Ext.get('flickr_controls').update(paging_text);
	            if(pages>1){
	            	new Ext.form.TextField({
	            		value:page
	            		,width:20
	            		,height:15
	            		,renderTo:'page_number_box'
	            		,id:'paging_input'
	            		,enableKeyEvents:true
	            		,listeners:{'keypress':function(t,e){
	            			
	            			if(e.button=='12'){
	            				
	            				Crows.flickrPager('box');
	            			}
	            		}}
	            	});
	            }
			}}
			
	});
		
	
	if(!Crows.flickr){
		Ext.get('flickr').update('You dont have a flickr api key set in the config.php,  go get one <a href="http://www.flickr.com/services/apps/create/apply/" target="_blank">here</a>');
		return;
	}
	new Ext.DataView({
							autoHeight:true
							,renderTo:'flickr'
							,id:'flickr_widget'
							,itemSelector:'flickr_thumb'
							,loadingText:'loading...'
							,store:Crows.flickrStore
							,tpl:Crows.flickrTemplate
							//,width:980	
							
	});
	
	    
    Crows.flickrStore.load();
}
        

Crows.twitterWidget=function(default_tag){
	
	if(Crows.twitter_account)Ext.get('twitter_controls').update('<span class="link" onclick="window.location=\'http://twitter.com/'+Crows.twitter_account+'\';">follow '+Crows.twitter_account);
	

	//generate twitter tabs
	var twitter_tabs='';
	for(i=0;i<Crows.twitter.length;i++){
		twitter_tabs+='<div class="tab link" id="hashtag_'+i+'"  onclick="Ext.select(\'.tab\').removeClass(\'active\');Ext.select(\'#hashtag_'+i+'\').addClass(\'active\');Crows.makeTweets(\''+Crows.twitter[i]+'\');">'+Crows.twitter[i]+'</div>';
	}
	

	new Ext.Panel({
		//autoHeight:true
		border:false
		,frame:false
		,height:Ext.get('twitter').getHeight()
		,autoWidth:true
		,renderTo:'twitter'
		,items:[
				{
					html:twitter_tabs
					,border:false
					,frame:false
				}
				,new Ext.DataView({
								//autoHeight:true
							
								renderTo:'twitter'
								//,autoScroll:'true'
								//,autoHeight:true
								,height:Ext.get('twitter').getHeight()-25
								,width:Ext.get('twitter').getWidth()-0
								,id:'tweet_data'
								,border:true
								,emptyText:'No tweets found.'
								,itemSelector:'tweet'
								,loadingText:'loading...'
								,store:Crows.tweetStore
								,tpl:Crows.tweetTemplate
								
				})
		]
	});
	
	Ext.select('#hashtag_0').addClass('active');
	Crows.makeTweets(default_tag);
	
    
}

Crows.reportsWidget=function(){
	 
	Ext.get('reports_controls').update('<span class="link report_link" onclick="window.location=Crows.main_url+\'/rss\';">RSS</span>&nbsp;&nbsp;<span class="link report_link" onclick="Crows.contribute();">add a report</span>');
	
	new Ext.DataView({
								//autoHeight:true
							
								renderTo:'reports'
								//,autoScroll:'true'
								//autoHeight:true
								,height:Ext.get('reports').getHeight()
								,width:Ext.get('reports').getWidth()-30
								,id:'reports_data'
								,border:true
								,emptyText:'No podcast episodes found.'
								,itemSelector:'report'
								,loadingText:'loading...'
								,store:Crows.reportsStore
								,tpl:Crows.reportsTemplate
								
	});
				
	Crows.reportsStore.load({
		callback:function(r){
			if(!Crows.map)return;
			for(j=0;j<r.length;j++){				
				var report=r[j];
				Crows.showAddress(report.data.id,report.data.lat,report.data.long);
			}
		}
		
	});
	
	
	
	 
	
}

Crows.podcastWidget=function(){
	
	Ext.get('podcast_playlist_controls').update('<a class="link" href="'+Crows.rss_feed+'">subscribe</a>');
	
	
	Crows.podcastStore = new Ext.data.XmlStore({
	    url: 'services/podcast_proxy.php'
	    ,autoLoad:false
	    ,record: 'item'
	    ,fields:((Crows.rss_feed.match('blip'))? [
	        'title',{name:'description' ,mapping: 'puredescription'},'ItemId'
	        ,{name:'thumbnail', mapping: 'smallThumbnail'},{name:'link' ,mapping: 'player'}
	    ]:[
	        'title','description','ItemId','link'  
	        ,{name:'thumbnail', mapping: 'thumbnail@url'}
	    ])
	   /* ,fields:[
	        'title',{name:'description' ,mapping: 'puredescription'},'ItemId'
	        ,{name:'thumbnail', mapping: 'smallThumbnail'},{name:'link' ,mapping: 'player'}
	    ]*/
	});
	
	
	
	new Ext.DataView({
							autoHeight:true
							,renderTo:'podcast_playlist'
							,id:'podcast_playlist_widget'
							,itemSelector:'episode'
							,loadingText:'loading...'
							,store:Crows.podcastStore
							,tpl:Crows.podcastTemplate
							,width:Ext.get('podcast_playlist').getWidth()-30
							,height:Ext.get('reports').getHeight()
	});
	
	

	Crows.podcastStore.load();
}

Crows.newsWidget=function(){
	
	//Ext.get('news_reader_controls').update('<a class="link" href="'+Crows.news_feed+'">subscribe</a>');
	
	new Ext.DataView({
							autoHeight:true
							,renderTo:'news_reader'
							,id:'news_reader_widget'
							,itemSelector:'newsarticle'
							,loadingText:'loading...'
							,store:Crows.newsStore
							,tpl:Crows.newsTemplate
							,width:Ext.get('news_reader').getWidth()-30
							,height:Ext.get('news_reader').getHeight()
	});

	Crows.newsStore.load();
}



Ext.onReady(function(){

	
	if(Ext.get('map'))Crows.makeMap('map');

	if(Ext.get('flickr'))Crows.flickrWidget();

	if(Ext.get('reports'))Crows.reportsWidget();
	
	if(Ext.get('twitter'))Crows.twitterWidget(Crows.default_tag);

	if(Ext.get('youtube_playlist'))Crows.youtubeWidget();
	
	if(Ext.get('podcast_playlist'))Crows.podcastWidget();
	
	if(Ext.get('news_reader'))Crows.newsWidget();


	
});


