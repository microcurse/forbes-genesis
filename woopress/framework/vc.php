<?php
// **********************************************************************//
// ! Visual Composer Setup
// **********************************************************************//
add_action( 'init', 'etheme_VC_setup');
if(!function_exists('getCSSAnimation')) {
	function getCSSAnimation($css_animation) {
        $output = '';
        if ( $css_animation != '' ) {
            wp_enqueue_script( 'waypoints' );
            $output = ' wpb_animate_when_almost_visible wpb_'.$css_animation;
        }
        return $output;
	}
}
if(!function_exists('buildStyle')) {
    function buildStyle($bg_image = '', $bg_color = '', $bg_image_repeat = '', $font_color = '', $padding = '', $margin_bottom = '') {
        $has_image = false;
        $style = '';
        if((int)$bg_image > 0 && ($image_url = wp_get_attachment_url( $bg_image, 'large' )) !== false) {
            $has_image = true;
            $style .= "background-image: url(".$image_url.");";
        }
        if(!empty($bg_color)) {
            $style .= vc_get_css_color('background-color', $bg_color);
        }
        if(!empty($bg_image_repeat) && $has_image) {
            if($bg_image_repeat === 'cover') {
                $style .= "background-repeat:no-repeat;background-size: cover;";
            } elseif($bg_image_repeat === 'contain') {
                $style .= "background-repeat:no-repeat;background-size: contain;";
            } elseif($bg_image_repeat === 'no-repeat') {
                $style .= 'background-repeat: no-repeat;';
            }
        }
        if( !empty($font_color) ) {
            $style .= vc_get_css_color('color', $font_color); // 'color: '.$font_color.';';
        }
        if( $padding != '' ) {
            $style .= 'padding: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding) ? $padding : $padding.'px').';';
        }
        if( $margin_bottom != '' ) {
            $style .= 'margin-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom.'px').';';
        }
        return empty($style) ? $style : ' style="'.$style.'"';
    }
}
if(!function_exists('etheme_VC_setup')) {
	function etheme_VC_setup() {
		if (!class_exists('WPBakeryVisualComposerAbstract')) return;
		global $vc_params_list;
		$vc_params_list[] = 'icon';

		vc_remove_element("vc_carousel");
		vc_remove_element("vc_images_carousel");
		vc_remove_element("vc_tour");



		$target_arr = array(esc_html__("Same window", "woopress") => "_self", esc_html__("New window", "woopress") => "_blank");
		$add_css_animation = array(
		  "type" => "dropdown",
		  "heading" => esc_html__("CSS Animation", "woopress"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(esc_html__("No", "woopress") => '', esc_html__("Top to bottom", "woopress") => "top-to-bottom", esc_html__("Bottom to top", "woopress") => "bottom-to-top", esc_html__("Left to right", "woopress") => "left-to-right", esc_html__("Right to left", "woopress") => "right-to-left", esc_html__("Appear from center", "woopress") => "appear"),
		  "description" => esc_html__("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "woopress")
		);


	    // **********************************************************************//
	    // ! Separator
	    // **********************************************************************//
	    $setting_vc_separator = array (
	    "show_settings_on_create" => true,
	      'params' => array(
	          array(
	            "type" => "dropdown",
	            "heading" => esc_html__("Type", "woopress"),
	            "param_name" => "type",
	            "value" => array(
	                "",
	                esc_html__("Default", 'woopress') => "",
	                esc_html__("Double", 'woopress') => "double",
	                esc_html__("Dashed", 'woopress') => "dashed",
	                esc_html__("Dotted", 'woopress') => "dotted",
	                esc_html__("Double Dotted", 'woopress') => "double dotted",
	                esc_html__("Double Dashed", 'woopress') => "double dashed",
	                esc_html__("Horizontal break", 'woopress') => "horizontal-break",
	                esc_html__("Space", 'woopress') => "space"
	              )
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => esc_html__("Height", "woopress"),
	            "param_name" => "height",
	            "dependency" => Array('element' => "type", 'value' => array('space'))
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => esc_html__("Extra class", "woopress"),
	            "param_name" => "class"
	          )
	        )
	    );
	    vc_map_update('vc_separator', $setting_vc_separator);

	    function vc_theme_vc_separator($atts, $content = null) {
	      $output = $color = $el_class = $css_animation = '';
	      extract(shortcode_atts(array(
	          'type' => '',
	          'class' => '',
	          'height' => ''
	      ), $atts));

	      $output .= do_shortcode('[hr class="'.$type.' '.$class.'" height="'.$height.'"]');
	      return $output;
	    }


	    // **********************************************************************//
	    // ! FAQ toggle elements
	    // **********************************************************************//
		$toggle_params = array(
			"name" => esc_html__("FAQ", "woopress"),
			"icon" => "icon-wpb-toggle-small-expand",
			"category" => esc_html__('Content', 'woopress'),
			"description" => esc_html__('Toggle element for Q&A block', 'woopress'),
			"params" => array(
				array(
					"type" => "textfield",
					"holder" => "h4",
					"class" => "toggle_title",
					"heading" => esc_html__("Toggle title", "woopress"),
					"param_name" => "title",
					"value" => esc_html__("Toggle title", "woopress"),
					"description" => esc_html__("Toggle block title.", "woopress")
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "toggle_content",
					"heading" => esc_html__("Toggle content", "woopress"),
					"param_name" => "content",
					"value" => esc_html__("<p>Toggle content goes here, click edit button to change this text.</p>", "woopress"),
				"description" => esc_html__("Toggle block content.", "woopress")
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Default state", "woopress"),
					"param_name" => "open",
					"value" => array(esc_html__("Closed", "woopress") => "false", esc_html__("Open", "woopress") => "true"),
					"description" => esc_html__('Select "Open" if you want toggle to be open by default.', "woopress")
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", "woopress"),
					"param_name" => "style",
					"value" => array(esc_html__("Default", "woopress") => "default", esc_html__("Bordered", "woopress") => "bordered")
				),
				$add_css_animation,
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", "woopress"),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress")
				)
			),
			"js_view" => 'VcToggleView'
		);

	    vc_map_update('vc_toggle', $toggle_params);

	    function vc_theme_vc_toggle($atts, $content = null) {
	      $output = $title = $css_class = $el_class = $open = $css_animation = '';
	      extract(shortcode_atts(array(
	          'title' => esc_html__("Click to toggle", "woopress"),
	          'el_class' => '',
	          'style' => 'default',
	          'open' => 'false',
	          'css_animation' => ''
	      ), $atts));


	      $open = ( $open == 'true' ) ? 1 : 0;

	      $css_class .= getCSSAnimation($css_animation);
	      $css_class .= ' '.$el_class;

	      $output .= '<div class="toggle-block '.$css_class.' '.$style.'">'.do_shortcode('[toggle title="'.$title.'" class="'.$css_class.'" active="'.$open.'"]'.wpb_js_remove_wpautop($content).'[/toggle]').'</div>';


	      return $output;
	    }

	    // **********************************************************************//
	    // ! Sliders
	    // **********************************************************************//
	   $setting_vc_gallery = array(
		  "name" => esc_html__("Image Gallery", "woopress"),
		  "icon" => "icon-wpb-images-stack",
		  "category" => esc_html__('Content', 'woopress'),
		  "params" => array(
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Widget title", "woopress"),
		      "param_name" => "title",
		      "description" => esc_html__("What text use as a widget title. Leave blank if no title is needed.", "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Gallery type", "woopress"),
		      "param_name" => "type",
		      "value" => array(esc_html__("OWL slider", "woopress") => "owl", esc_html__("Nivo slider", "woopress") => "nivo", esc_html__("Carousel", "woopress") => "carousel", esc_html__("Image grid", "woopress") => "image_grid"),
		      "description" => esc_html__("Select gallery type.", "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Auto rotate slides", "woopress"),
		      "param_name" => "interval",
		      "value" => array(3, 5, 10, 15, esc_html__("Disable", "woopress") => 0),
		      "description" => esc_html__("Auto rotate slides each X seconds.", "woopress"),
		      "dependency" => Array('element' => "type", 'value' => array('flexslider_fade', 'flexslider_slide', 'nivo'))
		    ),
		    array(
		      "type" => "attach_images",
		      "heading" => esc_html__("Images", "woopress"),
		      "param_name" => "images",
		      "value" => "",
		      "description" => esc_html__("Select images from media library.", "woopress")
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Image size", "woopress"),
		      "param_name" => "img_size",
		      "description" => esc_html__("Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size.", "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("On click", "woopress"),
		      "param_name" => "onclick",
		      "value" => array(esc_html__("Open prettyPhoto", "woopress") => "link_image", esc_html__("Do nothing", "woopress") => "link_no", esc_html__("Open custom link", "woopress") => "custom_link"),
		      "description" => esc_html__("What to do when slide is clicked?", "woopress")
		    ),
		    array(
		      "type" => "exploded_textarea",
		      "heading" => esc_html__("Custom links", "woopress"),
		      "param_name" => "custom_links",
		      "description" => esc_html__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'woopress'),
		      "dependency" => Array('element' => "onclick", 'value' => array('custom_link'))
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Custom link target", "woopress"),
		      "param_name" => "custom_links_target",
		      "description" => esc_html__('Select where to open  custom links.', 'woopress'),
		      "dependency" => Array('element' => "onclick", 'value' => array('custom_link')),
		      'value' => $target_arr
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Extra class name", "woopress"),
		      "param_name" => "el_class",
		      "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress")
		    )
		  )
		);

	    vc_map_update('vc_gallery', $setting_vc_gallery);

	    function vc_theme_vc_gallery($atts, $content = null) {
	      $output = $title = $type = $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $interval = '';
	      extract(shortcode_atts(array(
	          'title' => '',
	          'type' => 'owl',
	          'onclick' => 'link_image',
	          'custom_links' => '',
	          'custom_links_target' => '',
	          'img_size' => 'thumbnail',
	          'images' => '',
	          'el_class' => '',
	          'interval' => '5',
	      ), $atts));
	      $gal_images = '';
	      $link_start = '';
	      $link_end = '';
	      $el_start = '';
	      $el_end = '';
	      $slides_wrap_start = '';
	      $slides_wrap_end = '';
	      $rand = rand(1000,9999);

	      $el_class = ' '.$el_class.' ';

	      if ( $type == 'nivo' ) {
	          $type = ' wpb_slider_nivo theme-default';
	          wp_enqueue_script( 'nivo-slider' );
	          wp_enqueue_style( 'nivo-slider-css' );
	          wp_enqueue_style( 'nivo-slider-theme' );

	          $slides_wrap_start = '<div class="nivoSlider">';
	          $slides_wrap_end = '</div>';
	      } else if ( $type == 'flexslider' || $type == 'flexslider_fade' || $type == 'flexslider_slide' || $type == 'fading' ) {
	          $el_start = '<li>';
	          $el_end = '</li>';
	          $slides_wrap_start = '<ul class="slides">';
	          $slides_wrap_end = '</ul>';
	      } else if ( $type == 'image_grid' ) {

			  wp_enqueue_script( 'vc_grid-js-imagesloaded' );
			  wp_enqueue_script( 'isotope' );
			  wp_enqueue_style( 'isotope-css' );

	          $el_start = '<li class="gallery-item">';
	          $el_end = '</li>';
	          $slides_wrap_start = '<ul class="wpb_images_grid_ul">';
	          $slides_wrap_end = '</ul>';
	      } else if ( $type == 'carousel' ) {

	          $el_start = '<li class="">';
	          $el_end = '</li>';
	          $slides_wrap_start = '<ul class="images-carousel owl-carousel owl-theme carousel-'.$rand.'">';
	          $slides_wrap_end = '</ul>';
	      }

	      $flex_fx = '';
	      $flex = false;
	      $owl = false;
	      if ( $type == 'flexslider' || $type == 'flexslider_fade' || $type == 'fading' ) {
	          $flex = true;
	          $type = ' wpb_flexslider'.$rand.' flexslider_fade flexslider';
	          $flex_fx = ' data-flex_fx="fade"';
	      } else if ( $type == 'flexslider_slide' ) {
	          $flex = true;
	          $type = ' wpb_flexslider'.$rand.' flexslider_slide flexslider';
	          $flex_fx = ' data-flex_fx="slide"';
	      } else if ( $type == 'image_grid' ) {
	          $type = ' wpb_image_grid';
	      } else if ( $type == 'owl' ) {
	          $type = ' owl_slider'.$rand.' owl-carousel owl-theme owl_slider';
	          $owl = true;
	      }


	      /*
	       else if ( $type == 'fading' ) {
	          $type = ' wpb_slider_fading';
	          $el_start = '<li>';
	          $el_end = '</li>';
	          $slides_wrap_start = '<ul class="slides">';
	          $slides_wrap_end = '</ul>';
	          wp_enqueue_script( 'cycle' );
	      }*/

	      //if ( $images == '' ) return null;
	      if ( $images == '' ) $images = '-1,-2,-3';

	      $pretty_rel_random = 'rel-'.rand();

	      if ( $onclick == 'custom_link' ) { $custom_links = explode( ',', $custom_links); }
	      $images = explode( ',', $images);
	      $i = -1;

	      foreach ( $images as $attach_id ) {
	          $i++;
	          if ($attach_id > 0) {
	              $post_thumbnail = wpb_getImageBySize(array( 'attach_id' => $attach_id, 'thumb_size' => $img_size ));
	          }
	          else {
	              $different_kitten = 400 + $i;
	              $post_thumbnail = array();
	              $post_thumbnail['thumbnail'] = '<img src="http://placekitten.com/g/'.$different_kitten.'/300" />';
	              $post_thumbnail['p_img_large'][0] = 'http://placekitten.com/g/1024/768';
	          }

	          $thumbnail = $post_thumbnail['thumbnail'];
	          $p_img_large = $post_thumbnail['p_img_large'];
	          $link_start = $link_end = '';

	          if ( $onclick == 'link_image' ) {
	              $link_start = '<a rel="lightboxGall" href="'.$p_img_large[0].'">';
	              $link_end = '</a>';
	          }
	          else if ( $onclick == 'custom_link' && isset( $custom_links[$i] ) && $custom_links[$i] != '' ) {
	              $link_start = '<a href="'.$custom_links[$i].'"' . (!empty($custom_links_target) ? ' target="'.$custom_links_target.'"' : '') . '>';
	              $link_end = '</a>';
	          }
	          $gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
	      }
	      $css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element'.$el_class.' clearfix');
	      $output .= "\n\t".'<div class="'.$css_class.'">';
	      $output .= "\n\t\t".'<div class="wpb_wrapper">';
	      $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));
	      $output .= '<div class="wpb_gallery_slides'.$type.'" data-interval="'.$interval.'"'.$flex_fx.'>'.$slides_wrap_start.$gal_images.$slides_wrap_end.'</div>';
	      $output .= "\n\t\t".'</div> ';
	      $output .= "\n\t".'</div> ';

	      if ( $owl ) {

			  $items = '{0:{items:1}, 479:{items:1}, 619:{items:1}, 768:{items:1},  1200:{items:1}, 1600:{items:1}}';
			  $output .=  '<script type="text/javascript">';
			  //$output .=  '     jQuery(".images-carousel").etFullWidth();';
			  $output .=  '     jQuery(".owl_slider'.$rand.'").owlCarousel({';
			  $output .=  '         items:4, ';
			  $output .=  '         nav: true,';
			  $output .=  '         navText:["",""],';
			  $output .=  '         rewind: false,';
			  $output .=  '         responsive: '.$items.'';
			  $output .=  '    });';

			  $output .=  ' </script>';
	      }

		  if( $type == 'carousel' ) {
	      		   $items = '{0:{items:1}, 479:{items:2}, 619:{items:2}, 768:{items:4},  1200:{items:4}, 1600:{items:4}}';
		           $output .=  '<script type="text/javascript">';
		           //$output .=  '     jQuery(".images-carousel").etFullWidth();';
		           $output .=  '     jQuery(".carousel-'.$rand.'").owlCarousel({';
		           $output .=  '         items:4, ';
		           $output .=  '         nav: true,';
		           $output .=  '         navText:["",""],';
		           $output .=  '         rewind: false,';
		           $output .=  '         responsive: '.$items.'';
		           $output .=  '    });';

		           $output .=  ' </script>';
	      }

	      return $output;
	    }


	    // **********************************************************************//
	    // ! Accordion
	    // **********************************************************************//

	    function vc_theme_vc_accordion($atts, $content = null) {
			wp_enqueue_script('jquery-ui-accordion');
	      $output = $title = $interval = $el_class = $collapsible = $active_tab = '';
	      //
	      extract(shortcode_atts(array(
	          'title' => '',
	          'interval' => 0,
	          'el_class' => '',
	          'collapsible' => 'no',
	          'active_tab' => '1'
	      ), $atts));

	      $el_class = ' '.$el_class.' ';
	      $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion wpb_content_element '.$el_class.' not-column-inherit');


	      $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_accordion_heading'));

	      $output .= "\n\t".'<div class=" tabs accordion" data-active="'.$active_tab.'">';
	      $output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
	      $output .= "\n\t".'</div> ';
	      return $output;
	    }

	    function vc_theme_vc_accordion_tab($atts, $content = null) {
	      global $tab_count;
	      $output = $title = '';

	      extract(shortcode_atts(array(
	        'title' => esc_html__("Section", "woopress")
	      ), $atts));

	      $tab_count++;

	          $output .= "\n\t\t\t\t" . '<a href="#tab_'.$tab_count.'" id="tab_'.$tab_count.'" class="tab-title">'.$title.'</a>';
	          $output .= "\n\t\t\t\t" . '<div id="content_tab_'.$tab_count.'" class="tab-content"><div class="tab-content-inner">';
	              $output .= ($content=='' || $content==' ') ? esc_html__("Empty section. Edit page to add content here.", "woopress") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
	              $output .= "\n\t\t\t\t" . '</div></div>';
	      return $output;
	    }

	    // **********************************************************************//
	    // ! Tabs
	    // **********************************************************************//

	    $tab_id_1 = time().'-1-'.rand(0, 100);
	    $tab_id_2 = time().'-2-'.rand(0, 100);
	    $setting_vc_tabs = array(
	      "name"  => esc_html__("Tabs", "woopress"),
	      "show_settings_on_create" => true,
	      "is_container" => true,
	      "icon" => "icon-wpb-ui-tab-content",
	      "category" => esc_html__('Content', 'woopress'),
	      "params" => array(
	        array(
	          "type" => "textfield",
	          "heading" => esc_html__("Widget title", "woopress"),
	          "param_name" => "title",
	          "description" => esc_html__("What text use as a widget title. Leave blank if no title is needed.", "woopress")
	        ),
	        array(
	          "type" => "dropdown",
	          "heading" => esc_html__("Tabs type", "woopress"),
	          "param_name" => "type",
	          "value" => array(esc_html__("Default", "woopress") => '',
	              esc_html__("Products Tabs", "woopress") => 'products-tabs',
	              esc_html__("Accordion", "woopress") => 'accordion',
	              esc_html__("Left bar", "woopress") => 'left-bar',
	              esc_html__("Right bar", "woopress") => 'right-bar')
	        ),
	        array(
	          "type" => "textfield",
	          "heading" => esc_html__("Extra class name", "woopress"),
	          "param_name" => "el_class",
	          "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress")
	        )
	      ),
	      "custom_markup" => '
	      <div class="wpb_tabs_holder wpb_holder vc_container_for_children">
	      <ul class="tabs_controls">
	      </ul>
	      %content%
	      </div>'
	      ,
	      'default_content' => '
	      [vc_tab title="'.esc_html__('Tab 1','woopress').'" tab_id="'.$tab_id_1.'"][/vc_tab]
	      [vc_tab title="'.esc_html__('Tab 2','woopress').'" tab_id="'.$tab_id_2.'"][/vc_tab]
	      '
	    );
	    vc_map_update('vc_tabs', $setting_vc_tabs);


	    // **********************************************************************//
	    // ! Posts Slider
	    // **********************************************************************//
	    $setting_vc_posts_slider = array (
	      'params' => array(
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Widget title", "woopress"),
	      "param_name" => "title",
	      "description" => esc_html__("What text use as a widget title. Leave blank if no title is needed.", "woopress")
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Slides count", "woopress"),
	      "param_name" => "count",
	      "description" => esc_html__('How many slides to show? Enter number or word "All".', "woopress")
	    ),
	    array(
	      "type" => "posttypes",
	      "heading" => esc_html__("Post types", "woopress"),
	      "param_name" => "posttypes",
	      "description" => esc_html__("Select post types to populate posts from.", "woopress")
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => esc_html__("Layout", "woopress"),
	      "param_name" => "layout",
	      "value" => array( esc_html__("Horizontal", "woopress") => "horizontal", esc_html__("Vertical", "woopress") => "vertical"),
	    ),
            array(
              "type" => "textfield",
              "heading" => esc_html__("Number of items on desktop", 'woopress'),
              "param_name" => "desktop",
            ),
            array(
              "type" => "textfield",
              "heading" => esc_html__("Number of items on notebook", 'woopress'),
              "param_name" => "notebook",
            ),
            array(
              "type" => "textfield",
              "heading" => esc_html__("Number of items on tablet", 'woopress'),
              "param_name" => "tablet",
            ),
            array(
              "type" => "textfield",
              "heading" => esc_html__("Number of items on phones", 'woopress'),
              "param_name" => "phones",
            ),
	    array(
	      "type" => 'checkbox',
	      "heading" => esc_html__("Output post date?", "woopress"),
	      "param_name" => "slides_date",
	      "description" => esc_html__("If selected, date will be printed before the teaser text.", "woopress"),
	      "value" => Array(esc_html__("Yes, please", "woopress") => true)
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => esc_html__("Description", "woopress"),
	      "param_name" => "slides_content",
	      "value" => array(esc_html__("No description", "woopress") => "", esc_html__("Teaser (Excerpt)", "woopress") => "teaser" ),
	      "description" => esc_html__("Some sliders support description text, what content use for it?", "woopress"),
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => esc_html__("Output post title?", "woopress"),
	      "param_name" => "slides_title",
	      "description" => esc_html__("If selected, title will be printed before the teaser text.", "woopress"),
	      "value" => Array(esc_html__("Yes, please", "woopress") => true),
	      "dependency" => Array('element' => "slides_content", 'value' => array('teaser')),
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => esc_html__("Link", "woopress"),
	      "param_name" => "link",
	      "value" => array(esc_html__("Link to post", "woopress") => "link_post", esc_html__("Link to bigger image", "woopress") => "link_image", esc_html__("Open custom link", "woopress") => "custom_link", esc_html__("No link", "woopress") => "link_no"),
	      "description" => esc_html__("Link type.", "woopress")
	    ),
	    array(
	      "type" => "exploded_textarea",
	      "heading" => esc_html__("Custom links", "woopress"),
	      "param_name" => "custom_links",
	      "dependency" => Array('element' => "link", 'value' => 'custom_link'),
	      "description" => esc_html__('Enter links for each slide here. Divide links with linebreaks (Enter).', 'woopress')
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Thumbnail size", "woopress"),
	      "param_name" => "thumb_size",
	      "description" => esc_html__('Enter thumbnail size. Example: 200x100 (Width x Height).', "woopress")
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Post/Page IDs", "woopress"),
	      "param_name" => "posts_in",
	      "description" => esc_html__('Fill this field with page/posts IDs separated by commas (,), to retrieve only them. Use this in conjunction with "Post types" field.', "woopress")
	    ),
	    array(
	      "type" => "exploded_textarea",
	      "heading" => esc_html__("Categories", "woopress"),
	      "param_name" => "categories",
	      "description" => esc_html__("If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter).", "woopress")
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => esc_html__("Order by", "woopress"),
	      "param_name" => "orderby",
	      "value" => array( "", esc_html__("Date", "woopress") => "date", esc_html__("ID", "woopress") => "ID", esc_html__("Author", "woopress") => "author", esc_html__("Title", "woopress") => "title", esc_html__("Modified", "woopress") => "modified", esc_html__("Random", "woopress") => "rand", esc_html__("Comment count", "woopress") => "comment_count", esc_html__("Menu order", "woopress") => "menu_order" ),
	      "description" => sprintf(esc_html__('Select how to sort retrieved posts. More at %s.', 'woopress'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => esc_html__("Order by", "woopress"),
	      "param_name" => "order",
	      "value" => array( esc_html__("Descending", "woopress") => "DESC", esc_html__("Ascending", "woopress") => "ASC" ),
	      "description" => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'woopress'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Extra class name", "woopress"),
	      "param_name" => "el_class",
	      "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress")
	    )
	  )
	    );
	    vc_map_update('vc_posts_slider', $setting_vc_posts_slider);

	    function vc_theme_vc_posts_slider($atts, $content = null) {
	      $output = $title = $type = $count = $interval = $slides_content = $link = '';
	      $custom_links = $thumb_size = $posttypes = $posts_in = $categories = '';
	      $orderby = $order = $el_class = $link_image_start = '';
	      extract(shortcode_atts(array(
                'title' => '',
                'type' => 'flexslider_fade',
                'count' => 10,
                'interval' => 3,
                'layout' => 'horizontal',
                'slides_content' => '',
                'slides_title' => '',
                'link' => 'link_post',
                'more_link' => 1,
                'custom_links' => site_url().'/',
                'thumb_size' => '300x200',
                'posttypes' => '',
                'posts_in' => '',
                'slides_date' => false,
                'categories' => '',
                'orderby' => NULL,
                'order' => 'DESC',
                'el_class' => '',
                'desktop' => 3,
                'notebook' => 3,
                'tablet' => 2,
                'phones' => 1
	      ), $atts));

	      $gal_images = '';
	      $link_start = '';
	      $link_end = '';
	      $el_start = '';
	      $el_end = '';
	      $slides_wrap_start = '';
	      $slides_wrap_end = '';

	      $el_class = ' '.$el_class.' ';

	      $query_args = array();

	      //exclude current post/page from query
	      if ( $posts_in == '' ) {
	          global $post;
	          $query_args['post__not_in'] = array($post->ID);
	      }
	      else if ( $posts_in != '' ) {
	          $query_args['post__in'] = explode(",", $posts_in);
	      }

	      // Post teasers count
	      if ( $count != '' && !is_numeric($count) ) $count = -1;
	      if ( $count != '' && is_numeric($count) ) $query_args['posts_per_page'] = $count;

	      // Post types
	      $pt = array();
	      if ( $posttypes != '' ) {
	          $posttypes = explode(",", $posttypes);
	          foreach ( $posttypes as $post_type ) {
	              array_push($pt, $post_type);
	          }
	          $query_args['post_type'] = $pt;
	      }

	      // Narrow by categories
	      if ( $categories != '' ) {
	          $categories = explode(",", $categories);
	          $gc = array();
	          foreach ( $categories as $grid_cat ) {
	              array_push($gc, $grid_cat);
	          }
	          $gc = implode(",", $gc);
	          ////http://snipplr.com/view/17434/wordpress-get-category-slug/
	          $query_args['category_name'] = $gc;

	          $taxonomies = get_taxonomies('', 'object');
	          $query_args['tax_query'] = array('relation' => 'OR');
	          foreach ( $taxonomies as $t ) {
	              if ( in_array($t->object_type[0], $pt) ) {
	                  $query_args['tax_query'][] = array(
	                      'taxonomy' => $t->name,//$t->name,//'portfolio_category',
	                      'terms' => $categories,
	                      'field' => 'slug',
	                  );
	              }
	          }
	      }

	      // Order posts
	      if ( $orderby != NULL ) {
	          $query_args['orderby'] = $orderby;
	      }
	      $query_args['order'] = $order;

	      $thumb_size = explode('x', $thumb_size);
	      $width = $thumb_size[0];
	      $height = $thumb_size[1];

	      $crop = true;

			$customItems = array(
			    'desktop' => $desktop,
			    'notebook' => $notebook,
			    'tablet' => $tablet,
			    'phones' => $phones
			);

	      ob_start();
	      etheme_create_posts_slider($query_args, $title, $more_link, $slides_date, $slides_content, $width, $height, $crop, $layout, $customItems, $el_class );
	      $output = ob_get_contents();
	      ob_end_clean();

	      return $output;
	    }



	    // **********************************************************************//
	    // ! Button
	    // **********************************************************************//
	    $setting_vc_button = array (
	      "params" => array(
	          array(
	            "type" => "textfield",
	            "heading" => esc_html__("Text on the button", "woopress"),
	            "holder" => "button",
	            "class" => "wpb_button",
	            "param_name" => "title",
	            "value" => esc_html__("Text on the button", "woopress"),
	            "description" => esc_html__("Text on the button.", "woopress")
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => esc_html__("URL (Link)", "woopress"),
	            "param_name" => "href",
	            "description" => esc_html__("Button link.", "woopress")
	          ),
	          array(
	            "type" => "dropdown",
	            "heading" => esc_html__("Target", "woopress"),
	            "param_name" => "target",
	            "value" => $target_arr,
	            "dependency" => Array('element' => "href", 'not_empty' => true)
	          ),
	          array(
	            "type" => "dropdown",
	            "heading" => esc_html__("Type", "woopress"),
	            "param_name" => "type",
	            "value" => array('bordered', 'filled'),
	            "description" => esc_html__("Button type.", "woopress")
	          ),
				array(
					'type' => 'icon',
					"heading" => esc_html__("Icon", 'woopress'),
					"param_name" => "icon"
				),
	          array(
	            "type" => "dropdown",
	            "heading" => esc_html__("Size", "woopress"),
	            "param_name" => "size",
	            "value" => array('small','medium','big'),
	            "description" => esc_html__("Button size.", "woopress")
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => esc_html__("Extra class name", "woopress"),
	            "param_name" => "el_class",
	            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress")
	          )
	        )
	    );
	    vc_map_update('vc_button', $setting_vc_button);

	    function vc_theme_vc_button($atts, $content = null) {
	    	if ( ! woopress_plugin_notice() ) {
	    		return etheme_btn_shortcode($atts, $content);
	    	}
	    }


	    // **********************************************************************//
	    // ! Call To Action
	    // **********************************************************************//
	    $setting_cta_button = array (
	      "params" => array(
	          array(
	            "type" => "textarea_html",
	            "heading" => esc_html__("Text", "woopress"),
	            "param_name" => "content",
	            "value" => esc_html__("Click edit button to change this text.", "woopress"),
	            "description" => esc_html__("Enter your content.", "woopress")
	          ),
	          array(
	            "type" => "dropdown",
	            "heading" => esc_html__("Block Style", "woopress"),
	            "param_name" => "style",
	            "value" => array(
	              "" => "",
	              esc_html__("Default", "woopress") => "default",
	              esc_html__("Full width", "woopress") => "fullwidth",
	              esc_html__("Filled", "woopress") => "filled",
	              esc_html__("Without Border", "woopress") => "without-border",
	              esc_html__("Dark", "woopress") => "dark"
	            )
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => esc_html__("Text on the button", "woopress"),
	            "param_name" => "title",
	            "description" => esc_html__("Text on the button.", "woopress")
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => esc_html__("URL (Link)", "woopress"),
	            "param_name" => "href",
	            "description" => esc_html__("Button link.", "woopress")
	          ),
	          array(
	            "type" => "dropdown",
	            "heading" => esc_html__("Button position", "woopress"),
	            "param_name" => "position",
	            "value" => array(esc_html__("Align right", "woopress") => "right", esc_html__("Align left", "woopress") => "left"),
	            "description" => esc_html__("Select button alignment.", "woopress")
	          )
	        )
	    );
	    vc_map_update('vc_cta_button', $setting_cta_button);

	    function vc_theme_vc_cta_button($atts, $content = null) {
	      $output = $call_title = $href = $title = $call_text = $el_class = '';
	      extract(shortcode_atts(array(
	          'href' => '',
	          'style' => '',
	          'title' => '',
	          'position' => 'right'
	      ), $atts));

	      return do_shortcode('[callto btn_position="'.$position.'" btn="'.$title.'" style="'.$style.'" link="'.$href.'"]'.$content.'[/callto]');
	    }

	    // **********************************************************************//
	    // ! Teaser grid
	    // **********************************************************************//
		$setting_vc_posts_grid = array(
		  "params" => array(
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Widget title", "woopress"),
		      "param_name" => "title",
		      "description" => esc_html__("What text use as a widget title. Leave blank if no title is needed.", "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Columns count", "woopress"),
		      "param_name" => "grid_columns_count",
		      "value" => array( 4, 3, 2, 1),
		      "admin_label" => true,
		      "description" => esc_html__("Select columns count.", "woopress")
		    ),
		    array(
		      "type" => "posttypes",
		      "heading" => esc_html__("Post types", "woopress"),
		      "param_name" => "grid_posttypes",
		      "description" => esc_html__("Select post types to populate posts from.", "woopress")
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Teasers count", "woopress"),
		      "param_name" => "grid_teasers_count",
		      "description" => esc_html__('How many teasers to show? Enter number or word "All".', "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Pagination", "woopress"),
		      "param_name" => "pagination",
		      "value" => array(esc_html__("Show Pagination", "woopress") => "show", esc_html__("Hide", "woopress") => "hide")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Content", "woopress"),
		      "param_name" => "grid_content",
		      "value" => array(esc_html__("Teaser (Excerpt)", "woopress") => "teaser", esc_html__("Full Content", "woopress") => "content"),
		      "description" => esc_html__("Teaser layout template.", "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("'Posted by' block", "woopress"),
		      "param_name" => "posted_block",
		      "value" => array(esc_html__("Show", "woopress") => "show", esc_html__("Hide", "woopress") => "hide")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Hover mask", "woopress"),
		      "param_name" => "hover_mask",
		      "value" => array(esc_html__("Show", "woopress") => "show", esc_html__("Hide", "woopress") => "hide")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Layout", "woopress"),
		      "param_name" => "grid_layout",
		      "value" => array(esc_html__("Title + Thumbnail + Text", "woopress") => "title_thumbnail_text", esc_html__("Thumbnail + Title + Text", "woopress") => "thumbnail_title_text", esc_html__("Thumbnail + Text", "woopress") => "thumbnail_text", esc_html__("Thumbnail + Title", "woopress") => "thumbnail_title", esc_html__("Thumbnail only", "woopress") => "thumbnail", esc_html__("Title + Text", "woopress") => "title_text"),
		      "description" => esc_html__("Teaser layout.", "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Teaser grid layout", "woopress"),
		      "param_name" => "grid_template",
		      "value" => array(esc_html__("Grid", "woopress") => "grid", esc_html__("Grid with filter", "woopress") => "filtered_grid"),
		      "description" => esc_html__("Teaser layout template.", "woopress")
		    ),
		    array(
		      "type" => "taxonomies",
		      "heading" => esc_html__("Taxonomies", "woopress"),
		      "param_name" => "grid_taxomonies",
		      "dependency" => Array('element' => 'grid_template' /*, 'not_empty' => true*/, 'value' => array('filtered_grid'), 'callback' => 'wpb_grid_post_types_for_taxonomies_handler'),
		      "description" => esc_html__("Select taxonomies from.", "woopress") //TODO: Change description
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Thumbnail size", "woopress"),
		      "param_name" => "grid_thumb_size",
		      "description" => esc_html__('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height).', "woopress")
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Post/Page IDs", "woopress"),
		      "param_name" => "posts_in",
		      "description" => esc_html__('Fill this field with page/posts IDs separated by commas (,) to retrieve only them. Use this in conjunction with "Post types" field.', "woopress")
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Exclude Post/Page IDs", "woopress"),
		      "param_name" => "posts_not_in",
		      "description" => esc_html__('Fill this field with page/posts IDs separated by commas (,) to exclude them from query.', "woopress")
		    ),
		    array(
		      "type" => "exploded_textarea",
		      "heading" => esc_html__("Categories", "woopress"),
		      "param_name" => "grid_categories",
		      "description" => esc_html__("If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter).", "woopress")
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Order by", "woopress"),
		      "param_name" => "orderby",
		      "value" => array( "", esc_html__("Date", "woopress") => "date", esc_html__("ID", "woopress") => "ID", esc_html__("Author", "woopress") => "author", esc_html__("Title", "woopress") => "title", esc_html__("Modified", "woopress") => "modified", esc_html__("Random", "woopress") => "rand", esc_html__("Comment count", "woopress") => "comment_count", esc_html__("Menu order", "woopress") => "menu_order" ),
		      "description" => sprintf(esc_html__('Select how to sort retrieved posts. More at %s.', 'woopress'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Order way", "woopress"),
		      "param_name" => "order",
		      "value" => array( esc_html__("Descending", "woopress") => "DESC", esc_html__("Ascending", "woopress") => "ASC" ),
		      "description" => sprintf(esc_html__('Designates the ascending or descending order. More at %s.', 'woopress'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Extra class name", "woopress"),
		      "param_name" => "el_class",
		      "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress")
		    )
		  )
		);

	    vc_map_update('vc_posts_grid', $setting_vc_posts_grid);

	    function vc_theme_vc_posts_grid($atts, $content = null) {
	      return etheme_teaser($atts, $content = null);
	    }

	    // **********************************************************************//
	    // ! Video player
	    // **********************************************************************//
	    $setting_video = array (
		    "params" => array(
		      array(
		        "type" => "textfield",
		        "heading" => esc_html__("Widget title", "woopress"),
		        "param_name" => "title",
		        "description" => esc_html__("Enter text which will be used as widget title. Leave blank if no title is needed.", "woopress")
		      ),
		      array(
		        "type" => "textfield",
		        "heading" => esc_html__("Video link", "woopress"),
		        "param_name" => "link",
		        "admin_label" => true,
		        "description" => sprintf(esc_html__('Link to the video. More about supported formats at %s.', "woopress"), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>')
		      ),
		    array(
		      "type" => "dropdown",
		      "heading" => esc_html__("Open in popup", "woopress"),
		      "param_name" => "popup",
		      "value" => array( "", esc_html__("Yes", "woopress") => "yes", esc_html__("No", "woopress") => "no"),

		    ),

	        array(
	          'type' => 'attach_image',
	          "heading" => esc_html__("Image placeholder", 'woopress'),
	          "dependency" => Array('element' => "popup", 'value' => array('yes')),
	          "param_name" => "img"
	        ),

		    array(
		      "type" => "textfield",
		      "heading" => esc_html__("Image size", "woopress"),
		      "param_name" => "img_size",
	          "dependency" => Array('element' => "popup", 'value' => array('yes')),
		      "description" => esc_html__("Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size.", "woopress")
		    ),
		      array(
		        "type" => "textfield",
		        "heading" => esc_html__("Extra class name", "woopress"),
		        "param_name" => "el_class",
		        "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress")
		      ),
		      array(
		        "type" => "css_editor",
		        "heading" => esc_html__('Css', "woopress"),
		        "param_name" => "css",
		        // "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "woopress"),
		        "group" => esc_html__('Design options', 'woopress')
		      )
		    )
	    );
	    vc_map_update('vc_video', $setting_video);

	    function vc_theme_vc_video($atts) {
			$output = $title = $link = $size = $el_class = $img_src = '';
			extract(shortcode_atts(array(
				'title' => '',
				'link' => 'http://vimeo.com/23237102',
				'size' => ( isset($content_width) ) ? $content_width : 500,
				'popup' => 'no',
				'img' => '',
				'img_size' => '300x200',
				'el_class' => '',
			  'css' => ''

			), $atts));

			if ( $link == '' ) { return null; }

		    $src_img = '';

		    if($popup == 'yes') {
			    $img_size = explode('x', $img_size);

				if ( ! in_array( $img_size[0], array( "thumbnail", "medium", "large", "full" ))) {

				    $width = $img_size[0];
				    $height = $img_size[1];

				    if($img != '') {
				        $src = etheme_get_image($img, $width, $height);
				        $src_img = $src;
				    }elseif ($img_src != '') {
				        $src = do_shortcode($img_src);
				        $src_img = $src;
				    }
			   }
			   else {
			   	$src = wp_get_attachment_image_src( $img, $img_size[0]);
			   	$src_img = $src[0];
			   }
			    $text = esc_html__('Show video', 'woopress');
			    if($src_img != '') {
				    $text = '<img src="'. $src_img .'">';
			    }
		    }

			$video_w = ( isset($content_width) ) ? $content_width : 500;
			$video_h = $video_w/1.61; //1.61 golden ratio
			global $wp_embed;
			$embed = $wp_embed->run_shortcode('[embed width="'.$video_w.'"'.$video_h.']'.$link.'[/embed]');

			$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_video_widget wpb_content_element'.$el_class.$el_class.vc_shortcode_custom_css_class($css, ' '), 'vc_video');
			$rand = rand(1000,9999);
			$css_class .= ' video-'.$rand;


			$output .= "\n\t".'<div class="'.$css_class.'">';
			    $output .= "\n\t\t".'<div class="wpb_wrapper">';
			        $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_video_heading'));
					if($popup == 'yes') {
						$output .= '<a href="#" class="open-video-popup">'.$text.'</a>';
					    $output .= "\n\t".'<script type="text/javascript">';
					    $output .= "\n\t\t".'jQuery(document).ready(function() {
						    jQuery(".video-'.$rand.' .open-video-popup").magnificPopup({
							    items: [
							      {
							        src: "'.$link.'",
							        type: "iframe"
							      },
							    ],
						    });
					    });';
				    	$output .= "\n\t".'</script> ';
					} else {
			        	$output .= '<div class="wpb_video_wrapper">' . $embed . '</div>';
					}
		        $output .= "\n\t\t".'</div> ';
		    $output .= "\n\t".'</div> ';

			return $output;
	    }

	}
}
