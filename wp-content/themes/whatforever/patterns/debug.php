<?php
/**
 * Title: Debug block pattern
 * Slug: whatforever/debug
 * Categories: featured
 */

use function \An_Tools\h;
?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:html -->
		<?php
		h()->pp( 'Kabooom?.. Whatever Forever...', false, false );
		?>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
