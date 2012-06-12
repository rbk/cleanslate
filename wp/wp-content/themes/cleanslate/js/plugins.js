// place any jQuery/helper plugins in here, instead of separate, slower script files.


/*
 * Try/Catch the console
 */
try{
    console.log('Hello Console.');
} catch(e) {
    window.console = {};
    var cMethods = "assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(",");
    for (var i=0; i<cMethods.length; i++) {
        console[ cMethods[i] ] = function(){};
    }
}

(function($) {
	$("#newsletter-signup").live("submit",function(event) {
		event.preventDefault();
		if (!/\S+@\S+\.\S+/.test($(this).find("[name=email]").val())) {
			alert("Please enter your email address");
			return;
		}
		 $.ajax({
			type:'POST',
			url: Guru.Url + "/wp/wp-admin/admin-ajax.php", 
			data: $(this).serialize(),
			cookie: encodeURIComponent(document.cookie),
			success:  function(str){
			      alert(str);
			}
		});		
	});
})(jQuery);






(function($){

	Guru.loadingGoogle = false;

	//google maps custom integration
	Guru.Map = function(config){
		//default configurable variables
		var me = this,
			defaults = {
				zoom: 4,
				//center on Salina kansas for good full us view
				centerLat: 38.7902935,
				centerLng: -97.64023729999997,
				mapHeight: 500,
				fitMarkers: false, //fit all the markers on the map?  overrides centerLatLng and zoom
				markerOverridesCenter: false,
				contId: 'gmapCont',
				dataCont: '.locationList',
				dataBlock: '.locationItem',
				dataAttr: 'location-data',
				locationKey: 'location_address',
				fallbackLocationKey: 'mailing_address',
				fallbackOverrideKey: false, //set as post meta to prefer the secondary address as the marker address
				markerImageKey: false,
				zoomControlStyle: 'DEFAULT',
				zoomPosition: 'TOP_LEFT',
				streetViewControl: false,
				scrollwheel: false,
				mapTypeId: 'ROADMAP',
				markerScale: 0.5,
				blocksAreClickable: false,
				scrollToMapOnClick: false,
				scrollSpeed: 500,
				directionsLink: false,
				globalInitID: 'GuruMapInit' //used to expose the setupConstants (used in init) function globally for googles async callback... change this to something unique for each instance running
			};
		for (var key in config) {
			defaults[key] = config[key] || defaults[key];
		}
		for (var key in defaults) {
			me[key] = defaults[key];
		}

		//me.loadingGoogle = false;

		me.setupConstants = function(){
			
			if ( typeof google !== 'undefined' && typeof google.maps !== 'undefined' && typeof google.maps.InfoWindow !== 'undefined' ) {
	
				//remove global access to this setup function
				if ( window[me.globalInitID] )
					window[me.globalInitID] = undefined;
	
				//constants
				Guru.loadingGoogle = false;
	
				me.infowindow = new google.maps.InfoWindow();
	
				me.directionsService = new google.maps.DirectionsService();
				//me.directionsDisplay = new google.maps.DirectionsRenderer({ suppressMarkers: true });
				me.directionsDisplay = new google.maps.DirectionsRenderer();
				//keep that map out of it for now.
				me.directionsDisplay.setMap( null );
				//geocoder used to take address and convert it to latLng and make marker
				me.geocoder = new google.maps.Geocoder();
				me.center = null;
				me.cont = null;
				me.map = null;
				me.form = null;
				me.startAddy = '';
				me.endAddy = '';
				me.currentRoute = null;
				me.confirmBttn = null;
				//me.waypoints = [];
				me.dblclickListener = null;
	
				me.data = [];
				me.markers = [];
	
				me.init();
	
			} else {
				//console.log('no google');
	
				if (!Guru.loadingGoogle) {
					Guru.loadingGoogle = true;
	
					//make this setup function available globally
					window[me.globalInitID] = me.setupConstants;
	
					var script = document.createElement("script");
					script.type = "text/javascript";
					script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback="+me.globalInitID;
					document.body.appendChild(script);
				} else {
					setTimeout( me.setupConstants, 50 );
				}
	
	
			}
			
		};

		me.handleBlockClick = function(e){			
			//find associated marker, and setup the coords like google does
			var marker = me.markers[ $(this).attr('markerIndex') ],
				coords = { latLng: marker.position };
	
			//console.log('me.handleBlockClick', e, this, marker, coords);
			me.handleMarkerClick.apply( marker, [coords] );
	
			//move page up to see map?
			if ( me.scrollToMapOnClick ){
				//finding the target element is not 'smart' (enough) right now, make it smarter later.
				var target = $(me.cont).closest('section'),
					off = target.offset(),
					//different browsers use different elements to calculate the scrolltop ( webkit=body, mozilla=html, par example )
					sTop = $('body').scrollTop() || $('html').scrollTop();
	
				if( sTop > off.top )
					$('html, body').stop(false, false).animate({ scrollTop: off.top }, me.scrollSpeed );
	
				target = null;
				off = null;
			}
	
			return;
		};
	
		me.handleMarkerClick = function( coords ){	
			var content = '<div class="mapInfoDom">'+$(this.item.DOM).html();
	
	
			//here is where we print out a directions link
			if (me.directionsLink) {
				var addy = this.item[me.locationKey].replace(/ /g,'+').replace(/\n/g,',+'),
					//dUrl = 'http://maps.google.com/maps?saddr=&daddr='+addy+'&z=14'
					dUrl = 'http://maps.google.com/maps?saddr=&daddr='+addy
	
				//console.log( addy );
	
				content += '<a class="directionsLink" href="'+dUrl+'" title="Get directions to this site" target="_blank">Get Driving Directions</a>';
			}
	
			content += '</div>';
	
			//console.log( this.item.DOM );
	
			me.infowindow.setContent( content );
	
			me.infowindow.open(me.map, this);
		};


		me.setupConstants();
	};

	Guru.Map.prototype.init = function(){
		//gather data from page elements
		this.setupMarkerData();

		//setup the map and initialize it.
		this.setupMap();

		//setup markers
		this.setupMarkers();

	};

	Guru.Map.prototype.setupMap = function(){
		var me = this;
		//find the container
		me.cont = document.getElementById( me.contId );

		//check dimensions
		if ( !$(me.cont).height() )
			$(me.cont).height( me.mapHeight );

		//console.log( 'me.cont', $(me.cont).width(), $(me.cont).height() );

		//set the google center
		me.center = new google.maps.LatLng( me.centerLat, me.centerLng );

		//get the map
		me.map = new google.maps.Map( me.cont, {
			center: me.center,
			zoom: me.zoom,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle[ me.zoomControlStyle ],
		        position:  google.maps.ControlPosition[me.zoomPosition]
				
			},
			streetViewControl: me.streetViewControl,
			scrollwheel: me.scrollwheel,
			mapTypeId: google.maps.MapTypeId[ me.mapTypeId ]
		});
		console.log(me.map);
	};

	Guru.Map.prototype.setupMarkers = function(){
		var me = this;
		
		if ( me.data.length ) {
			//start bounds here for fitmarkers option later down
			var latLngBounds = new google.maps.LatLngBounds();

			//iterate through markers
			$.each(me.data, function(i){
				//console.log( i, this );

				var dataObj = this,
					address = ( me.fallbackOverrideKey && dataObj[ me.fallbackOverrideKey ] && dataObj[ me.fallbackLocationKey ] ?
									//if so, use the fallback key
									dataObj[ me.fallbackLocationKey ] :
									//otherwise, if there is no preference, try to use the primary key, and then fallback if it is not there
									dataObj[ me.locationKey ] || dataObj[ me.fallbackLocationKey ]
								);

				//console.log('dataObj', dataObj);

				if ( address ) {

					//console.log( 'address', address, me.stripTags( address ) );
					me.geocoder.geocode({

						address: me.stripTags( address )

					}, function(results, status){

						if (status === google.maps.GeocoderStatus.OK) {

							me.markers[i] = new google.maps.Marker({
								map: me.map,
								position: results[0].geometry.location,
								item: dataObj
							});

							//add a custom marker image?
							if ( me.markerImageKey && dataObj[ me.markerImageKey ] ){
								var img = dataObj[ me.markerImageKey ],
									src = img['src'],
									w = Math.floor( img.width * me.markerScale ),
									h = Math.floor( img.height * me.markerScale );

								me.markers[i].setIcon( new google.maps.MarkerImage(
																//url
																dataObj[ me.markerImageKey ].src,
																//original image size ( width, height )
																new google.maps.Size( w, h ),
																//origin in image ( left, top ), (0,0) is google default
																new google.maps.Point( 0, 0 ),
																//anchor point
																new google.maps.Point( w/2, h/2 ),
																new google.maps.Size( w, h )
															)
								);

								w = null;
								h = null;
								src = null;
								img = null;
							}

							//bind the click listener
							//google.maps.event.addListener( me.markers[i], 'mousedown', me.handleMarkerClick );
							google.maps.event.addListener( me.markers[i], 'click', me.handleMarkerClick );

							//attach click handler to block if set
							if ( me.blocksAreClickable ) {

								$(dataObj.DOM).attr({ markerIndex: i }).mousedown( me.handleBlockClick ).find('a').click(me.preventBlockLinks);

							}

							if (me.fitMarkers) {
								//extend the auto bounds
								latLngBounds.extend( me.markers[i].position );
								me.map.fitBounds( latLngBounds );
							}
							
							//reset the center if the overrides exist.  came in dolphin project
							if( me.markerOverridesCenter && dataObj.center_lat && dataObj.center_lng ) {
								me.map.setCenter( new google.maps.LatLng( dataObj.center_lat, dataObj.center_lng ) );
							}							
							//console.log( dataObj.DOM );
						} else {
							//something went wrong.
							alert("Geocode was not successful for the following reason: " + status);
						}
					});
				}

			});
		}
	};

	Guru.Map.prototype.preventBlockLinks = function(e){
		e.preventDefault();
	};
	
	Guru.Map.prototype.setupMarkerData = function(){
		var me = this;	
		//dataBlock supplied in config
		return $(me.dataCont).find(me.dataBlock).each(function(){
			//console.log( $(this).attr( me.dataAttr ) );
			var item = JSON.parse( $(this).attr( me.dataAttr ) );
			item.DOM = this;
			me.data.push( item );
		});
	};

	Guru.Map.prototype.stripTags = function(s){
		//s = String
		if (typeof s !== 'string')
			return false;
		return s.replace(/<([^>]+)>/g,'').replace(/\n|\r/g,' ');
		//return s.replace(/\\n/g,'');
	};

})(jQuery);


