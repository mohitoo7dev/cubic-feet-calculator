<?php
/**
 * Core conversion & calculation logic.
 *
 * @package CubicFeetCalculator
 * @since   3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class CFC_Calculator {

	/** 1 unit → feet conversion factors */
	const TO_FEET = array(
		'inches'      => 0.08333333,
		'centimeters' => 0.03280840,
		'millimeters' => 0.00328084,
	);

	/**
	 * Calculate cubic feet.
	 *
	 * @param  float        $l    Length.
	 * @param  float        $w    Width.
	 * @param  float        $h    Height.
	 * @param  string       $unit inches|centimeters|millimeters
	 * @return float|WP_Error
	 */
	public static function cubic_feet( $l, $w, $h, $unit ) {
		$unit = strtolower( sanitize_text_field( $unit ) );

		if ( ! array_key_exists( $unit, self::TO_FEET ) ) {
			return new WP_Error( 'invalid_unit',
				__( 'Invalid dimension unit.', 'cubic-feet-calculator' ) );
		}

		$l = (float) $l;
		$w = (float) $w;
		$h = (float) $h;

		if ( $l <= 0 || $w <= 0 || $h <= 0 ) {
			return new WP_Error( 'invalid_dimensions',
				__( 'All dimensions must be greater than zero.', 'cubic-feet-calculator' ) );
		}

		$f = self::TO_FEET[ $unit ];
		return round( ( $l * $f ) * ( $w * $f ) * ( $h * $f ), 4 );
	}

	/**
	 * Unit dropdown options.
	 *
	 * @return array<string,string>
	 */
	public static function units() {
		return array(
			'inches'      => __( 'Inches',      'cubic-feet-calculator' ),
			'centimeters' => __( 'Centimeters', 'cubic-feet-calculator' ),
			'millimeters' => __( 'Millimeters', 'cubic-feet-calculator' ),
		);
	}
}
