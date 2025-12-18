<?php

function origamiez_get_format_icon( $format ) {
	return \Origamiez\Engine\Helpers\FormatHelper::get_format_icon( $format );
}

function origamiez_get_breadcrumb() {
	do_action( 'origamiez_print_breadcrumb' );
}

function origamiez_top_bar_enable_callback() {
	return get_theme_mod( 'is_display_top_bar', 1 );
}

function origamiez_skin_custom_callback( $control ) {
	if ( 'custom' === $control->manager->get_setting( 'skin' )->value() ) {
		return true;
	} else {
		return false;
	}
}
function origamiez_font_body_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_body_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_menu_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_menu_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_site_title_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_site_title_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_site_subtitle_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_site_subtitle_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_widget_title_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_widget_title_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_h1_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_h1_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_h2_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_h2_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_h3_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_h3_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_h4_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_h4_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_h5_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_h5_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_font_h6_enable_callback( $control ) {
	if ( 1 === (int) $control->manager->get_setting( 'font_h6_is_enable' )->value() ) {
		return true;
	} else {
		return false;
	}
}

function origamiez_list_comments( $comment, $args, $depth ) {
	$display = new \Origamiez\Engine\Display\CommentDisplay( $comment, $args, $depth );
	$display->display();
}

function origamiez_comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}
	$form = new \Origamiez\Engine\Display\CommentFormBuilder( $post_id, $args );
	$form->display();
}

function origamiez_get_author_infor() {
	global $post;
	$user_id     = $post->post_author;
	$description = get_the_author_meta( 'description', $user_id );
	$email       = get_the_author_meta( 'user_email', $user_id );
	$name        = get_the_author_meta( 'display_name', $user_id );
	$url         = trim( get_the_author_meta( 'user_url', $user_id ) );
	$link        = ! $url ? get_author_posts_url( $user_id ) : $url;
	?>
	<div id="origamiez-post-author">
		<div class="origamiez-author-info clearfix">
			<a href="<?php echo esc_url( $link ); ?>" class="origamiez-author-avatar">
				<?php echo wp_kses( get_avatar( $email, 90 ), origamiez_get_allowed_tags() ); ?>
			</a>
			<div class="origamiez-author-detail">
				<p class="origamiez-author-name"><?php esc_html_e( 'Author:', 'origamiez' ); ?>&nbsp;<a
							href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $name ); ?></a></p>
				<p class="origamiez-author-bio"><?php echo wp_kses( $description, origamiez_get_allowed_tags() ); ?></p>
			</div>
		</div>
	</div>
	<?php
}

