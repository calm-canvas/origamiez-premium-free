<time class="updated metadata-date"
      datetime="<?php echo esc_attr( get_post_field( 'post_date_gmt', get_the_ID() ) ); ?>">
	<?php origamiez_get_metadata_prefix(); ?>
	<?php echo esc_html( get_the_date() ); ?>
</time>