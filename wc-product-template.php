<?php
/*
Plugin Name:  WooCommerce Product Template
Plugin URI:   https://github.com/obiPlabon/wc-product-template
Description:  This plugin adds custom template support for WooCommerce single product. It's the same feature as custom page template.
Version:      1.0.0
Author:       obiPlabon <obi.plabon@gmail.com>
Author URI:   https://obiPlabon.im/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wcpt
Domain Path:  /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Product_Template' ) ) {

	class WC_Product_Template {

		/**
		 * Initialize
		 */
		public function __construct() {
			if ( ! $this->is_woocommerce_active() ) {
				add_action( 'admin_notices', array( $this, 'show_admin_notice' ) );
				return;
			}

			add_filter( 'post_type_labels_product', array( $this, 'change_metabox_label' ) );
			add_filter( 'woocommerce_template_loader_files', array( $this, 'add_file_to_loader' ) );
		}

		/**
		 * Check WooCommerce is activated
		 * @return boolean
		 */
		private function is_woocommerce_active() {
			return in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) );
		}

		/**
		 * Notify admin regarding dependency
		 * @return void
		 */
		public function show_admin_notice() {
			?>
			<div class="notice notice-error">
				<p><?php printf( esc_html__( '%1$s is not activated. %2$s plugin is dependent on %1$s. Please make sure it is installed and activated, otherwise %2$s plugin will not work as expected.' ), '<strong>WooCommerce</strong>', '<strong>WooCommerce Product Template</strong>' ); ?></p>
			</div>
			<?php
		}

		/**
		 * Change metabox heading label
		 * @param  object $labels Labels object
		 * @return object         Modified labels object
		 */
		public function change_metabox_label( $labels ) {
			$labels->attributes = esc_html__( 'Product Template', 'wcpt' );
			return $labels;
		}

		/**
		 * Add custom product template to WooCommer template loader
		 * @param arary $files WooCommerce default template files
		 */
		public function add_file_to_loader( $files ) {
			if ( is_page_template() ) {
				$files[] = get_page_template_slug();
			}
			return $files;
		}

	}

	new WC_Product_Template;

}
