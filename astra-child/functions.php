<?php

/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.2.0
 */

/**
 * Define Constants
 */
define('CHILD_THEME_ASTRA_CHILD_VERSION', '1.2.0');

/**
 * Enqueue styles
 */

function child_enqueue_styles()
{
  wp_enqueue_style('astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
}
/*
  parameter 15 is "magic" for child_enqueue_styles,
  part of the functionality of astra,
  rather than my own, although it looks like child_enqueue_styles has
  no parameters defined
*/
add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);
/*
   wp_footer hook allows definition of footer,
   astra's footer somehow disables the default
   message, which I've not gotten to work in my
   own code to do similar things in the ISCTestCode plugin
*/
add_action( 'wp_footer', 'astra_footer_align_bottom' );
/*
  Note the use of DOM editing code via javascript,
  This may be astra reaching around the WordPress functionality
  which may end up being the only way to eliminate the
  default message "Thank you for using WordPress"... [paraphrased]
*/
function astra_footer_align_bottom () {
	?>
	<script type="text/javascript">
		document.addEventListener(
			"DOMContentLoaded",
			function() {
				fullHeight();
			},
			false
			);
		function fullHeight() {
			var headerHeight = document.querySelector("header").clientHeight;
			var footerHeight = document.querySelector("footer").clientHeight;
			var headerFooter = headerHeight + footerHeight;
			var content = document.querySelector("#content");
			content.style.minHeight = "calc( 100vh - " + headerFooter + "px )";
		}
	</script>
	<?php
}