function origamiez_get_socials() {
	return array(
		'behance'        => array(
			'icon'  => 'fa-brands fa-behance',
			'label' => esc_attr__( 'Behance', 'origamiez' ),
			'color' => '#1769ff',
		),
		'bitbucket'      => array(
			'icon'  => 'fa-brands fa-bitbucket',
			'label' => esc_attr__( 'Bitbucket', 'origamiez' ),
			'color' => '#0052cc',
		),
		'codepen'        => array(
			'icon'  => 'fa-brands fa-codepen',
			'label' => esc_attr__( 'Codepen', 'origamiez' ),
			'color' => '#000000',
		),
		'delicious'      => array(
			'icon'  => 'fa-brands fa-delicious',
			'label' => esc_attr__( 'Delicious', 'origamiez' ),
			'color' => '#3399ff',
		),
		'deviantart'     => array(
			'icon'  => 'fa-brands fa-deviantart',
			'label' => esc_attr__( 'Deviantart', 'origamiez' ),
			'color' => '#05cc47',
		),
		'digg'           => array(
			'icon'  => 'fa-brands fa-digg',
			'label' => esc_attr__( 'Digg', 'origamiez' ),
			'color' => '#1b5891',
		),
		'dribbble'       => array(
			'icon'  => 'fa-brands fa-dribbble',
			'label' => esc_attr__( 'Dribbble', 'origamiez' ),
			'color' => '#ea4c89',
		),
		'dropbox'        => array(
			'icon'  => 'fa-brands fa-dropbox',
			'label' => esc_attr__( 'Dropbox', 'origamiez' ),
			'color' => '#0061ff',
		),
		'facebook'       => array(
			'icon'  => 'fa-brands fa-facebook',
			'label' => esc_attr__( 'Facebook', 'origamiez' ),
			'color' => '#1877f2',
		),
		'flickr'         => array(
			'icon'  => 'fa-brands fa-flickr',
			'label' => esc_attr__( 'Flickr', 'origamiez' ),
			'color' => '#0063dc',
		),
		'foursquare'     => array(
			'icon'  => 'fa-brands fa-foursquare',
			'label' => esc_attr__( 'Foursquare', 'origamiez' ),
			'color' => '#fa7343',
		),
		'git'            => array(
			'icon'  => 'fa-brands fa-git',
			'label' => esc_attr__( 'Git', 'origamiez' ),
			'color' => '#f1502f',
		),
		'github'         => array(
			'icon'  => 'fa-brands fa-github',
			'label' => esc_attr__( 'Github', 'origamiez' ),
			'color' => '#333333',
		),
		'google-plus'    => array(
			'icon'  => 'fa-brands fa-google-plus',
			'label' => esc_attr__( 'Google plus', 'origamiez' ),
			'color' => '#ea4335',
		),
		'instagram'      => array(
			'icon'  => 'fa-brands fa-instagram',
			'label' => esc_attr__( 'Instagram', 'origamiez' ),
			'color' => '#e4405f',
		),
		'jsfiddle'       => array(
			'icon'  => 'fa-brands fa-jsfiddle',
			'label' => esc_attr__( 'JsFiddle', 'origamiez' ),
			'color' => '#007bb6',
		),
		'linkedin'       => array(
			'icon'  => 'fa-brands fa-linkedin',
			'label' => esc_attr__( 'linkedin', 'origamiez' ),
			'color' => '#0a66c2',
		),
		'pinterest'      => array(
			'icon'  => 'fa-brands fa-pinterest',
			'label' => esc_attr__( 'Pinterest', 'origamiez' ),
			'color' => '#e60023',
		),
		'reddit'         => array(
			'icon'  => 'fa-brands fa-reddit',
			'label' => esc_attr__( 'Reddit', 'origamiez' ),
			'color' => '#ff4500',
		),
		'soundcloud'     => array(
			'icon'  => 'fa-brands fa-soundcloud',
			'label' => esc_attr__( 'Soundcloud', 'origamiez' ),
			'color' => '#ff5500',
		),
		'spotify'        => array(
			'icon'  => 'fa-brands fa-spotify',
			'label' => esc_attr__( 'Spotify', 'origamiez' ),
			'color' => '#1db954',
		),
		'stack-exchange' => array(
			'icon'  => 'fa-brands fa-stack-exchange',
			'label' => esc_attr__( 'Stack exchange', 'origamiez' ),
			'color' => '#f48024',
		),
		'stack-overflow' => array(
			'icon'  => 'fa-brands fa-stack-overflow',
			'label' => esc_attr__( 'Stack overflow', 'origamiez' ),
			'color' => '#f48024',
		),
		'stumbleupon'    => array(
			'icon'  => 'fa-brands fa-stumbleupon',
			'label' => esc_attr__( 'Stumbleupon', 'origamiez' ),
			'color' => '#eb4823',
		),
		'tumblr'         => array(
			'icon'  => 'fa-brands fa-tumblr',
			'label' => esc_attr__( 'Tumblr', 'origamiez' ),
			'color' => '#36465d',
		),
		'twitter'        => array(
			'icon'  => 'fa-brands fa-twitter',
			'label' => esc_attr__( 'Twitter', 'origamiez' ),
			'color' => '#1da1f2',
		),
		'vimeo'          => array(
			'icon'  => 'fa-brands fa-vimeo-square',
			'label' => esc_attr__( 'Vimeo', 'origamiez' ),
			'color' => '#1ab7ea',
		),
		'youtube'        => array(
			'icon'  => 'fa-brands fa-youtube',
			'label' => esc_attr__( 'Youtube', 'origamiez' ),
			'color' => '#ff0000',
		),
		'rss'            => array(
			'icon'  => 'fa-brands fa-rss',
			'label' => esc_attr__( 'Rss', 'origamiez' ),
			'color' => '#FA9B39',
		),
	);
}

function origamiez_get_str_uglify( $string ) {
	$string = preg_replace( '/\s+/', ' ', $string );
	$string = preg_replace( '/[^a-zA-Z0-9\s]/', '', $string );

	return strtolower( str_replace( ' ', '_', $string ) );
}











function origamiez_get_metadata_prefix( $echo = true ) {
	$prefix = apply_filters( 'origamiez_get_metadata_prefix', '&horbar;' );
	if ( $echo ) {
		echo $prefix;
	} else {
		return $prefix;
	}
}

function origamiez_return_10() {
	return 10;
}

function origamiez_return_15() {
	return 15;
}

function origamiez_return_20() {
	return 20;
}

function origamiez_return_30() {
	return 30;
}

function origamiez_return_60() {
	return 60;
}

function origamiez_set_classes_for_footer_three_cols( $classes ) {
	return array( 'col-xs-12', 'col-sm-4', 'col-md-4' );
}

function origamiez_set_classes_for_footer_two_cols( $classes ) {
	return array( 'col-xs-12', 'col-sm-6', 'col-md-6' );
}

function origamiez_set_classes_for_footer_one_cols( $classes ) {
	return array( 'col-xs-12', 'col-sm-12', 'col-md-12' );
}

