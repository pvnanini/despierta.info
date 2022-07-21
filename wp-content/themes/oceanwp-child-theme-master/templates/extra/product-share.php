<?php
/**
 * Social Share Buttons Output
 *
 * @package Ocean WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get sharing sites
$sites = ops_social_share_sites();

// Return if there aren't any sites enabled
if ( empty( $sites ) ) {
	return;
}

// Vars
$product_title = get_the_title();
$product_url   = get_permalink();
$product_img   = wp_get_attachment_url( get_post_thumbnail_id() ); ?>

<div class="oew-product-share clr">

	<ul class="ocean-social-share clr" aria-label="<?php echo esc_attr__( 'Share this product on social media', 'ocean-product-sharing' ); ?>">

		<?php
		// Loop through sites
		foreach ( $sites as $site ) :

			// Whatsapp
				if ( 'whatsapp' == $site ) {
					?>

					<li class="whatsapp">
						<a href="https://wa.me/15551234567?url=<?php echo rawurlencode( esc_url( $product_url ) ); ?>&media=<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>&description=<?php echo rawurlencode( wp_strip_all_tags( $product_title ) ); ?>" target="_blank" aria-label="<?php esc_attr_e( 'Share on whatsapp', 'ocean-product-sharing' ); ?>" onclick="ops_onClick( this.href );return false;">
							<span class="screen-reader-text"><?php echo esc_attr__( 'Opens in a new window', 'ocean-product-sharing' ); ?></span>
							<span class="ops-icon-wrap">
							<svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" class="svg-icon"><path class="svg-icon-path" d="M11.665 9.588c-.2-.1-1.177-.578-1.36-.644-.182-.067-.315-.1-.448.1-.132.197-.514.643-.63.775-.116.13-.232.14-.43.05-.2-.1-.842-.31-1.602-.99-.592-.53-.99-1.18-1.107-1.38-.116-.2-.013-.31.087-.41.09-.09.2-.23.3-.35.098-.12.13-.2.198-.33.066-.14.033-.25-.017-.35-.05-.1-.448-1.08-.614-1.47-.16-.39-.325-.34-.448-.34-.115-.01-.248-.01-.38-.01-.134 0-.35.05-.532.24-.182.2-.696.68-.696 1.65s.713 1.91.812 2.05c.1.13 1.404 2.13 3.4 2.99.476.2.846.32 1.136.42.476.15.91.13 1.253.08.383-.06 1.178-.48 1.344-.95.17-.47.17-.86.12-.95-.05-.09-.18-.14-.38-.23M8.04 14.5h-.01c-1.18 0-2.35-.32-3.37-.92l-.24-.143-2.5.65.67-2.43-.16-.25c-.66-1.05-1.01-2.26-1.01-3.506 0-3.63 2.97-6.59 6.628-6.59 1.77 0 3.43.69 4.68 1.94 1.25 1.24 1.94 2.9 1.94 4.66-.003 3.63-2.973 6.59-6.623 6.59M13.68 2.3C12.16.83 10.16 0 8.03 0 3.642 0 .07 3.556.067 7.928c0 1.397.366 2.76 1.063 3.964L0 16l4.223-1.102c1.164.63 2.474.964 3.807.965h.004c4.39 0 7.964-3.557 7.966-7.93 0-2.117-.827-4.11-2.33-5.608" fill-rule="nonzero"/></svg>
						</span>
						<div class="product-share-text" aria-hidden="true"><?php esc_html_e( 'Compartir el Producto', 'ocean-product-sharing' ); ?></div>
						</a>
					</li>

					<?php
				}
			
			// Twitter
			if ( 'twitter' == $site ) {
				?>

				<li class="twitter">
					<a aria-label="<?php esc_attr_e( 'Share this product on Twitter', 'ocean-product-sharing' ); ?>" class="twitter-share-button" href="https://twitter.com/intent/tweet?text=<?php echo html_entity_decode( wp_strip_all_tags( $product_title ) ); ?>+<?php echo esc_url( $product_url ); ?>" onclick="ops_onClick( this.href );return false;">
						<span class="screen-reader-text"><?php echo esc_attr__( 'Opens in a new window', 'ocean-product-sharing' ); ?></span>
						<span class="ops-icon-wrap">
							<svg class="ops-icon" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
								<path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/>
							</svg>
						</span>
						<div class="product-share-text" aria-hidden="true"><?php esc_html_e( 'Tweet This Product', 'ocean-product-sharing' ); ?></div>
					</a>
				</li>

				<?php
			}
			// Facebook
			if ( 'facebook' == $site ) {
				?>

				<li class="facebook">
					<a href="https://www.facebook.com/sharer.php?u=<?php echo rawurlencode( esc_url( $product_url ) ); ?>" target="_blank" aria-label="<?php esc_attr_e( 'Share on Facebook', 'ocean-product-sharing' ); ?>" onclick="ops_onClick( this.href );return false;">
						<span class="screen-reader-text"><?php echo esc_attr__( 'Opens in a new window', 'ocean-product-sharing' ); ?></span>
						<span class="ops-icon-wrap">
							<svg class="ops-icon" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
								<path d="M5.677,12.998V8.123h3.575V6.224C9.252,2.949,11.712,0,14.736,0h3.94v4.874h-3.94
								c-0.432,0-0.934,0.524-0.934,1.308v1.942h4.874v4.874h-4.874V24H9.252V12.998H5.677z"/>
							</svg>
						</span>
						<div class="product-share-text" aria-hidden="true"><?php esc_html_e( 'Share on Facebook', 'ocean-product-sharing' ); ?></div>
					</a>
				</li>

				<?php
			}
			// Pinterest
			if ( 'pinterest' == $site ) {
				?>

				<li class="pinterest">
					<a href="https://www.pinterest.com/pin/create/button/?url=<?php echo rawurlencode( esc_url( $product_url ) ); ?>&amp;media=<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>&amp;description=<?php echo rawurlencode( wp_strip_all_tags( $product_title ) ); ?>" target="_blank" aria-label="<?php esc_attr_e( 'Share on Pinterest', 'ocean-product-sharing' ); ?>" onclick="ops_onClick( this.href );return false;">
						<span class="screen-reader-text"><?php echo esc_attr__( 'Opens in a new window', 'ocean-product-sharing' ); ?></span>
						<span class="ops-icon-wrap">
							<svg class="ops-icon" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
								<path d="M13.757,17.343c-1.487,0-2.886-0.804-3.365-1.717c0,0-0.8,3.173-0.969,3.785
								c-0.596,2.165-2.35,4.331-2.487,4.508c-0.095,0.124-0.305,0.085-0.327-0.078c-0.038-0.276-0.485-3.007,0.041-5.235
								c0.264-1.118,1.772-7.505,1.772-7.505s-0.44-0.879-0.44-2.179c0-2.041,1.183-3.565,2.657-3.565c1.252,0,1.857,0.94,1.857,2.068
								c0,1.26-0.802,3.142-1.216,4.888c-0.345,1.461,0.734,2.653,2.174,2.653c2.609,0,4.367-3.352,4.367-7.323
								c0-3.018-2.032-5.278-5.731-5.278c-4.177,0-6.782,3.116-6.782,6.597c0,1.2,0.355,2.047,0.909,2.701
								c0.255,0.301,0.29,0.422,0.198,0.767c-0.067,0.254-0.218,0.864-0.281,1.106c-0.092,0.349-0.375,0.474-0.69,0.345
								c-1.923-0.785-2.82-2.893-2.82-5.262c0-3.912,3.3-8.604,9.844-8.604c5.259,0,8.72,3.805,8.72,7.89
								C21.188,13.307,18.185,17.343,13.757,17.343z"/>
							</svg>
						</span>
						<div class="product-share-text" aria-hidden="true"><?php esc_html_e( 'Pin This Product', 'ocean-product-sharing' ); ?></div>
					</a>
				</li>

				<?php
			}
			// Mail
			if ( 'email' == $site ) {
				?>

				<li class="email">
					<a href="mailto:?subject=<?php echo html_entity_decode( wp_strip_all_tags( $product_title ) ); ?>&amp;body=<?php echo esc_url( $product_url ); ?>" target="_blank" aria-label="<?php esc_attr_e( 'Share via email', 'ocean-product-sharing' ); ?>" onclick="ops_onClick( this.href );return false;">
						<span class="screen-reader-text"><?php echo esc_attr__( 'Opens in a new window', 'ocean-product-sharing' ); ?></span>
						<span class="ops-icon-wrap">
							<svg class="ops-icon" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
								<path d="M23.674,3.741c-0.338-0.495-0.907-0.823-1.549-0.823H1.876c-0.629,0-1.184,0.316-1.525,0.794l11.687,9.745
								L23.674,3.741z"/>
								<path d="M12.037,16.409L0,6.371v12.836c0,1.031,0.844,1.875,1.875,1.875h20.249c1.031,0,1.875-0.844,1.875-1.875
								V6.421L12.037,16.409z"/>
							</svg>
						</span>
						<div class="product-share-text" aria-hidden="true"><?php esc_html_e( 'Mail This Product', 'ocean-product-sharing' ); ?></div>
					</a>
				</li>

			<?php } ?>

		<?php endforeach; ?>

	</ul>

</div><!-- .entry-share -->
