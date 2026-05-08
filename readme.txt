=== Cubic Feet Calculator ===
Contributors:      mohit
Tags:              calculator, cubic feet, shipping, package, responsive
Requires at least: 5.8
Tested up to:      6.5
Requires PHP:      7.4
Stable tag:        3.0.0

A professional, fully responsive cubic feet calculator. Add anywhere with [cubic_feet_calculator].

== Description ==

**Cubic Feet Calculator** is a fully responsive, professional WordPress plugin
that lets visitors calculate the cubic volume of any package by entering its
Length, Width and Height in Inches, Centimeters, or Millimeters.

= Features =

* Fully responsive: Desktop, Tablet, Mobile, Small phones (≤380px)
* Beautiful unit tab switcher: Inches / Centimeters / Millimeters
* Inline unit badge in each input field
* Clean result panel with gradient design
* Calculation formula shown in result meta line
* AJAX-powered — no page reload
* Reset & Calculate buttons
* Enter-key support
* Accessible: ARIA labels, role=alert, aria-live, aria-pressed
* CSS custom properties for easy theming
* Only enqueues assets on pages with the shortcode
* Translation ready (.pot file included)

= Shortcode =

    [cubic_feet_calculator]

= Options =

    [cubic_feet_calculator default_unit="centimeters"]

Accepted default_unit values: inches | centimeters | millimeters

== Installation ==

1. Upload the `cubic-feet-calculator` folder to `/wp-content/plugins/`.
2. Activate via **Plugins → Installed Plugins**.
3. Insert `[cubic_feet_calculator]` on any page or post.

== Frequently Asked Questions ==

= Which formula is used? =

Cubic Feet = (L × conversion) × (W × conversion) × (H × conversion)

Conversions:
- Inches → Feet: ÷ 12
- Centimeters → Feet: × 0.032808
- Millimeters → Feet: × 0.003281

= Is it mobile-friendly? =

Yes — fully responsive with 4 breakpoints: desktop, tablet (768px), mobile (600px) and small mobile (380px).

== Changelog ==

= 3.0.0 =
* Full responsive redesign for all screen sizes
* Unit tab switcher (replaces dropdown)
* Inline unit badge in each input
* Gradient result panel with formula meta line
* 4 responsive breakpoints

= 2.0.0 =
* Added Centimeters and Millimeters support
* Clean result UI

= 1.0.0 =
* Initial release
