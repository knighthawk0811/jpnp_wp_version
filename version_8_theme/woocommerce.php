<?php
/**
 * The template for displaying woocommerce pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package version_8
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <?php 
            $args = array(
            'wrap_before' => '<div class="breadcrumb"><div class="bc-content"><a href="/shop/">Store</a> &gt; ',
            'wrap_after' => '</div></div>',
            'delimiter' => ' > ',
            'before' => '',
            'after' => '',
            'home' => false,
            );
            woocommerce_breadcrumb($args); 
        ?>

		<main id="main" class="site-main" role="main">

			<?php woocommerce_content(); ?>
            
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();