<?php
/**
 * CSS & JS asset management.
 * Only enqueues on pages that actually contain the shortcode.
 *
 * @package CubicFeetCalculator
 * @since   3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class CFC_Assets {

	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue' ) );
	}

	public static function enqueue() {
		wp_register_style(
			'cfc-styles',
			CFC_PLUGIN_URL . 'assets/css/calculator.css',
			array(),
			CFC_VERSION
		);

		wp_register_script(
			'cfc-scripts',
			CFC_PLUGIN_URL . 'assets/js/calculator.js',
			array( 'jquery' ),
			CFC_VERSION,
			true
		);

		wp_localize_script( 'cfc-scripts', 'cfcData', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'cfc_nonce' ),
			'i18n'    => array(
				'fill_all' => __( 'Please enter valid values for all three dimensions.', 'cubic-feet-calculator' ),
				'error'    => __( 'Something went wrong. Please try again.', 'cubic-feet-calculator' ),
			),
		) );

		if ( self::page_has_shortcode() ) {
			wp_enqueue_style( 'cfc-styles' );
			wp_enqueue_script( 'cfc-scripts' );
		}
	}

	/**
	 * Check whether the current post/page uses our shortcode.
	 *
	 * @return bool
	 */
	private static function page_has_shortcode() {
		global $post;
		return is_a( $post, 'WP_Post' )
			&& has_shortcode( $post->post_content, CFC_Shortcode::TAG );
	}
}
