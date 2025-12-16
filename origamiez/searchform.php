<form method="get" id="search-form" class="search-form clearfix" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php wp_nonce_field( 'origamiez_search_form_nonce', 'search_nonce' ); ?>
	<input autocomplete="off" type="text" value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Enter your keyword...', 'origamiez' ); ?>" name="s" class="search-text"
			maxlength="20">
	<button type="submit" class="search-submit"><span class="fa fa-search"></span></button>
</form>
