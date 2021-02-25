<?php
/**
 * Activity Streams
 *
 * @package           Bodh/Activity_Streams
 * @author            Saurabh, Parth
 * @copyright         none
 * @license           MIT
 *
 * @wordpress-plugin
 * Plugin Name:       Activity Streams
 * Plugin URI:        https://github.com/actual-saurabh/activity-streams
 * Description:       Records the activity of your e learning coursez.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4.3
 * Author:            Saurabh, Parth
 * Author URI:        https://github.com/actual-saurabh
 * Text Domain:       activity-streams
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 */

add_action( 'wp_loaded', 'register_custom_posts', 50, 0 );

/**
 * Method register_custom_posts
 *
 * @return void
 */
function register_custom_posts() {
	$args_step = array(
		'label'	       => 'Step',
		'description'  => 'Smallest achiavable item in Path',
		'show_ui'      => true,
		'show_in_menu' => true,
	);
	$args_path = array(
		'label'	       => 'Path',
		'description'  => 'Smallest achiavable item in Plan',
		'show_ui'      => true,
		'show_in_menu' => true,
	);
	$args_plan = array(
		'label'	       => 'Plan',
		'description'  => 'largest Planned item',
		'show_ui'      => true,
		'show_in_menu' => true,
	);
	register_post_type( 'step', $args_step );
	register_post_type( 'path', $args_path );
	register_post_type( 'plan', $args_plan );
}
