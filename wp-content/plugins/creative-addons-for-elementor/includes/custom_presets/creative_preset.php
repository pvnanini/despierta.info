<?php
namespace Creative_Addons\Includes\Custom_Presets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Init class for widgets including all checks
 */
class Creative_Preset extends \Elementor\Control_Select {
	
	const TYPE = 'creative_preset';
	
	public function get_type() {
		return self::TYPE;
	}
	
	/**
	 * Render select control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {

		$control_uid = $this->get_control_uid();		?>

		<div class="elementor-control-field {{{ data.reset ? 'crel-with-reset' : '' }}} {{{ ( data.select_class ) ? data.select_class : '' }}}"><#
			if ( data.label ) { #>
				<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label><#
			} #>
			<div class="elementor-control-input-wrapper"><#
				if ( data.reset ) { #>
					<i title="<?php _e( 'Reset Style', 'creative-addons-for-elementor' ); ?>" class="eicon-redo crel-reset-design" aria-hidden="true"></i><#
				} #>
				<select id="<?php echo $control_uid; ?>" data-setting="{{ data.name }}"><#
					if ( typeof data.first_empty !== 'undefined' && data.first_empty ) { #>
						<option value="" data-value="" data-colors="" selected>{{{ data.default_label }}}</option><#
					}
					let printOptions = function( options ) {
						_.each( options, function( option_data, option_value ) {

							let colors = '';
							if ( typeof option_data.colors !== 'undefined' ) {
								colors = JSON.stringify( option_data.colors );
							} #>

							<option value="{{ option_value }}" data-value='{{{ JSON.stringify( option_data.options ) }}}' data-colors='{{{colors}}}'>{{{ option_data.title }}}</option><#
						});
					}

					if ( data.groups ) {
						for ( var groupIndex in data.groups ) {
							let groupArgs = data.groups[ groupIndex ];
							if ( groupArgs.options ) { #>
								<optgroup label="{{ groupArgs.label }}"><#
									printOptions( groupArgs.options ) #>
								</optgroup><#
							} else if ( _.isString( groupArgs ) ) { #>
								<option value="{{ groupIndex }}">{{{ groupArgs }}}</option><#
							}
						}
					} else {
						printOptions( data.options );
					} #>
				</select><#
				if ( data.buttons ) { #>
					<span class="crel-preset-empty-text"><?php esc_html_e( 'Create a Preset', 'creative-addons-for-elementor' ); ?></span>
					<button type="button" class="elementor-button elementor-button-default crel-button-update-preset"><i class="eicon-edit" aria-hidden="true"></i></button>
					<button type="button" class="elementor-button elementor-button-default crel-button-save_new-preset"><i class="eicon-plus-circle" aria-hidden="true"></i></button><#
				} #>
			</div><#
		if ( data.buttons ) { #>
			<div class="elementor-controls-popover crel-panel-popup crel-panel-popup--save_preset">
				<div class="e-group-control-header">
					<span><?php esc_html_e( 'Create Preset', 'creative-addons-for-elementor' ); ?></span>
				</div>
				<div class="elementor-control">
					<input type="text" class="crel-create_preset-name" placeholder="<?php esc_html_e( 'Enter your preset name', 'creative-addons-for-elementor' ); ?>" maxlength="100">
				</div>
				<div class="elementor-control">
					<div class="crel-panel-buttons">
						<button class="elementor-button elementor-button-success crel-create-preset-button">
							<span class="crel-button-state-icon">
								<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
							</span>
							<span class="crel-button-label">
								<?php esc_html_e( 'Save', 'creative-addons-for-elementor' ); ?>
							</span>
						</button>
						<button class="elementor-button crel-elementor-button-cancel crel-cancel-preset-button">
							<span class="crel-button-label">
								<?php esc_html_e( 'Cancel', 'creative-addons-for-elementor' ); ?>
							</span>
						</button>
					</div>
				</div>
				<div class="elementor-control">
					<div class="crel-update-preset-message"></div>
				</div>
			</div>
			<div class="elementor-controls-popover crel-panel-popup crel-panel-popup--update_preset">
				<div class="e-group-control-header">
					<span><?php esc_html_e( 'Update Preset', 'creative-addons-for-elementor' ); ?></span>
				</div>
				<div class="crel-panel-popup--update_preset_1">
					<div class="elementor-control">
						<input type="text" class="crel-update_preset-name" maxlength="100">
					</div>
					<div class="elementor-control">
						<label class="crel-panel-checkbox">
							<input type="checkbox" class="crel-update_preset-confirm" >
							<span><?php esc_html_e( 'Include changes I made to the current widget', 'creative-addons-for-elementor' ); ?></span>
						</label>
					</div>
					<div class="elementor-control">
						<div class="crel-panel-buttons">
							<button class="elementor-button elementor-button-success crel-update-preset-button">
								<span class="crel-button-state-icon">
									<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
								</span>
								<span class="crel-button-label">
									<?php esc_html_e( 'Save', 'creative-addons-for-elementor' ); ?>
								</span>
							</button>
							<button class="elementor-button elementor-button-cancel crel-cancel-update-preset-button">
								<span class="crel-button-label">
									<?php esc_html_e( 'Cancel', 'creative-addons-for-elementor' ); ?>
								</span>
							</button>
							<button class="elementor-button crel-elementor-button-error crel-pre-delete-preset-button">
								<span class="crel-button-state-icon">
									<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
								</span>
								<span class="crel-button-label">
									<?php esc_html_e( 'Delete', 'creative-addons-for-elementor' ); ?>
								</span>
							</button>
						</div>
					</div>
				</div>
				<div class="crel-panel-popup--update_preset_2">
					<div class="elementor-control">
						<p><?php esc_html_e( 'Do you want to delete preset?', 'creative-addons-for-elementor' ); ?></p>
					</div>
					<div class="elementor-control">
						<div class="crel-panel-buttons">
							<button class="elementor-button crel-elementor-button-error crel-delete-preset-button">
								<span class="crel-button-state-icon">
									<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
								</span>
								<span class="crel-button-label">
									<?php esc_html_e( 'Yes, delete', 'creative-addons-for-elementor' ); ?>
								</span>
							</button>
							<button class="elementor-button crel-elementor-button-cancel crel-cancel-delete-preset-button">
								<span class="crel-button-state-icon">
									<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
								</span>
								<span class="crel-button-label">
									<?php esc_html_e( 'No', 'creative-addons-for-elementor' ); ?>
								</span>
							</button>
						</div>
					</div>
				</div>
				<div class="elementor-control">
					<div class="crel-update-preset-message"></div>
				</div>
			</div><#
		} #>
		</div><#

		if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div><#
		} #>		<?php
	}
	
	/**
	 * Register scripts for this select type 
	 */
	public function enqueue() {
		
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_style( 'creative_preset', CREATIVE_ADDONS_ASSETS_URL . 'css/admin/admin' . $suffix . '.css' );
		wp_enqueue_script( 'creative_preset', CREATIVE_ADDONS_ASSETS_URL . 'js/creative_preset' . $suffix . '.js', array( 'jquery' ), '', true );
		
		wp_localize_script( 'creative_preset', 'creative_preset_vars', array(
								'reset_style'         => esc_html__( 'Reset Style', 'creative-addons-for-elementor' ),
								'ajax_url' => admin_url('admin-ajax.php'),
								'nonce' => wp_create_nonce('crel_nonce'),
								'custom_presets' => Presets_Handlers::get_option(),
								'select_preset_title' => __( 'Select Custom Preset', 'creative-addons-for-elementor' ),
								'excluded_options' => self::get_excluded_options()
		));
	}

	// get excluded options - most of them are repeater fields
	private static function get_excluded_options() {
		$options = [];

		// Steps
		$options += [ 'crel_steps__list' ];

		// Image GUide
		$options += [ 'crel_image_guide__spots' ];

		return $options;
	}
}
