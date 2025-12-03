<?php


if(class_exists('bbPress')){

  function origamiez_bbpress_register_sidebar() {
    register_sidebar(array(
        'id'            => 'bbpress_right_sidebar',
        'name'          => esc_attr__('Right (bbPress)', 'origamiez'),
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget origamiez-bbpress-widget %2$s">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h2 class="widget-title clearfix"><span class="widget-title-text pull-left">',
        'after_title'   => '</span></h2><div class="origamiez-widget-content clearfix">'
    ));
  }

  add_action('init', 'origamiez_bbpress_register_sidebar', 40);
  add_action('after_setup_theme', 'origamiez_bbpress_theme_setup', 5);

  function origamiez_bbpress_theme_setup() {
  	if (!is_admin()) {
  		add_filter('origamiez_get_current_sidebar', 'origamiez_bbpress_set_sidebar', 20, 2);
  		add_filter('body_class', 'origamiez_bbpress_body_class');

      add_filter('bbp_get_reply_content', 'origamiez_bbpress_shortcodes', 10, 2);
      add_filter('bbp_get_topic_content', 'origamiez_bbpress_shortcodes', 10, 2);
  	}
  }

  function origamiez_bbpress_shortcodes( $content, $reply_id ) { 
    $reply_author = bbp_get_reply_author_id( $reply_id );
    
    if(user_can( $reply_author, 'publish_forums')){
      $content = do_shortcode( $content );
    }
      
    return $content;
  }

  function origamiez_bbpress_set_sidebar($sidebar, $position){
  	if('right' == $position){
  		global $post;					
  		$tax = get_queried_object();	
  		
  		if(is_singular('topic') || 
  		is_singular('forum') || 
  		is_post_type_archive('forum') || 
  		is_post_type_archive('topic') || 
  		(isset($tax->taxonomy) && in_array($tax->taxonomy, array('topic-tag'))) ||
  		bbp_is_search()
  		){
  			$sidebar = 'bbpress_right_sidebar';			
  		}		
  	}	

  	return $sidebar;
  }

  function origamiez_bbpress_body_class($classes){
  	global $post;					

  	$tax = get_queried_object();	
  	$query_action =  isset($_REQUEST['action']) ? $_REQUEST['action'] : NULL;

  	if(is_singular('topic') || 
  		is_singular('forum') || 
  		is_post_type_archive('forum') || 
  		is_post_type_archive('topic') || 
  		(isset($tax->taxonomy) && in_array($tax->taxonomy, array('topic-tag'))) ||
  		bbp_is_search()
  		){
  		array_push($classes, 'origamiez-layout-right-sidebar', 'origamiez-layout-single');
  	}

  	return $classes;
  }

}