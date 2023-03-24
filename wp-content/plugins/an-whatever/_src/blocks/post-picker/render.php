<?php
if ( ! isset( $attributes['postListId'] ) || ! isset( $attributes['postList'] ) || empty( $attributes['postList'] ) ) {
	return;
}
?>

<section <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<?php
	$current_post_id = get_the_ID();

	foreach ( $attributes['postList'] as $key => $post_list_id ) {
		if ( (int) $current_post_id === (int) $post_list_id ) {
			// We don't want an endless loop.
			continue;
		}

		$item_id = $post_list_id . '-' . $attributes['postListId'];
		?>
		<div class="accordion-item">
			<h3>
				<button
					type="button"
					id="accordion-item-btn-<?php echo esc_attr( $item_id ); ?>"
					class="accordion-trigger"
					aria-controls="accordion-item-content-<?php echo esc_attr( $item_id ); ?>"
					aria-expanded="false"
				>
					<span class="accordion-title"><?php echo wp_kses_post( get_the_title( (int) $post_list_id ) ); ?></span>
				</button>
			</h3>
			<div id="accordion-item-content-<?php echo esc_attr( $item_id ); ?>" role="region" aria-labelledby="accordion-item-btn-<?php echo esc_attr( $item_id ); ?>" class="accordion-panel clear-fix" hidden="">
				<?php
				echo wp_kses_post( apply_filters( 'the_content', get_the_content( null, false, (int) $post_list_id ) ) );
				?>
			</div>
		</div>
		<?php
	}
	?>
</section>
