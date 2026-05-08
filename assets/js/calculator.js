/**
 * Cubic Feet Calculator — Frontend Script
 *
 * Author:  Mohit
 * Version: 3.0.0
 * Package: CubicFeetCalculator
 *
 * Deps: jQuery (bundled with WordPress)
 * Data: cfcData (localised via class-cfc-assets.php)
 */

/* global cfcData, jQuery */
( function ( $ ) {
	'use strict';

	/* ── Selectors ──────────────────────────── */
	var S = {
		wrap     : '#cfc-calculator',
		length   : '#cfc-length',
		width    : '#cfc-width',
		height   : '#cfc-height',
		unit     : '#cfc-unit',            // hidden input
		unitTabs : '.cfc-unit-tab',
		unitLabels: '.cfc-input-unit',
		calcBtn  : '#cfc-calc-btn',
		resetBtn : '#cfc-reset-btn',
		error    : '#cfc-error',
		errorText: '#cfc-error-text',
		result   : '#cfc-result',
		resValue : '#cfc-result-value',
		resMeta  : '#cfc-result-meta',
	};

	/* ── Cache ──────────────────────────────── */
	var $e = {};

	/* ── Unit label map (short labels for badge) */
	var UNIT_SHORT = {
		'inches'      : 'in',
		'centimeters' : 'cm',
		'millimeters' : 'mm',
	};

	/* ── Helpers ────────────────────────────── */

	function showError( msg ) {
		$e.errorText.text( msg );
		$e.error.prop( 'hidden', false );
		$e.result.prop( 'hidden', true );
	}

	function clearError() {
		$e.error.prop( 'hidden', true );
		$e.errorText.text( '' );
	}

	function setLoading( on ) {
		$e.calcBtn
			.prop( 'disabled', on )
			.toggleClass( 'is-loading', on );
	}

	function validate() {
		var l = parseFloat( $e.length.val() );
		var w = parseFloat( $e.width.val() );
		var h = parseFloat( $e.height.val() );
		if ( isNaN(l) || isNaN(w) || isNaN(h) || l <= 0 || w <= 0 || h <= 0 ) {
			showError( cfcData.i18n.fill_all );
			$e.length.focus();
			return false;
		}
		return true;
	}

	/* Format number: 2–4 significant decimals, locale-aware */
	function formatNum( n ) {
		return parseFloat( n ).toLocaleString( undefined, {
			minimumFractionDigits: 2,
			maximumFractionDigits: 4,
		} );
	}

	/* ── Unit tab selection ─────────────────── */
	function selectUnit( unit ) {
		$e.unit.val( unit );

		/* Update tab active state */
		$( S.unitTabs ).each( function () {
			var isActive = $( this ).data( 'unit' ) === unit;
			$( this )
				.toggleClass( 'is-active', isActive )
				.attr( 'aria-pressed', isActive ? 'true' : 'false' );
		} );

		/* Update inline unit badges */
		var short = UNIT_SHORT[ unit ] || unit;
		$( S.unitLabels ).text( short );

		/* Hide result on unit change */
		$e.result.prop( 'hidden', true );
		clearError();
	}

	/* ── Reset ──────────────────────────────── */
	function doReset() {
		$e.length.val( '' );
		$e.width.val( '' );
		$e.height.val( '' );
		selectUnit( 'inches' );
		clearError();
		$e.result.prop( 'hidden', true );
		$e.length.trigger( 'focus' );
	}

	/* ── AJAX Calculate ─────────────────────── */
	function doCalc() {
		clearError();
		if ( ! validate() ) return;
		setLoading( true );

		$.ajax( {
			url    : cfcData.ajaxUrl,
			method : 'POST',
			data   : {
				action : 'cfc_calculate',
				nonce  : cfcData.nonce,
				length : $e.length.val(),
				width  : $e.width.val(),
				height : $e.height.val(),
				unit   : $e.unit.val(),
			},
			success: function ( res ) {
				if ( res.success ) {
					var cf   = parseFloat( res.data.cubic_feet );
					var unit = $e.unit.val();
					var l    = parseFloat( $e.length.val() );
					var w    = parseFloat( $e.width.val() );
					var h    = parseFloat( $e.height.val() );
					var short = UNIT_SHORT[ unit ] || unit;

					$e.resValue.text( formatNum( cf ) );
					$e.resMeta.text(
						l + ' × ' + w + ' × ' + h + ' ' + short +
						' = ' + formatNum( cf ) + ' ft³'
					);
					$e.result.prop( 'hidden', false );
				} else {
					var msg = ( res.data && res.data.message )
						? res.data.message
						: cfcData.i18n.error;
					showError( msg );
				}
			},
			error: function () {
				showError( cfcData.i18n.error );
			},
			complete: function () {
				setLoading( false );
			},
		} );
	}

	/* ── Init ───────────────────────────────── */
	$( function () {
		if ( ! $( S.wrap ).length ) return;

		/* Cache all elements */
		$e.length    = $( S.length );
		$e.width     = $( S.width );
		$e.height    = $( S.height );
		$e.unit      = $( S.unit );
		$e.calcBtn   = $( S.calcBtn );
		$e.resetBtn  = $( S.resetBtn );
		$e.error     = $( S.error );
		$e.errorText = $( S.errorText );
		$e.result    = $( S.result );
		$e.resValue  = $( S.resValue );
		$e.resMeta   = $( S.resMeta );

		/* Set initial unit label badges */
		var initUnit = $e.unit.val() || 'inches';
		$( S.unitLabels ).text( UNIT_SHORT[ initUnit ] || initUnit );

		/* Events */
		$e.calcBtn.on( 'click', doCalc );
		$e.resetBtn.on( 'click', doReset );

		/* Unit tab clicks */
		$( S.wrap ).on( 'click', S.unitTabs, function () {
			selectUnit( $( this ).data( 'unit' ) );
		} );

		/* Enter key on any input triggers calculate */
		$( S.wrap ).on( 'keydown', 'input[type="number"]', function ( e ) {
			if ( e.which === 13 ) doCalc();
		} );

		/* Clear result when inputs change */
		$e.length.add( $e.width ).add( $e.height ).on( 'input', function () {
			clearError();
			$e.result.prop( 'hidden', true );
		} );
	} );

} )( jQuery );
