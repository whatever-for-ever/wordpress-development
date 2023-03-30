<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<?php
	printf(
		'<h2>%s</h2>',
		wp_kses_post( get_the_title( $attributes['id'] ) )
	);
	?>
</div>
