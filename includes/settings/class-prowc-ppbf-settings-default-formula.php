<?php
/**
 * Product Price by Formula for WooCommerce - Default Formula Section Settings
 *
 * @version 2.2.0
 * @since   2.0.0
 * @author  ProWCPlugins
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'ProWC_PPBF_Settings_Default_Formula' ) ) :

class ProWC_PPBF_Settings_Default_Formula extends ProWC_PPBF_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	public $id;
	public $desc;
	public function __construct() {
		$this->id   = 'default_formula';
		$this->desc = __( 'Default Formula', 'product-price-by-formula-for-woocommerce' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 2.2.0
	 * @since   2.0.0
	 * @todo    [dev] (now) add link to the plugin page ("... for examples, please check...")
	 */
	function get_settings() {
		$link_start = apply_filters( 'prowc_ppbf', '<a href="https://prowcplugins.com/downloads/product-price-by-formula-for-woocommerce/" target="_blank" title="' .
			'To use this shortcode you\'ll need Product Price by Formula for WooCommerce Pro plugin.' . '">', 'settings' );
		$link_end   = apply_filters( 'prowc_ppbf', '</a>', 'settings' );
		$default_settings = array(
			array(
				'title'    => __( 'Default Formula Settings', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'title',
				'desc' => '<p>' . __( 'You can set default settings here. All settings can later be changed on individual product\'s edit page (in <strong>Product Price by Formula</strong> meta box).', 'product-price-by-formula-for-woocommerce' ) . '</p>' .
				'<p>' . sprintf(
					/* translators: 1: variable example, 2: formula example, 3: variable restriction example, 4: parameter restriction example */
					__( 'In <strong>formula</strong> use %1$s variable for product\'s base price. For example: %2$s. Please note that you cannot use %3$s or %4$s <strong>inside other params</strong>.', 'product-price-by-formula-for-woocommerce' ),
					'<code>x</code>', '<code>x+p1*p2</code>', '<code>x</code>', '<code>pN</code>'
				) . '</p>' .
				'<p>' . sprintf( 
					 /* translators: %s: list of available shortcodes */
					__( 'In <strong>formula and/or params</strong> you can also use shortcodes: %s.', 'product-price-by-formula-for-woocommerce' ),
					'<code>[' . prowc_ppbf()->core->shortcodes->shortcodes_prefix .
					implode( ']</code>, <code>[' . prowc_ppbf()->core->shortcodes->shortcodes_prefix,
						prowc_ppbf()->core->shortcodes->shortcodes ) .
					']</code>, ' .
					'<code>['  . $link_start . prowc_ppbf()->core->shortcodes->shortcodes_prefix .
					implode( $link_end . ']</code>, <code>[' . $link_start . prowc_ppbf()->core->shortcodes->shortcodes_prefix,
						prowc_ppbf()->core->shortcodes->extra_shortcodes ) .
					$link_end . ']</code>'
				) .
				'</p>' .
				'<p>' . sprintf( 
					 /* translators: %s: customer location shortcodes */
					__( 'Please note that if you are using <strong>caching plugins</strong> and dynamic product pricing (e.g., price changing with product stock (%1$s) or by customer\'s location (%2$s)), then caching needs to be disabled for products pages.', 'product-price-by-formula-for-woocommerce' ),
					'<code>[product_stock]</code>', '<code>[if_customer_location]</code>'
				) . ' ' .
				sprintf(
					/* translators: 1: shortcode example, 2: WooCommerce setting name, 3: WooCommerce setting value, 4: WooCommerce settings location */
					__( 'If you want to keep caching enabled, you will need to cache product pages for each condition: for example for %1$s you can set %2$s option to %3$s in %4$s.', 'product-price-by-formula-for-woocommerce' ),
					'<code>[if_customer_location]</code>',
					'<em>' . __( 'Default customer location', 'woocommerce' ) . '</em>',
					'<em>' . __( 'Geolocate (with page caching support)', 'woocommerce' ) . '</em>',
					'<em>' . __( 'WooCommerce > Settings > General', 'product-price-by-formula-for-woocommerce' ) . '</em>'
				) . '</p>',
				'id' => 'prowc_ppbf_default_options',
			),
			array(
				'title'    => __( 'Formula', 'product-price-by-formula-for-woocommerce' ),
				'type'     => 'textarea',
				'id'       => 'prowc_ppbf_eval',
				'default'  => '',
				'css'      => 'width:100%;height:150px;',
			),
			array(
				'title'    => __( 'Number of parameters', 'product-price-by-formula-for-woocommerce' ),
				'desc'     => '<button name="save" class="button-primary woocommerce-save-button" type="submit" value="' . esc_attr( __( 'Save changes', 'woocommerce' ) ) . '">' . esc_html( __( 'Save changes', 'woocommerce' ) ) . '</button>',
				'desc_tip' => __( 'Save settings after you change this number - new settings fields will appear.', 'product-price-by-formula-for-woocommerce' ),
				'id'       => 'prowc_ppbf_total_params',
				'default'  => 1,
				'type'     => 'number',
				'custom_attributes' => array( 'min' => 0 ),
			),
		);
		for ( $i = 1; $i <= get_option( 'prowc_ppbf_total_params', 1 ); $i++ ) {
			$default_settings = array_merge( $default_settings, array(
				array(
					'title'    => 'p' . $i . ( '' != ( $admin_note = get_option( 'prowc_ppbf_param_note_' . $i, '' ) ) ? ' (' . $admin_note . ')' : '' ),
					'desc'     => __( 'Value', 'product-price-by-formula-for-woocommerce' ),
					'id'       => 'prowc_ppbf_param_' . $i,
					'default'  => '',
					'type'     => 'text',
					'css'      => 'width:100%;',
				),
				array(
					'desc'     => __( 'Admin note (optional)', 'product-price-by-formula-for-woocommerce' ),
					'id'       => 'prowc_ppbf_param_note_' . $i,
					'default'  => '',
					'type'     => 'text',
					'css'      => 'width:100%;',
				),
			) );
		}
		$default_settings = array_merge( $default_settings, array(
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_ppbf_default_options',
			),
		) );
		return $default_settings;
	}

}

endif;

return new ProWC_PPBF_Settings_Default_Formula();
