<?php

/**
 * Check if displayed user has user tags.
 */
function youzify_is_user_have_user_tags() {

	if ( ! bp_is_active( 'xprofile' ) ) {
		return false;
	}

	// Init Vars
	$have_content = false;

	// Get User Tags
	$user_tags = youzify_option( 'youzify_user_tags' );

	if ( empty( $user_tags ) ) {
		return false;
	}

    foreach ( $user_tags as $tag ) {

        // Get Data
        $field = xprofile_get_field( $tag['field'],  bp_displayed_user_id() );

        // Unserialize Profile field
        $field_value = maybe_unserialize( $field->data->value );

        if ( ! empty( $field_value ) ) {
            $have_content = true;
            break;
        }

    }

    return $have_content;
}


/**
 * Get Xprofile Field Data.
 */
add_shortcode( 'youzify_xprofile_fields', 'youzify_get_xprofile_data_shortcode' );

function youzify_get_xprofile_data_shortcode( $atts ) {

    if ( ! bp_is_active( 'xprofile' ) ) {
        return false;
    }

    $options = shortcode_atts( array(
        'user_id' => bp_displayed_user_id(),
        'fields' => null,
    ), $atts );

    $fields = explode( ',', $options['fields'] );

    if ( empty( $fields ) ) {
        return;
    }

    $content = '';

    // Get Hidden Fields.
    $hidden_fields = bp_xprofile_get_hidden_fields_for_user();

    foreach ( $fields as $field_id ) {

        if ( in_array( $field_id, $hidden_fields ) )  {
            continue;
        }

        // Get Field Value.
        $field_data = apply_filters( 'bp_get_profile_field_data', xprofile_get_field_data( $field_id, $options['user_id'], 'comma' ) );
        // $field_data = bp_get_profile_field_data( array( 'user_id' => $options['user_id'], 'field' => $field_id ), 'comma' );

        // Get Field Data
        $field = new BP_XProfile_Field( $field_id );

        if ( ! empty( $field_data ) ) {
            $content .= '<div class="youzify-info-item youzify-info-item-'. $field_id . '"><div class="youzify-info-label">'. $field->name . '</div><div class="youzify-info-data">' . $field_data . '</div></div>';
        }

    }

    if ( ! empty( $content ) ) {
        $content = '<div class="youzify-infos-content">' . $content . '</div>';
    }

    return $content;
}

/**
 * Get Custom Widgets functions.
 */

add_shortcode( 'youzify_xprofile_group', 'youzify_get_xprofile_group_shortcode' );

function youzify_get_xprofile_group_shortcode( $atts = null ) {

    $options = shortcode_atts( array(
        'user_id' => bp_displayed_user_id() ? bp_displayed_user_id() : bp_loggedin_user_id(),
        'profile_group_id' => false,
    ), $atts );

    if ( ! bp_is_active( 'xprofile' ) ) {
        return false;
    }

    // Include Widgets
    require_once YOUZIFY_CORE . 'class-youzify-widgets.php';
    require_once YOUZIFY_CORE . 'widgets/youzify-widgets/class-youzify-custom-infos.php';

    ob_start();

    do_action( 'bp_before_profile_loop_content' );

    $custom_infos = new Youzify_Profile_Custom_Infos_Widget();

    if ( bp_has_profile( $options ) ) : while ( bp_profile_groups() ) : bp_the_profile_group();

        if ( bp_profile_group_has_fields() ) :

            $group_id = bp_get_the_profile_group_id();

            youzify_widgets()->youzify_widget_core( 'custom_infos', $custom_infos, array(
                'icon'   => youzify_get_xprofile_group_icon( $group_id ),
                'name'  => bp_get_the_profile_group_name(),
                'id'   => 'custom_infos',
                'load_effect' => 'fadeIn'
            ) );

    endif; endwhile;

    endif;
    do_action( 'bp_after_profile_loop_content' );

    return ob_get_clean();
}

/**
 * Get Field Options
 */
function youzify_get_xprofile_field_options( $field_id ) {

    // Get Field Data.
    $field = new BP_XProfile_Field( $field_id );

    // Get Select Box Options.
    $children = $field->get_children();

    $options = wp_list_pluck( $children, 'name' );

    return $options;

}