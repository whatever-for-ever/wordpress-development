<?php
// phpcs:ignore
wp_enqueue_script( 'an-whatever-accordion-view-script' );
?>
<section <?php echo get_block_wrapper_attributes(); ?>>
	<?php
	echo wp_kses_post( $content );
	?>
</section>
