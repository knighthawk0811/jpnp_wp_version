<?php
/**
 * Sidebar - template.
 *
 * @package version_8_child
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
	<?php dynamic_sidebar( 'sidebar-left' ); ?>
<?php endif; ?>