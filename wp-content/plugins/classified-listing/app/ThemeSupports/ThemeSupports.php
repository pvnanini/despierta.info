<?php

namespace Rtcl\ThemeSupports;

use Rtcl\Resources\ThemeSupportCss;

class ThemeSupports
{
	/**
	 * Current Theme name
	 *
	 * @var string
	 */
	private static $current_theme = '';

	static function init() {
		self::$current_theme = get_template();
		do_action('rtcl_add_theme_support', self::$current_theme);
	}

	static function css_theme_support() {
		if ('twentytwenty' === self::$current_theme) {
			echo '<style id="rtcl-twentytwenty" media="screen">';
			echo ThemeSupportCss::twentyTwenty();
			echo '</style>';
//			wp_add_inline_style('twentytwenty-style', ThemeSupportCss::twentyTwenty());
		}
	}
}