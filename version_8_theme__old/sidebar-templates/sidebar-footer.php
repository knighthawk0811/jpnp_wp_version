<?php
/**
 * Sidebar - footer.
 *
 * @package version_8_child
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
	<?php dynamic_sidebar( 'sidebar-footer' ); ?>
<?php endif; ?>