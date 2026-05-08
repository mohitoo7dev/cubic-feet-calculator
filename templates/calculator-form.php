<?php
/**
 * Front-end calculator template.
 *
 * Variables available:
 *   $units  array   unit-slug => label
 *   $def    string  default selected unit
 *
 * @package CubicFeetCalculator
 * @since   3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="cfc-wrap" id="cfc-calculator" role="main">

	<!-- ── Header ── -->
	<div class="cfc-header">
		<div class="cfc-header__icon" aria-hidden="true">
			<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect x="4" y="14" width="40" height="28" rx="3" stroke="currentColor" stroke-width="2.5" fill="none"/>
				<path d="M4 22h40M16 22v20M32 22v20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				<path d="M14 14V8a2 2 0 012-2h16a2 2 0 012 2v6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
			</svg>
		</div>
		<h2 class="cfc-title"><?php esc_html_e( 'Cubic Feet Calculator', 'cubic-feet-calculator' ); ?></h2>
		<p class="cfc-subtitle"><?php esc_html_e( 'Enter your package dimensions to calculate the cubic feet of the package.', 'cubic-feet-calculator' ); ?></p>
	</div>

	<!-- ── Card ── -->
	<div class="cfc-card">

		<!-- Unit selector tabs -->
		<div class="cfc-units" role="group" aria-label="<?php esc_attr_e( 'Dimension unit', 'cubic-feet-calculator' ); ?>">
			<?php foreach ( $units as $key => $label ) : ?>
				<button type="button"
					class="cfc-unit-tab<?php echo ( $key === $def ) ? ' is-active' : ''; ?>"
					data-unit="<?php echo esc_attr( $key ); ?>"
					aria-pressed="<?php echo ( $key === $def ) ? 'true' : 'false'; ?>">
					<?php echo esc_html( $label ); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<input type="hidden" id="cfc-unit" value="<?php echo esc_attr( $def ); ?>">

		<!-- Dimension inputs -->
		<div class="cfc-inputs">

			<div class="cfc-field">
				<label class="cfc-label" for="cfc-length">
					<span class="cfc-label__icon" aria-hidden="true">↔</span>
					<?php esc_html_e( 'Length', 'cubic-feet-calculator' ); ?>
				</label>
				<div class="cfc-input-wrap">
					<input type="number" id="cfc-length" class="cfc-input"
						placeholder="0" min="0" step="any" autocomplete="off"
						aria-label="<?php esc_attr_e( 'Length', 'cubic-feet-calculator' ); ?>">
					<span class="cfc-input-unit" id="cfc-unit-label-l"><?php echo esc_html( current( $units ) ); ?></span>
				</div>
			</div>

			<div class="cfc-field">
				<label class="cfc-label" for="cfc-width">
					<span class="cfc-label__icon" aria-hidden="true">↕</span>
					<?php esc_html_e( 'Width', 'cubic-feet-calculator' ); ?>
				</label>
				<div class="cfc-input-wrap">
					<input type="number" id="cfc-width" class="cfc-input"
						placeholder="0" min="0" step="any" autocomplete="off"
						aria-label="<?php esc_attr_e( 'Width', 'cubic-feet-calculator' ); ?>">
					<span class="cfc-input-unit" id="cfc-unit-label-w"><?php echo esc_html( current( $units ) ); ?></span>
				</div>
			</div>

			<div class="cfc-field">
				<label class="cfc-label" for="cfc-height">
					<span class="cfc-label__icon" aria-hidden="true">⇕</span>
					<?php esc_html_e( 'Height', 'cubic-feet-calculator' ); ?>
				</label>
				<div class="cfc-input-wrap">
					<input type="number" id="cfc-height" class="cfc-input"
						placeholder="0" min="0" step="any" autocomplete="off"
						aria-label="<?php esc_attr_e( 'Height', 'cubic-feet-calculator' ); ?>">
					<span class="cfc-input-unit" id="cfc-unit-label-h"><?php echo esc_html( current( $units ) ); ?></span>
				</div>
			</div>

		</div><!-- .cfc-inputs -->

		<!-- Error message -->
		<div class="cfc-error" id="cfc-error" role="alert" aria-live="assertive" hidden>
			<svg class="cfc-error__icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
				<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
			</svg>
			<span id="cfc-error-text"></span>
		</div>

		<!-- Action buttons -->
		<div class="cfc-actions">
			<button type="button" id="cfc-reset-btn" class="cfc-btn cfc-btn--ghost">
				<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
				</svg>
				<?php esc_html_e( 'Reset', 'cubic-feet-calculator' ); ?>
			</button>
			<button type="button" id="cfc-calc-btn" class="cfc-btn cfc-btn--primary">
				<svg class="cfc-btn__icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm0 2h8v1H6V4zm0 3h2v2H6V7zm4 0h2v2h-2V7zm-4 4h2v2H6v-2zm4 0h2v2h-2v-2zm-4 4h2v1H6v-1zm4 0h2v1h-2v-1z"/>
				</svg>
				<span class="cfc-btn__text"><?php esc_html_e( 'Calculate', 'cubic-feet-calculator' ); ?></span>
				<span class="cfc-btn__spinner" aria-hidden="true"></span>
			</button>
		</div>

		<!-- Result panel -->
		<div class="cfc-result" id="cfc-result" hidden role="status" aria-live="polite">
			<div class="cfc-result__inner">
				<div class="cfc-result__badge">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
					</svg>
					<?php esc_html_e( 'Result', 'cubic-feet-calculator' ); ?>
				</div>
				<div class="cfc-result__value-wrap">
					<span class="cfc-result__value" id="cfc-result-value">0.00</span>
					<span class="cfc-result__unit"><?php esc_html_e( 'Cubic Feet', 'cubic-feet-calculator' ); ?></span>
					<span class="cfc-result__unit-abbr">ft³</span>
				</div>
				<p class="cfc-result__meta" id="cfc-result-meta"></p>
			</div>
		</div>

	</div><!-- .cfc-card -->

	<p class="cfc-footer">
		<?php esc_html_e( 'Formula: (L × W × H) converted to feet', 'cubic-feet-calculator' ); ?>
	</p>

</div><!-- .cfc-wrap -->
