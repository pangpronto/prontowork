<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

    <header class="woocommerce-products-header">

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

    </header>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			<?php
				$categories_args = array(
					'taxonomy' => 'product_cat'
				);
				$product_categories = get_terms( $categories_args );

				if($product_categories) {

					$products = new WP_Query($categories_args);

					if( $products->have_posts() ) {

						echo '<div class="subcategories">';
						woocommerce_product_loop_start();
						while ( $products->have_posts() ) : $products->the_post();
							wc_get_template_part( 'content', 'product' );
						endwhile;
						wp_reset_query();
						woocommerce_product_loop_end();
						echo '</div>';
					}
					wp_reset_postdata();
				}

			?>
			<?php 
				$products_args = array(
		            'post_type'     => 'product',
		            'tax_query'     => array(
		                array(
		                    'taxonomy' => 'product_cat',
		                    'operator' => 'NOT IN'
		                )
		            )
		        );


		        $products_item = new WP_Query( $products_args );
		        if( $products_item->have_posts() ) {
		        		
						echo '<div class="single-products">';
						//woocommerce_product_loop_start();
						wc_get_template( 'loop/loop-start.php' );
						while ( $products_item->have_posts() ) : $products_item->the_post();

							wc_get_template_part( 'content', 'product' );
						endwhile;
						wp_reset_query();
						woocommerce_product_loop_end();
						echo '</div>';
				}
				wp_reset_postdata();
			?>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
