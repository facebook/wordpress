<?php
function fb_get_recommendations_bar($options = array()) {
	return '<div class="fb-recommendations-bar fb-social-plugin" ' . fb_build_social_plugin_params($options) . '></div>';
}

function fb_recommendations_bar_automatic( $content ) {
	global $post;

	$show_indiv = get_post_meta( $post->ID, 'fb_social_plugin_settings_box_recommendations_bar', true );
	$options = get_option('fb_options');

	if ( !is_home() && ( 'default' == $show_indiv || empty( $show_indiv ) ) && isset( $options['recommendations_bar']['show_on']) && isset( $options['recommendations_bar']['show_on'][$post->post_type] ) )  {
		$content .= fb_get_recommendations_bar( $options['recommendations_bar'] );
	} else if ( !is_home() && ( 'show' == $show_indiv || ( ( ! isset( $options['recommendations_bar']['show_on'] ) ) && ( 'default' == $show_indiv || empty( $show_indiv ) ) ) ) ) {
		$content .= fb_get_recommendations_bar( $options['recommendations_bar'] );
	}
	//elseif ( 'no' == $show_indiv ) {
	//}

	return $content;
}


function fb_get_recommendations_bar_fields($placement = 'settings', $object = null) {
	$fields_array = fb_get_recommendations_bar_fields_array();

	fb_construct_fields($placement, $fields_array['children'], $fields_array['parent'], $object);
}

function fb_get_recommendations_bar_fields_array() {
	$array['parent'] = array(
		'name' => 'recommendations_bar',
		'label' => __( 'Recommendations Bar', 'facebook' ),
		'help_link' => 'https://developers.facebook.com/docs/reference/plugins/recommendationsbar/',
		'description' => __( 'The Recommendations Bar allows users to click to start getting recommendations, Like content, and add what they\'re reading to Timeline as they go.', 'facebook' ),
		'image' => plugins_url( '/images/settings_recommendations_bar.png', dirname(__FILE__) )
	);

	$post_types = get_post_types(array('public' => true));
	$array['children'] = array(
		array(
			'name' => 'trigger',
			'type' => 'text',
			'default' => '50',
			'help_text' => __( 'This specifies the percent of the page the user must scroll down before the plugin is expanded.', 'facebook' )
		),
		array(
			'name' => 'read_time',
			'type' => 'text',
			'default' => '20',
			'help_text' => __( 'The number of seconds the plugin will wait until it expands.', 'facebook' )
		),
		array(
			'name' => 'action',
			'type' => 'dropdown',
			'default' => 'like',
			'options' => array(
				'like' => 'like',
				'recommend' => 'recommend'
			),
			'help_text' => __( 'The verb to display in the button.', 'facebook' )
		),
		array(
			'name' => 'side',
			'type' => 'dropdown',
			'default' => 'right',
			'options' => array(
				'left' => 'left',
				'right' => 'right'
			),
			'help_text' => __( 'The side of the window that the plugin will display.', 'facebook' )
		),
		array(
			'name' => 'show_on',
			'type' => 'checkbox',
			'default' => array_fill_keys( array_keys($post_types) , 'true' ),
			'options' => $post_types,
			'help_text' => __( 'Whether the plugin will appear on all posts or pages by default. If "individual posts and pages" is selected, you must explicitly set each post and page to display the plugin.', 'facebook' )
		)
	);

	return $array;
}

?>
