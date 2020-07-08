jQuery(document).ready(function(){

	/* Promo banner in admin panel */

	jQuery('.promo-text-wrapper .close-btn').click(function(){

		var confirmIt = confirm('Are you sure?');

		if(!confirmIt) return;

		var widgetBlock = jQuery(this).parent();

		var data =  {
			'action':'et_close_promo',
			'close': widgetBlock.attr('data-etag')
		};

		widgetBlock.hide();

		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting');
				widgetBlock.show();
			}
		});
	});

	/* Theme versions masonry */

    $versions = jQuery('.et-theme-versions');


    $versions.each(function() {
        var version = jQuery(this);
        version.isotope({
            itemSelector: '.theme-ver'
        });
        jQuery(window).smartresize(function(){
            version.isotope({
                itemSelector: '.theme-ver'
            });
        });

        version.parent().find('.versions-filters a').click(function(){
            var selector = jQuery(this).attr('data-filter');
            version.parent().find('.versions-filters a').removeClass('active');
            if(!jQuery(this).hasClass('active')) {
                jQuery(this).addClass('active');
            }
            version.isotope({ filter: selector });

            return false;
        });
    });

    jQuery(window).resize();
    jQuery('.et-theme-versions').addClass('with-transition');
    jQuery('.theme-ver').addClass('with-transition');



	/* UNLIMITED SIDEBARS */

	var delSidebar = '<div class="delete-sidebar">delete</div>';

	jQuery('.sidebar-etheme_custom_sidebar').find('.handlediv').before(delSidebar);

	jQuery('.delete-sidebar').click(function(){

		var confirmIt = confirm('Are you sure?');

		if(!confirmIt) return;

		var widgetBlock = jQuery(this).closest('.sidebar-etheme_custom_sidebar');

		var data =  {
			'action':'etheme_delete_sidebar',
			'etheme_sidebar_name': jQuery(this).parent().find('h2').text()
		};

		widgetBlock.hide();

		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				console.log(response);
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting sidebar');
				widgetBlock.show();
			}
		});
	});


	/* end sidebars */


    jQuery('.importBtn').toggle(function(){
	    jQuery(this).next().show();
    },function(){
	    jQuery(this).next().hide();
    });

    // **********************************************************************//
	// ! Theme deactivating action
	// **********************************************************************//

	jQuery( '.etheme-deactivator' ).click( function(event) {
	event.preventDefault();

	var confirmIt = confirm( 'Are you sure?' );
	if( ! confirmIt ) return;

	var data =  {
		'action':'etheme_deactivate_theme',
	};

	var redirect = window.location.href;

	redirect = redirect.replace( 'ot-theme-options', 'etheme_activation_page' );

	jQuery.ajax({
		url: ajaxurl,
		data: data,
		success: function(data){
			console.log(data);
		},
		error: function(data) {
			alert('Error while deactivating');
		},
		complete: function(){
            window.location.href=redirect;
		}
	});
});


    /****************************************************/
    /* Import XML data */
    /****************************************************/

    var importBtn = jQuery('#install_demo_pages');

	importBtn.bind("click", (function(e){
		e.preventDefault();

        var style = jQuery('#demo_data_style').val();

		if(!confirm('Are you sure you want to install base demo data? (It will change all your theme configuration, menu etc.)')) {

			return false;

		}

		importBtn.after('<div id="floatingCirclesG" class="et-loading"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div>');
        importBtn.text('Installing demo data... Please wait...').addClass('disabled').attr('disabled', 'disabled').unbind('click');

		jQuery.ajax({
			method: "POST",
			url: ajaxurl,
			data: {
				'action':'etheme_import_ajax'
			},
			success: function(data){
				jQuery('#option-tree-sub-header').before('<div id="setting-error-settings_updated" class="updated settings-error">' + data + '</div>');
			},
			complete: function(){
                jQuery('#floatingCirclesG').remove();
                //jQuery('.installing-info').remove();
                importBtn.addClass('green');
                importBtn.text('Successfully installed!');
                location.reload();
			}
		});

	}));

	var installProccess = false;

	jQuery('.install-ver').click(function(e) {
		e.preventDefault();
		if ( confirm('Are you sure you want to install demo data? (It will change all your theme configuration, menu etc.)') ) {
			jQuery('.ver-install-result').html('');
			if(installProccess) return;
			installProccess = true;
			var version = jQuery(this).data('ver');
			var home_id = jQuery(this).data('home_id');

			jQuery(this).after('<div id="floatingCirclesG" class="et-loading"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div>');

			jQuery.ajax({
				method: "POST",
				url: ajaxurl,
				data: {
					'action':'etheme_install_version',
					'ver': version,
					'home_id': home_id
				},
				success: function(data){
					jQuery('.ver-install-result').html('').html(data);
				},
				complete: function(){
	                jQuery('#floatingCirclesG').remove();
	                installProccess = false;
	                location.reload();
				}
			});

		}

	});


	/****************************************************/
	/* Load YouTybe videos use youtube/v3 api*/
	/****************************************************/
	GetYouTybe();
	jQuery('.et-button.more-videos').on('click', function(e){
 		e.preventDefault();
	 	GetYouTybe();
	});

	// ! Get data from YouTybe
	function GetYouTybe(){
		// ! Do it only on support page
		if ( jQuery( '.etheme-support' ).length < 1 ) {
			return;
		}

	    var nextPageToken = jQuery('.et-button.more-videos').attr( 'next-page' );
	    jQuery.get(
	        "https://www.googleapis.com/youtube/v3/playlistItems",{
		        part : 'snippet', 
		        maxResults : 6,
		        playlistId : 'PLMqMSqDgPNmAEZYkSpPXhXc7NzamMDQkx',
		        order: 'date',
		        pageToken : nextPageToken,
	        	key: 'AIzaSyBNsAxteDRIwO1A6Ainv8u-_vVYcPPRYB8'
	        },
	        function(data){
              	ShowFrames(data);
	        }        
	    );  
	}

	// ! Insert frames to the page
	function ShowFrames(data){
	    var spinner = '<span class="spinner is-active">\
            <div class="et-loader ">\
                <svg class="loader-circular" viewBox="25 25 50 50">\
                <circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>\
                </svg>\
            </div>\
            </span>';

	    jQuery('.et-button.more-videos').attr( 'next-page', data['nextPageToken'] );

	    jQuery.each( data.items, function(k, v){
	      	var rand = Math.floor((Math.random() * 100) + 1);
	      	jQuery( '.etheme-videos' ).append( '<div class="etheme-video text-center holder-'+ rand +'">' + spinner + '<iframe src="https://www.youtube.com/embed/' + v['snippet']['resourceId']['videoId'] + '" allowfullscreen></iframe></div>' );
	      	jQuery('.holder-' + rand + ' iframe').load(function(){
				jQuery( '.holder-' + rand + ' .spinner' ).removeClass('is-active');
			});
	     });

      	if ( data.pageInfo.totalResults == jQuery( '.etheme-video' ).length ) {
  			$('.et-button.more-videos').remove();
  			return;
  		} 
	}

	/****************************************************/
	/* Panel social functions
	/****************************************************/
	jQuery(document).on('click', '.etheme-user .user-remove', function(e) {
		e.preventDefault();
		if ( ! confirm( 'Are you sure' ) ) {
			return;
		}
		var user = jQuery(this).parents('.etheme-user');
		var data =  {
			'action':'et_instagram_user_remove',
			'token': user.find('.user-token').attr( 'data-token' )
		};
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data,
			success: function(data){
				if ( data != 'success' ){
				} else {
					if ( jQuery( '.etheme-user' ).length < 2 ) {
						jQuery( '.etheme-no-users' ).removeClass( 'hidden' );
					}
						
					user.remove();
				}
			},
			error: function(){
				alert('Error while deleting');
			},
			complete: function(){

			}
		});
	});


	jQuery(document).on('click', '.etheme-instagram-settings .etheme-instagram-save', function(e) {
		e.preventDefault();
		if ( ! confirm( 'Are you sure ?' ) ) {
			return;
		}
		var data =  {
			'action':'et_instagram_save_settings',
			'time':jQuery('#instagram_time').attr('value'),
			'time_type': jQuery('#instagram_time_type').attr('value')
		};
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data,
			success: function(data){
				console.log(data);
			},
			error: function(){
				alert('Error while deleting');
			},
			complete: function(){

			}
		});
	});

	jQuery(document).on('click', '.etheme-instagram-manual', function(e) {
		e.preventDefault();
		if ( jQuery( '.etheme-instagram-manual-form' ).hasClass( 'hidden' ) ) {
			jQuery( '.etheme-instagram-manual-form' ).removeClass( 'hidden' );
		} else {
			jQuery( '.etheme-instagram-manual-form' ).addClass( 'hidden' );
		}
	});


	jQuery(document).on('click', '.etheme-manual-btn', function(e) {
		e.preventDefault();
		if ( ! confirm( 'Are you sure' ) ) {
			return;
		}
		var parent = jQuery(this).parent();
		var data =  {
			'action': 'et_instagram_user_add',
			'token' : jQuery( '#etheme-manual-token' ).attr( 'value' )
		};

		if ( ! data['token'] ) {
			parent.find( '.etheme-form-error' ).removeClass( 'hidden' );
			return;
		} else {
			parent.find( '.etheme-form-error' ).addClass( 'hidden' );
		}
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data,
			success: function(data){
				if ( data != 'success' ){
					parent.find( '.etheme-form-error-holder' ).text( '' );
					parent.find( '.etheme-form-error-holder' ).text( data );
					parent.find( '.etheme-form-error-holder' ).removeClass( 'hidden' );
				} else {
					location.reload();
				}
			},
			error: function(){
				alert('Error while deleting');
			},
			complete: function(){

			}
		});
	});
});
