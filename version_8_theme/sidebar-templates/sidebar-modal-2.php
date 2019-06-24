<?php
/**
 * Sidebar - modal.
 *
 * @package version_8
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( is_active_sidebar( 'sidebar-modal-2' ) ) : ?>
<div class="sidebar-modal modal-2">
	<?php dynamic_sidebar( 'sidebar-modal-2' ); ?>
</div>
<?php endif; ?>