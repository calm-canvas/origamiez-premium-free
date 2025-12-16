<?php
if ( 1 === (int) get_theme_mod( 'is_show_post_author_info', 1 ) ) {
	( new \Origamiez\Engine\Display\AuthorDisplay() )->display();
}