function origamiez_get_allowed_tags() {
	$allowed_tag                              = wp_kses_allowed_html( 'post' );
	$allowed_tag['div']['data-place']         = array();
	$allowed_tag['div']['data-latitude']      = array();
	$allowed_tag['div']['data-longitude']     = array();
	$allowed_tag['iframe']['src']             = array();
	$allowed_tag['iframe']['height']          = array();
	$allowed_tag['iframe']['width']           = array();
	$allowed_tag['iframe']['frameborder']     = array();
	$allowed_tag['iframe']['allowfullscreen'] = array();
	$allowed_tag['input']['class']            = array();
	$allowed_tag['input']['id']               = array();
	$allowed_tag['input']['name']             = array();
	$allowed_tag['input']['value']            = array();
	$allowed_tag['input']['type']             = array();
	$allowed_tag['input']['checked']          = array();
	$allowed_tag['select']['class']           = array();
	$allowed_tag['select']['id']              = array();
	$allowed_tag['select']['name']            = array();
	$allowed_tag['select']['value']           = array();
	$allowed_tag['select']['type']            = array();
	$allowed_tag['option']['selected']        = array();
	$allowed_tag['style']['types']            = array();
	$microdata_tags                           = array(
		'div',
		'section',
		'article',
		'a',
		'span',
		'img',
		'time',
		'figure',
	);
	foreach ( $microdata_tags as $tag ) {
		$allowed_tag[ $tag ]['itemscope'] = array();
		$allowed_tag[ $tag ]['itemtype']  = array();
		$allowed_tag[ $tag ]['itemprop']  = array();
	}

	return apply_filters( 'origamiez_get_allowed_tags', $allowed_tag );
}

function origamiez_get_button_readmore() {
	do_action( 'origamiez_print_button_readmore' );
}

function origamiez_save_unyson_options( $option_key, $old_value, $new_value ) {
	if ( 'fw_theme_settings_options:origamiez' === $option_key ) {
		if ( is_array( $old_value ) && is_array( $new_value ) ) {
			foreach ( $new_value as $key => $value ) {
				if ( $key == 'logo' ) {
					if ( isset( $value['url'] ) && isset( $value['attachment_id'] ) ) {
						$value = esc_url( $value['url'] );
					}
				}
				set_theme_mod( $key, $value );
			}
		}
	}
}

/**
 * Security Functions
 */

/**
 * Verify search form nonce
 */
function origamiez_verify_search_nonce() {
}

/**
 * Sanitize and validate search query
 */
function origamiez_sanitize_search_query( $query ) {
}



/**
 * Sanitize checkbox input
 */
function origamiez_sanitize_checkbox( $input ) {
	return ( isset( $input ) && true === (bool) $input ) ? true : false;
}

/**
 * Sanitize select input
 */
function origamiez_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


/**
 * Add security headers
 */
function origamiez_add_security_headers() {
}


/**
 * Track failed login attempts
 */
function origamiez_track_failed_login( $username ) {
}

/**
 * Clear login attempts on successful login
 */
function origamiez_clear_login_attempts( $user_login ) {
}


/**
 * Sanitize database inputs
 */
function origamiez_sanitize_db_input( $input, $type = 'text' ) {
	switch ( $type ) {
		case 'int':
			return absint( $input );
		case 'float':
			return floatval( $input );
		case 'email':
			return sanitize_email( $input );
		case 'url':
			return esc_url_raw( $input );
		case 'key':
			return sanitize_key( $input );
		default:
			return sanitize_text_field( $input );
	}
}

/**
 * Get available font families for customizer
 */
function origamiez_get_font_families() {
	return array(
		'Arial, sans-serif'                                  => 'Arial',
		'"Trebuchet MS", Helvetica, sans-serif'              => 'Trebuchet MS',
		'"Times New Roman", Times, serif'                    => 'Times New Roman',
		'Georgia, serif'                                     => 'Georgia',
		'"Courier New", Courier, monospace'                  => 'Courier New',
		'Verdana, Geneva, sans-serif'                        => 'Verdana',
		'"Comic Sans MS", cursive, sans-serif'               => 'Comic Sans MS',
		'Garamond, serif'                                    => 'Garamond',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino',
		'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif' => 'System Default',
	);
}

/**
 * Get available font sizes for customizer
 */
function origamiez_get_font_sizes() {
	return array(
		'12px' => '12px',
		'14px' => '14px',
		'16px' => '16px',
		'18px' => '18px',
		'20px' => '20px',
		'24px' => '24px',
		'28px' => '28px',
		'32px' => '32px',
	);
}

/**
 * Get available font styles for customizer
 */
function origamiez_get_font_styles() {
	return array(
		'normal' => esc_attr__( 'Normal', 'origamiez' ),
		'italic' => esc_attr__( 'Italic', 'origamiez' ),
		'oblique' => esc_attr__( 'Oblique', 'origamiez' ),
	);
}

/**
 * Get available font weights for customizer
 */
function origamiez_get_font_weights() {
	return array(
		'100' => '100 (Thin)',
		'200' => '200 (Extra Light)',
		'300' => '300 (Light)',
		'400' => '400 (Normal)',
		'500' => '500 (Medium)',
		'600' => '600 (Semi Bold)',
		'700' => '700 (Bold)',
		'800' => '800 (Extra Bold)',
		'900' => '900 (Black)',
	);
}

/**
 * Get available line heights for customizer
 */
function origamiez_get_font_line_heighs() {
	return array(
		'1' => '1',
		'1.2' => '1.2',
		'1.5' => '1.5',
		'1.6' => '1.6',
		'1.8' => '1.8',
		'2' => '2',
	);
}
