<?php

namespace Rtcl\Resources;

class ThemeSupportCss
{

	/**
	 * @return string css
	 */
	public static function twentyTwenty() {
		ob_start();
		?>
		.entry-content > .rtcl{max-width: 1200px !important;}
		<?php
		return ob_get_clean();
	}
}