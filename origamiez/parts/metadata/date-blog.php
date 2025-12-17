<time class="updated metadata-date"
		datetime="<?php echo esc_attr( get_post_field( 'post_date_gmt', get_the_ID() ) ); ?>">
	<i class="fa fa-calendar-o"></i>
	<?php echo esc_html( get_the_date() ); ?>
</time>
