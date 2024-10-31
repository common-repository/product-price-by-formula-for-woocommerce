<?php
/**
 * Product Price by Formula for WooCommerce - General Section Settings
 *
 * @version 2.3.0
 * @since   1.0.0
 * @author  ProWCPlugins
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'ProWC_PPBF_Settings_General' ) ) :

class ProWC_PPBF_Settings_General extends ProWC_PPBF_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public $id   = '';
	public $desc;
	public function __construct() {
		$this->desc = __( 'General', 'product-price-by-formula-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.3.0
	 * @since   1.0.0
	 */
	function get_settings() {

		$main_settings = array(
			array(
				'title'    => __( 'Product Price by Formula Options', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'prowc_ppbf_options',
			),
			array(
				'title'    => __( 'Product Price by Formula for WooCommerce', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'product-price-by-formula-for-woocommerce' ) . '</strong>',
				'id'       => 'prowc_ppbf_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_ppbf_options',
			),
		);

		$bulk_settings = array(
			array(
				'title'    => __( 'Bulk Settings', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'prowc_ppbf_bulk_options',
			),
			array(
				'title'    => __( 'Enable for all products', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => __( 'Enable', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'checkbox',
				'id'       => 'prowc_ppbf_enable_for_all_products',
				'default'  => 'no',
				'desc_tip' => __( 'Enables price calculation by formula for all products.', 'product-price-by-formula-for-woocommerce' ) . apply_filters( 'prowc_ppbf', '<br>' . sprintf(
					/* translators: %s: URL for the Pro version of the plugin */
					__( 'To enable price calculation by formula <strong>for all products</strong>, you\'ll need <a target="_blank" href="%s">Product Price by Formula for WooCommerce Pro</a> plugin.', 'product-price-by-formula-for-woocommerce' ),
						'https://prowcplugins.com/downloads/product-price-by-formula-for-woocommerce/' ), 'settings' ),
				'custom_attributes' => apply_filters( 'prowc_ppbf', array( 'disabled' => 'disabled' ), 'settings' ),
			),
			array(
				'desc'     => __( 'Disable for product IDs', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'If you have checked "Enable for all products" option, you can optionally add product exceptions here (i.e. price calculation by formula will be disabled for these products).', 'product-price-by-formula-for-woocommerce' ) . ' ' .
					__( 'Set it as comma separated list of product IDs.', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'text',
				'id'       => 'prowc_ppbf_disable_for_products',
				'default'  => '',
				'css'      => 'width:100%;',
				'custom_attributes' => apply_filters( 'prowc_ppbf', array( 'readonly' => 'readonly' ), 'settings' ),
			),
			array(
				'desc'     => __( 'Disable for product category IDs', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'If you have checked "Enable for all products" option, you can optionally add product category exceptions here (i.e. price calculation by formula will be disabled for these product categories).', 'product-price-by-formula-for-woocommerce' ) . ' ' .
					__( 'Set it as comma separated list of product category IDs.', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'text',
				'id'       => 'prowc_ppbf_disable_for_product_cats',
				'default'  => '',
				'css'      => 'width:100%;',
				'custom_attributes' => apply_filters( 'prowc_ppbf', array( 'readonly' => 'readonly' ), 'settings' ),
			),
			array(
				'title'    => __( 'Use same formula', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Enables same formula for all products. Possible values: No; Yes (with individual params); Yes (with same params).', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'select',
				'id'       => 'prowc_ppbf_same_formula_for_all_products',
				'default'  => 'no',
				'options'  => array(
					'no'              => __( 'No', 'product-price-by-formula-for-woocommerce' ),
					'yes'             => __( 'Yes (with individual params)', 'product-price-by-formula-for-woocommerce' ),
					'yes_with_params' => __( 'Yes (with same params)', 'product-price-by-formula-for-woocommerce' ),
				),
				'desc'     => apply_filters( 'prowc_ppbf', '<br>' . sprintf(
					/* translators: %s: URL for the Pro version of the plugin */
					__( 'To enable <strong>same formula</strong> (with individual or global params) for all products, you\'ll need <a target="_blank" href="%s">Product Price by Formula for WooCommerce Pro</a> plugin.', 'product-price-by-formula-for-woocommerce' ),
						'https://prowcplugins.com/downloads/product-price-by-formula-for-woocommerce/' ), 'settings' ),
				'custom_attributes' => apply_filters( 'prowc_ppbf', array( 'disabled' => 'disabled' ), 'settings' ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_ppbf_bulk_options',
			),
		);

		$general_settings = array(
			array(
				'title'    => __( 'General Settings', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'prowc_ppbf_general_options',
			),
			array(
				'title'    => __( 'Disable for empty price', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Disables price by formula for products with empty price.', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => __( 'Disable', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'checkbox',
				'id'       => 'prowc_ppbf_disable_for_empty_price',
				'default'  => 'yes',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_ppbf_general_options',
			),
		);

		$is_rounding_disabled = ( 'no' === get_option( 'prowc_ppbf_rounding_enabled', 'no' ) );
		$rounding_settings = ( $is_rounding_disabled ? array() : array(
			array(
				'title'    => __( 'Rounding Settings', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => sprintf( 
					/* translators: %s: Shortcodes for mathematical rounding */
					__( 'This section is <strong>deprecated</strong> - instead use one of these shortcodes in formula: %s.', 'product-price-by-formula-for-woocommerce' ),
						'<code>[math_round]</code>, <code>[math_ceil]</code>, <code>[math_floor]</code>' ) . ' ' .
					__( 'As soon as you will set "Final price rounding" option below to "Disabled" this settings section will be removed.', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'prowc_ppbf_rounding_options',
			),
			array(
				'title'    => __( 'Final price rounding', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'select',
				'id'       => 'prowc_ppbf_rounding_enabled',
				'default'  => 'no',
				'options'  => array(
					'no'    => __( 'Disabled', 'product-price-by-formula-for-woocommerce' ),
					'floor' => __( 'Round down', 'product-price-by-formula-for-woocommerce' ),
					'round' => __( 'Round', 'product-price-by-formula-for-woocommerce' ),
					'ceil'  => __( 'Round up', 'product-price-by-formula-for-woocommerce' ),
				),
			),
			array(
				'desc'     => '<br>' . __( 'Rounding precision (i.e. number of decimals)', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Only used when "Round" option is selected for "Final price rounding". Can be positive, negative or zero.', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'number',
				'id'       => 'prowc_ppbf_rounding_precision',
				'default'  => get_option( 'woocommerce_price_num_decimals' ),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_ppbf_rounding_options',
			),
		) );

		$admin_settings = array(
			array(
				'title'    => __( 'Admin Settings', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'prowc_ppbf_admin_options',
			),
			array(
				'title'    => __( 'Add dashboard widget', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Adds default settings admin dashboard widget.', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => __( 'Add', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'checkbox',
				'id'       => 'prowc_ppbf_dashboard_widget_enabled',
				'default'  => 'no',
			),
			array(
				'title'    => __( 'Products list columns', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Adds columns to the admin products list.', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'multiselect',
				'class'    => 'chosen_select',
				'id'       => 'prowc_ppbf_products_list_columns',
				'default'  => array(),
				'options'  => prowc_ppbf()->core->admin->products_list_columns,
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_ppbf_admin_options',
			),
		);

		$advanced_settings = array(
			array(
				'title'    => __( 'Advanced Settings', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'title',
				'id'       => 'prowc_ppbf_advanced_options',
			),
			array(
				'title'    => __( 'Shortcodes prefix', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Optional prefix for all plugin\'s shortcodes.', 'product-price-by-formula-for-woocommerce' ) . ' ' .
					sprintf(
						/* translators: 1: Example prefix, 2: Example shortcode, 3: Transformed shortcode */
						__( 'E.g.: if set to %1$s, will transform %2$s to %3$s.', 'product-price-by-formula-for-woocommerce' ),
						'<em>my_prefix_</em>', '<em>[math_round]</em>', '<em>[my_prefix_math_round]</em>'
					),				
				'type'     => 'text',
				'id'       => 'prowc_ppbf_shortcodes_prefix',
				'default'  => '',
			),
			array(
				'title'    => __( 'Price filters priority', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Priority for WooCommerce price filters. Set to zero to use the default priority.', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'number',
				'id'       => 'prowc_ppbf_filters_priority',
				'default'  => 0,
			),
			array(
				'title'    => __( 'Plugin URLs', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'By default plugin applies price calculations on frontend only. If you need to apply it on other URLs, enter URLs here. One URL per line.', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => sprintf( 
					 /* translators: %s: Example prefix, %s: Example shortcode, %s: Transformed shortcode */
					__( 'E.g.: %s', 'product-price-by-formula-for-woocommerce' ), '<code>/wp-admin/edit.php?post_type=product</code>' ),
				'type'     => 'textarea',
				'id'       => 'prowc_ppbf_enable_plugin_urls',
				'default'  => '',
				'css'      => 'width:100%;min-height:100px;',
				'prowc_ppbf_raw' => true,
			),
			array(
				'title'    => __( 'Price changes', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => __( 'Disable price by formula for products with "price changes"', 'product-price-by-formula-for-woocommerce' ),
				'desc_tip' => __( 'Try enabling this checkbox, if you are having compatibility issues with other plugins.', 'product-price-by-formula-for-woocommerce' ),
				'id'       => 'prowc_ppbf_check_for_product_changes_price',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_ppbf_advanced_options',
			),
		);

		return array_merge( $main_settings, $bulk_settings, $general_settings, $rounding_settings, $admin_settings, $advanced_settings );
	}

}

endif;

return new ProWC_PPBF_Settings_General();
