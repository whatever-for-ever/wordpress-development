<?php
if ( ! isset( $attributes['postList'] ) || empty( $attributes['postList'] ) ) {
	return;
}
?>

<section <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<ul>
		<?php
		\An_Tools\h()->vep( $attributes, true );
		?>
		<?php
		foreach ( $attributes['postList'] as $key => $post_list_id ) {
			printf(
				'<li><a href="%s">%s</a></li>',
				esc_url( get_the_permalink( $post_list_id ) ),
				wp_kses_post( get_the_title( $post_list_id ) )
			);
		}
		?>
	</ul>
</section>
