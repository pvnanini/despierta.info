<?php
namespace Creative_Addons\Includes;

defined( 'ABSPATH' ) || exit();

/**
 * Register Elementor controls.
 */
class Controls_Manager {

    /**
     * Initialize
     */
    public static function init() {
		add_action( 'elementor/controls/controls_registered', [ __CLASS__, 'register_controls' ] );
    }

	/**
	 * Register controls
	 * @param $controls_Manager
	 */
	public static function register_controls( \Elementor\Controls_Manager $controls_Manager ) {
		
		$controls = self::get_controls_list();

		// register each of our controls
		foreach ( $controls as $control_class ) {

			if ( ! class_exists($control_class) ) {
				continue;
			}

			//  $controls_Manager->add_group_control( $control_class::get_type(), new $foreground() );
			/** @noinspection PhpUndefinedMethodInspection */
			/** @noinspection PhpUndefinedFieldInspection */
			$controls_Manager->register( new $control_class() );
		}
	}

    /**
     * Get list of Creative controls
     * @return array
     */
    public static function get_controls_list() {
        return [ '\Creative_Addons\Includes\Custom_Presets\Creative_Preset' ];
    }

}
