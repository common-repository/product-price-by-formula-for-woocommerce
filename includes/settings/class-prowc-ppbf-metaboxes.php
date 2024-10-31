<?php
/**
 * Product Price by Formula for WooCommerce - Metaboxes
 *
 * @version 2.2.0
 * @since   1.0.0
 * @author  ProWCPlugins
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'ProWC_PPBF_Metaboxes' ) ) :

class ProWC_PPBF_Metaboxes {

	/**
	 * Constructor.
	 *
	 * @version 2.1.2
	 * @since   1.0.0
	 */
	function __construct() {
		add_action( 'add_meta_boxes',    array( $this, 'add_ppbf_metabox' ) );
		add_action( 'save_post_product', array( $this, 'save_ppbf_meta_box' ), PHP_INT_MAX, 2 );
	}

	/**
	 * add_ppbf_metabox.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function add_ppbf_metabox() {
		add_meta_box(
			'alg-wc-product-price-by-formula',
			__( 'Product Price by Formula', 'product-price-by-formula-for-woocommerce' ),
			array( $this, 'display_ppbf_metabox' ),
			'product',
			'normal',
			'high'
		);
	}

	/**
	 * display_ppbf_metabox.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 */
	function display_ppbf_metabox() {
		$product_id = get_the_ID();
		$html       = '';
		$html      .= '<table class="widefat striped">';
		foreach ( $this->get_meta_box_options() as $option ) {
			$is_enabled = ( isset( $option['enabled'] ) && 'no' === $option['enabled'] ) ? false : true;
			if ( $is_enabled ) {
				if ( 'title' === $option['type'] ) {
					$html .= '<tr>';
					$html .= '<th colspan="3" style="text-align:left;font-style:italic;">' . $option['title'] . '</th>';
					$html .= '</tr>';
				} elseif ( 'value' === $option['type'] || 'value_textarea' === $option['type'] ) {
					$html .= '<tr>';
					$html .= '<th style="text-align:left;width:25%;">' . $option['title'] . ( ! empty( $option['tooltip'] ) ? wc_help_tip( $option['tooltip'], true ) : '' ) . '</th>';
					$html .= '<td>' . ( 'value' === $option['type'] ?
						'<input type="text" style="width:100%;" value="' . esc_html( $option['value'] ) . '" readonly>' :
						'<textarea style="width:100%;height:150px;" readonly>' . esc_html( $option['value'] ) . '</textarea>' ) . '</td>';
					$html .= '</tr>';
				} else {
					$class = ( isset( $option['class'] ) ? $option['class'] : '' );
					$custom_attributes = '';
					$the_post_id   = ( isset( $option['product_id'] ) ) ? $option['product_id'] : $product_id;
					$the_meta_name = ( isset( $option['meta_name'] ) )  ? $option['meta_name']  : '_' . $option['name'];
					if ( get_post_meta( $the_post_id, $the_meta_name ) ) {
						$option_value = get_post_meta( $the_post_id, $the_meta_name, true );
					} else {
						$option_value = ( isset( $option['default'] ) ) ? $option['default'] : '';
					}
					$css = ( isset( $option['css'] ) ) ? $option['css']  : '';
					$input_ending = '';
					if ( 'select' === $option['type'] ) {
						if ( isset( $option['multiple'] ) ) {
							$custom_attributes = ' multiple';
							$option_name       = $option['name'] . '[]';
						} else {
							$option_name       = $option['name'];
						}
						if ( isset( $option['custom_attributes'] ) ) {
							$custom_attributes .= ' ' . $option['custom_attributes'];
						}
						$options = '';
						foreach ( $option['options'] as $select_option_key => $select_option_value ) {
							$selected = '';
							if ( is_array( $option_value ) ) {
								foreach ( $option_value as $single_option_value ) {
									if ( '' != ( $selected = selected( $single_option_value, $select_option_key, false ) ) ) {
										break;
									}
								}
							} else {
								$selected = selected( $option_value, $select_option_key, false );
							}
							$options .= '<option value="' . $select_option_key . '" ' . $selected . '>' . $select_option_value . '</option>';
						}
					} elseif ( 'textarea' === $option['type'] ) {
						if ( '' === $css ) {
							$css = 'min-width:300px;';
						}
					} else {
						$input_ending = ' id="' . $option['name'] . '" name="' . $option['name'] . '" value="' . $option_value . '">';
						if ( isset( $option['custom_attributes'] ) ) {
							$input_ending = ' ' . $option['custom_attributes'] . $input_ending;
						}
						if ( isset( $option['placeholder'] ) ) {
							$input_ending = ' placeholder="' . $option['placeholder'] . '"' . $input_ending;
						}
					}
					switch ( $option['type'] ) {
						case 'price':
							$field_html = '<input style="' . $css . '" class="short wc_input_price" type="number" step="0.0001"' . $input_ending;
							break;
						case 'date':
							$field_html = '<input style="' . $css . '" class="input-text" display="date" type="text"' . $input_ending;
							break;
						case 'textarea':
							$field_html = '<textarea style="' . $css . '" id="' . $option['name'] . '" name="' . $option['name'] . '">' .
								$option_value . '</textarea>';
							break;
						case 'select':
							$field_html = '<select' . $custom_attributes . ' style="' . $css . '" id="' . $option['name'] . '" name="' .
								$option_name . '">' . $options . '</select>';
							break;
						default:
							$field_html = '<input style="' . $css . '" class="' . $class . '" type="' . $option['type'] . '"' . $input_ending;
							break;
					}
					$html .= '<tr>';
					$html .= '<th style="text-align:left;width:25%;">' . $option['title'] . ( ! empty( $option['tooltip'] ) ? wc_help_tip( $option['tooltip'], true ) : '' ) . '</th>';
					if ( isset( $option['desc'] ) && '' != $option['desc'] ) {
						$html .= '<td style="font-style:italic;width:25%;">' . $option['desc'] . '</td>';
					}
					$html .= '<td>' . $field_html . '</td>';
					$html .= '</tr>';
				}
			}
		}
		$html .= '</table>';
		$html .= '<input type="hidden" name="prowc_ppbf_save_post" value="prowc_ppbf_save_post">';
		echo $html;
		do_action( 'prowc_ppbf_after_meta_box_settings' );
	}

	/**
	 * save_ppbf_meta_box.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 */
	function save_ppbf_meta_box( $post_id, $post ) {
		// Check that we are saving with current metabox displayed.
		if ( ! isset( $_POST[ 'prowc_ppbf_save_post' ] ) ) {
			return;
		}
		// Save options
		foreach ( $this->get_meta_box_options() as $option ) {
			if ( in_array( $option['type'], array( 'title', 'value', 'value_textarea' ) ) ) {
				continue;
			}
			$is_enabled = ( isset( $option['enabled'] ) && 'no' === $option['enabled'] ) ? false : true;
			if ( $is_enabled ) {
				$option_value  = ( isset( $_POST[ $option['name'] ] ) ? $_POST[ $option['name'] ] : $option['default'] );
				$_post_id      = ( isset( $option['product_id'] )     ? $option['product_id']     : $post_id );
				$_meta_name    = ( isset( $option['meta_name'] )      ? $option['meta_name']      : '_' . $option['name'] );
				update_post_meta( $_post_id, $_meta_name, $option_value );
			}
		}
	}

	/**
	 * get_meta_box_options.
	 *
	 * @version 2.2.0
	 * @since   1.0.0
	 */
	function get_meta_box_options() {
		$product_id = get_the_ID();
		$options    = array();
		if ( 'no' === apply_filters( 'prowc_ppbf', 'no', 'value_enable_for_all_products' ) ) {
			$options = array_merge( $options, array(
				array(
					'title'      => __( 'Enabled', 'product-price-by-formula-for-woocommerce' ),
					'tooltip'    => __( '"Enabled" option is ignored if "Enable Price Calculation By Formula For All Products" option is checked in plugin\'s settings.',
						'product-price-by-formula-for-woocommerce' ),
					'name'       => 'prowc_ppbf_enabled',
					'default'    => 'no',
					'type'       => 'select',
					'options'    => array(
						'yes' => __( 'Yes', 'product-price-by-formula-for-woocommerce' ),
						'no'  => __( 'No', 'product-price-by-formula-for-woocommerce' ),
					),
				),
			) );
		} else {
			$options = array_merge( $options, array(
				array(
					'title'      => __( 'Enabled', 'product-price-by-formula-for-woocommerce' ),
					'type'       => 'value',
					'value'      => __( 'Yes', 'product-price-by-formula-for-woocommerce' ),
					'tooltip'    => sprintf( 
						/* translators: %s: Path to setting in WooCommerce */
						__( 'Enabled for all products in %s.', 'product-price-by-formula-for-woocommerce' ),
						__( 'WooCommerce > Settings > Product Price by Formula > General > Bulk Settings > Enable for all products', 'product-price-by-formula-for-woocommerce' ) ),
				),
			) );
		}
		if ( 'no' === apply_filters( 'prowc_ppbf', 'no', 'value_same_formula_for_all_products' ) ) {
			$options = array_merge( $options, array(
				array(
					'title'      => __( 'Calculation', 'product-price-by-formula-for-woocommerce' ),
					'name'       => 'prowc_ppbf_calculation',
					'default'    => 'per_product',
					'type'       => 'select',
					'options'    => array(
						'per_product'           => __( 'Use per product values', 'product-price-by-formula-for-woocommerce' ),
						'global'                => __( 'Use default formula values', 'product-price-by-formula-for-woocommerce' ),
						'global_without_params' => __( 'Use default formula with individual params', 'product-price-by-formula-for-woocommerce' ),
					),
				),
			) );
		} else {
			$options = array_merge( $options, array(
				array(
					'title'      => __( 'Calculation', 'product-price-by-formula-for-woocommerce' ),
					'type'       => 'value',
					'value'      => ( 'yes' === apply_filters( 'prowc_ppbf', 'no', 'value_same_formula_for_all_products' ) ?
						__( 'Same formula (with individual params)', 'product-price-by-formula-for-woocommerce' ) : __( 'Same formula (with same params)', 'product-price-by-formula-for-woocommerce' ) ),
					'tooltip'    => sprintf(
						/* translators: %s: Path to setting in WooCommerce */
						__( 'Same formula use for all products is enabled in %s.', 'product-price-by-formula-for-woocommerce' ),
						__( 'WooCommerce > Settings > Product Price by Formula > General > Bulk Settings > Use same formula', 'product-price-by-formula-for-woocommerce' ) ),
				),
			) );
		}
		if ( prowc_ppbf()->core->is_formula_per_product( $product_id ) ) {
			$options = array_merge( $options, array(
				array(
					'title'      => __( 'Formula', 'product-price-by-formula-for-woocommerce' ),
					'name'       => 'prowc_ppbf_eval',
					'default'    => get_option( 'prowc_ppbf_eval', '' ),
					'type'       => 'textarea',
					'class'      => 'widefat',
					'css'        => 'width:100%',
				),
				array(
					'title'      => __( 'Number of parameters', 'product-price-by-formula-for-woocommerce' ),
					'tooltip'    => __( 'Save settings after you change this number - new settings fields will appear.', 'product-price-by-formula-for-woocommerce' ),
					'name'       => 'prowc_ppbf_total_params',
					'default'    => get_option( 'prowc_ppbf_total_params', 1 ),
					'type'       => 'number',
					'custom_attributes' => 'min="0"'
				),
			) );
		} else {
			$options = array_merge( $options, array(
				array(
					'title'      => __( 'Formula', 'product-price-by-formula-for-woocommerce' ),
					'type'       => 'value_textarea',
					'value'      => get_option( 'prowc_ppbf_eval', '' ),
					'tooltip'    => ( 'no' != apply_filters( 'prowc_ppbf', 'no', 'value_same_formula_for_all_products' ) ?
						sprintf( 
							/* translators: 1: Path to setting in WooCommerce */
							__( 'Same formula use for all products is enabled in %1$s.', 'product-price-by-formula-for-woocommerce' ),
							__( 'WooCommerce > Settings > Product Price by Formula > General > Bulk Settings > Use same formula', 'product-price-by-formula-for-woocommerce' )
						):
						sprintf( 
							/* translators: 1: Setting name, 2: Option name */
							__( 'Using default formula as "%1$s" option above is set to "%2$s".', 'product-price-by-formula-for-woocommerce' ),
							__( 'Calculation', 'product-price-by-formula-for-woocommerce' ), 
							__( 'Use default formula', 'product-price-by-formula-for-woocommerce' ) 
						)),
				),
				array(
					'title'      => __( 'Number of parameters', 'product-price-by-formula-for-woocommerce' ),
					'type'       => 'value',
					'value'      => get_option( 'prowc_ppbf_total_params', 1 ),
					'tooltip'    => ( 'no' != apply_filters( 'prowc_ppbf', 'no', 'value_same_formula_for_all_products' ) ?
						sprintf(
							/* translators: %s: Path to setting in WooCommerce */
							__( 'Same formula use for all products is enabled in %s.', 'product-price-by-formula-for-woocommerce' ),
							__( 'WooCommerce > Settings > Product Price by Formula > General > Bulk Settings > Use same formula', 'product-price-by-formula-for-woocommerce' ) ) :
						sprintf(
							/* translators: 1: Setting name, 2: Option name */
							__( 'Using default number of parameters as "%1$s" option above is set to "%2$s".', 'product-price-by-formula-for-woocommerce' ),
							__( 'Calculation', 'product-price-by-formula-for-woocommerce' ), 
							__( 'Use default formula', 'product-price-by-formula-for-woocommerce' ) 
						)),
				),
			) );
		}
		$total_params = get_post_meta( $product_id, '_' . 'prowc_ppbf_total_params', false );
		if ( empty( $total_params ) || ! prowc_ppbf()->core->is_formula_per_product( $product_id ) ) {
			$total_params = get_option( 'prowc_ppbf_total_params', 1 );
		} else {
			$total_params = $total_params[0];
		}
		for ( $i = 1; $i <= $total_params; $i++ ) {
			if ( prowc_ppbf()->core->is_params_per_product( $product_id ) ) {
				$options = array_merge( $options, array(
					array(
						'title'      => 'p' . $i . ( 'no' != apply_filters( 'prowc_ppbf', 'no', 'value_same_formula_for_all_products' ) &&
							'' != ( $admin_note = get_option( 'prowc_ppbf_param_note_' . $i, '' ) ) ? ' (' . $admin_note . ')' : '' ),
						'name'       => 'prowc_ppbf_param_' . $i,
						'default'    => get_option( 'prowc_ppbf_param_' . $i, '' ),
						'type'       => 'textarea',
					),
				) );
			} else {
				$options = array_merge( $options, array(
					array(
						'title'      => 'p' . $i .
							( '' != ( $admin_note = get_option( 'prowc_ppbf_param_note_' . $i, '' ) ) ? ' (' . $admin_note . ')' : '' ),
						'type'       => 'value',
						'value'      => get_option( 'prowc_ppbf_param_' . $i, '' ),
						'tooltip'    => ( 'no' != apply_filters( 'prowc_ppbf', 'no', 'value_same_formula_for_all_products' ) ?
							sprintf( 
								/* translators: %s: Path to setting in WooCommerce */
								__( 'Same parameters use for all products is enabled in %s.', 'product-price-by-formula-for-woocommerce' ),
								__( 'WooCommerce > Settings > Product Price by Formula > General > Bulk Settings > Use same formula', 'product-price-by-formula-for-woocommerce' ) ) :
							sprintf(
								/* translators: 1: Path to setting name, 2: Option name */
								__( 'Using default parameter as "%1$s" option above is set to "%2$s".', 'product-price-by-formula-for-woocommerce' ),
								__( 'Calculation', 'product-price-by-formula-for-woocommerce' ), // This will be %1$s in the translated string
								__( 'Use default formula', 'product-price-by-formula-for-woocommerce' ) // This will be %2$s in the translated string
							)),
					),
				) );
			}
		}
		return $options;
	}

}

endif;

return new ProWC_PPBF_Metaboxes();
