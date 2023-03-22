<?php
$client_id = ( isset( $attributes['accordionItemID'] ) ) ? $attributes['accordionItemID'] : null;

if ( empty( $client_id ) ) {
	return;
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<h3>
		<button
			type="button"
			id="accordion-item-btn-<?php echo esc_attr( $client_id ); ?>"
			class="accordion-trigger"
			aria-controls="accordion-item-content-<?php echo esc_attr( $client_id ); ?>"
			aria-expanded="false"
		>
			<span class="accordion-title"><?php echo wp_kses_post( $attributes['title'] ); ?></span>
		</button>
	</h3>
	<div id="accordion-item-content-<?php echo esc_attr( $client_id ); ?>" role="region" aria-labelledby="accordion-item-btn-<?php echo esc_attr( $client_id ); ?>" class="accordion-panel clear-fix" hidden="">
		<?php
		echo wp_kses_post( $content );
		?>
	</div>
</div>
<?php
