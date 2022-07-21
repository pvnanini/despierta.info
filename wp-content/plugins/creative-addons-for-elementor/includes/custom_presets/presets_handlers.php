<?php

namespace Creative_Addons\Includes\Custom_Presets;

use Creative_Addons\Includes\System\Logging;
use Creative_Addons\Includes\Utilities;

defined( 'ABSPATH' ) || exit();

/**
 * All actions with custom presets: ajax and basic lib
 */
class Presets_Handlers {

	const CREL_PRESETS_OPTION = 'crel_presets_option';

	public function __construct() {
		add_action( 'wp_ajax_crel-update-preset', [ $this, 'update_preset' ] );
		add_action( 'wp_ajax_nopriv_crel-update-preset', [ $this, 'user_not_logged_in' ] );
		add_action( 'wp_ajax_crel-delete-preset', [ $this, 'delete_preset' ] );
		add_action( 'wp_ajax_nopriv_crel-delete-preset', [ $this, 'user_not_logged_in' ] );
	}

	/**
	 * Update preset ajax handler
	 */
	public function update_preset() {
		// verify that request is authentic
		if ( empty( $_REQUEST['crel_nonce'] ) || ! wp_verify_nonce( $_REQUEST['crel_nonce'], 'crel_nonce' ) ) {
			self::user_not_logged_in();
		}

		// empty options means only rename the preset
		$options = Utilities::post( 'options' );
		$options = json_decode( $options );

		$preset_name = Utilities::post( 'preset_name' );
		if ( empty( $preset_name ) ) {
			wp_die( json_encode( [ 'status' => 'error', 'message' => __( 'Preset name is incorrect', 'creative-addons-for-elementor' ) ] ) );
		}

		$widget_type = Utilities::post( 'widget_type' );
		if ( empty( $widget_type ) ) {
			wp_die( json_encode( [ 'status' => 'error', 'message' => __( 'Cannot save preset', 'creative-addons-for-elementor' ) ] ) );
		}

		$preset_id = Utilities::post( 'preset_id' );

		$all_presets = self::get_option();

		// Check name of the new preset
		foreach ( $all_presets as $p_id => $preset ) {
			// adding new but name already exists
			if ( ( empty( $preset_id ) || $preset_id != $p_id ) && ! empty( $preset['title'] ) && $preset['title'] == $preset_name && $preset['widget_type'] == $widget_type ) {
				wp_die( json_encode( [ 'status' => 'error', 'message' => __( 'A preset with this name already exists', 'creative-addons-for-elementor' ) ] ) );
			}
		}

		$time = time();
		$preset_id = empty( $preset_id ) ? $widget_type . '_' . $time : $preset_id;

		if ( empty( $all_presets[$preset_id] ) ) {
			$all_presets[$preset_id] = self::apply_preset_defaults( [
				'title'    => $preset_name,
				'widget_type'    => $widget_type,
				'date_created'   => $time,
				'options'       => $options
			] );
		} else {

			// update only if user set checkbox and send current settings
			if ( ! empty( $options ) ) {
				$all_presets[$preset_id]['options'] = $options;
			}

			$all_presets[$preset_id]['title'] = $preset_name;
		}

		$result = self::update_option( $all_presets );
		if ( is_wp_error( $result ) ) {
			wp_die( json_encode( [ 'status' => 'error', 'message' => __( 'Cannot save preset', 'creative-addons-for-elementor' ) ] ) );
		}

		wp_die( json_encode( [ 'status' => 'success', 'message' => __( 'Preset saved', 'creative-addons-for-elementor' ), 'new_name' => $preset_name, 'id' => $preset_id, 'preset' => $all_presets[$preset_id] ] ) );
	}

	/**
	 * Delete preset ajax handler
	 */
	public function delete_preset() {
		// verify that request is authentic
		if ( empty( $_REQUEST['crel_nonce'] ) || ! wp_verify_nonce( $_REQUEST['crel_nonce'], 'crel_nonce' ) ) {
			self::user_not_logged_in();
		}

		$preset_id = Utilities::post( 'preset_id' );

		$all_presets = self::get_option();
		if ( ! empty( $all_presets[$preset_id] ) ) {
			unset( $all_presets[$preset_id] );
		}

		$result = self::update_option( $all_presets );
		if ( is_wp_error( $result ) ) {
			wp_die( json_encode( [ 'status' => 'error', 'message' => __( 'Cannot delete preset', 'creative-addons-for-elementor' ) ] ) );
		}

		wp_die( json_encode( [ 'status' => 'success', 'message' => __( 'Preset was removed', 'creative-addons-for-elementor' ) ] ) );
	}

	/**
	 * Return preset options or default on error
	 * @return array
	 */
	public static function get_option() {
		$preset_options = Utilities::get_wp_option( self::CREL_PRESETS_OPTION, [] );
		if ( is_wp_error( $preset_options ) || ! is_array( $preset_options ) ) {
			Logging::add_log( 'Could not get presets options', $preset_options );
			return [];
		}

		return $preset_options;
	}

	/**
	 * Update preset options and sort by abc
	 *
	 * @param $presets
	 * @return array
	 */
	private static function update_option( $presets ) {

		uasort( $presets, function( $a, $b ){
			return strnatcasecmp ( $a['title'], $b['title']);
		});

		$result = Utilities::save_wp_option( self::CREL_PRESETS_OPTION, $presets, true );

		return $result;
	}

	/**
	 * Apply and validate default widget settings
	 * @param $preset
	 * @return array
	 */
	private static function apply_preset_defaults( $preset ) {
		$defaults = [
			'title'    => '',
			'widget_type'    => '',
			'plugin_version' => CREATIVE_ADDONS_VERSION,
			'date_created'   => time(),
			'options'       => []
		];

		return array_merge( $defaults, $preset );
	}
	
	public static function user_not_logged_in() {
		wp_die( json_encode( [ 'status' => 'error', 'message' => __( 'You do not have permission to edit these settings', 'creative-addons-for-elementor' ) ] ) );
	}
}