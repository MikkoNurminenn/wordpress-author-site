<?php
/**
 * Plugin Name: Mikko Nurminen site credit
 * Description: Adds a restrained, update-safe site credit below the public footer.
 * Version: 1.0.0
 * Author: Mikko Nurminen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mikko_powered_by_styles() {
	$css = <<<'CSS'
.mikko-powered-by {
  display: flex;
  justify-content: center;
  padding: 18px 24px 22px;
  border-top: 1px solid rgba(26, 26, 26, 0.10);
  background: #fff;
  color: #1a1a1a;
}

.mikko-powered-by__link {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  color: inherit;
  opacity: 0.58;
  text-decoration: none;
  transition: opacity 180ms ease, transform 180ms ease;
}

.mikko-powered-by__kicker,
.mikko-powered-by__name {
  line-height: 1;
  white-space: nowrap;
}

.mikko-powered-by__kicker {
  font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  font-size: 9px;
  font-weight: 500;
  letter-spacing: 0.16em;
  text-transform: uppercase;
}

.mikko-powered-by__name {
  font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.04em;
}

.mikko-powered-by__mark {
  display: block;
  width: 21px;
  height: 21px;
  object-fit: contain;
  filter: grayscale(1) saturate(0.25);
  transition: filter 180ms ease;
}

.mikko-powered-by__link:hover,
.mikko-powered-by__link:focus-visible {
  color: inherit;
  opacity: 0.9;
  transform: translateY(-1px);
}

.mikko-powered-by__link:hover .mikko-powered-by__mark,
.mikko-powered-by__link:focus-visible .mikko-powered-by__mark {
  filter: grayscale(0) saturate(0.85);
}

.mikko-powered-by__link:focus-visible {
  outline: 1px solid currentColor;
  outline-offset: 5px;
}

@media (prefers-reduced-motion: reduce) {
  .mikko-powered-by__link,
  .mikko-powered-by__mark {
    transition: none;
  }

  .mikko-powered-by__link:hover,
  .mikko-powered-by__link:focus-visible {
    transform: none;
  }
}
CSS;

	wp_register_style( 'mikko-powered-by', false, array(), '1.0.0' );
	wp_enqueue_style( 'mikko-powered-by' );
	wp_add_inline_style( 'mikko-powered-by', $css );
}
add_action( 'wp_enqueue_scripts', 'mikko_powered_by_styles' );

function mikko_powered_by_render() {
	if ( is_admin() || is_feed() ) {
		return;
	}

	$mark_url = content_url( '/mu-plugins/mikko-powered-by/powered-by-mikko.webp' );
	?>
	<div class="mikko-powered-by">
		<a
			class="mikko-powered-by__link"
			href="https://mikkonurminen.io"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="Website by Mikko Nurminen"
		>
			<span class="mikko-powered-by__kicker">Powered by</span>
			<img
				class="mikko-powered-by__mark"
				src="<?php echo esc_url( $mark_url ); ?>"
				alt=""
				width="21"
				height="21"
				loading="lazy"
				decoding="async"
			>
			<span class="mikko-powered-by__name">Mikko Nurminen</span>
		</a>
	</div>
	<?php
}
add_action( 'wp_footer', 'mikko_powered_by_render', 30 );
