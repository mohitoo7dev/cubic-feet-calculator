<?php
/**
 * Shortcode registration & AJAX handler.
 *
 * @package CubicFeetCalculator
 * @since   3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class CFC_Shortcode {

	const TAG = 'cubic_feet_calculator';

	public static function init() {
		add_shortcode( self::TAG, array( __CLASS__, 'render' ) );
		add_action( 'wp_ajax_cfc_calculate',        array( __CLASS__, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_cfc_calculate', array( __CLASS__, 'ajax' ) );
	}

	/**
	 * Render shortcode HTML.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render( $atts ) {
		$atts  = shortcode_atts( array( 'default_unit' => 'inches' ), $atts, self::TAG );
		$units = CFC_Calculator::units();
		$def   = sanitize_text_field( $atts['default_unit'] );
		ob_start();
		include CFC_PLUGIN_DIR . 'templates/calculator-form.php';
		return ob_get_clean();
	}

	/**
	 * Handle AJAX calculation.
	 */
	public static function ajax() {
		check_ajax_referer( 'cfc_nonce', 'nonce' );

		$l    = isset( $_POST['length'] ) ? floatval( wp_unslash( $_POST['length'] ) ) : 0;
		$w    = isset( $_POST['width'] )  ? floatval( wp_unslash( $_POST['width'] ) )  : 0;
		$h    = isset( $_POST['height'] ) ? floatval( wp_unslash( $_POST['height'] ) ) : 0;
		$unit = isset( $_POST['unit'] )   ? sanitize_text_field( wp_unslash( $_POST['unit'] ) ) : 'inches';

		$result = CFC_Calculator::cubic_feet( $l, $w, $h, $unit );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}

		wp_send_json_success( array( 'cubic_feet' => $result ) );
	}
}
