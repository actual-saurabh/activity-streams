<?php
/**
 * Contains recordable behaviour.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Bodh/Activity_Streams/Common
 */

namespace \Bodh\Activity_Streams\Common\Objects;

use \Bodh\Activity_Streams\Common as Common;

/**
 * Any WP Object
 *
 * @since 1.0.0
 */
abstract class Post_Object extends Common\WP_Object {

	/**
	 * Method init_object initiates the post object.
	 *
	 * @param int $id accepts ID of the object to be initiated.
	 *
	 * @return void
	 */
	protected function init_object( $id ) {

		// add error handling here.
		$post = get_post( $id );

		$this->id      = $post->ID;
		$this->type    = 'post';
		$this->subtype = $post->post_type;

		$this->object = $post;

	}

	/**
	 * Method create adds the post object in the database.
	 *
	 * @param array $args An array of elements that make up a post to update or insert.
	 *
	 * @return int|WP_Error The post ID on success. The value 0 or WP_Error on failure.
	 *
	 * @since 1.0.0
	 */
	protected function create( $args ) {
		$inserted = wp_insert_post( $args, $wp_error = false, $fire_after_hooks = true );
		return $inserted;
	}

	/**
	 * Method destroy deletes the post object from the database.
	 *
	 * @param int  $id           Post ID. Default 0.
	 * @param bool $force_delete Whether to bypass Trash and force deletion.
	 *
	 * @return WP_Post|WP_Error Post data on success, false or null on failure.
	 *
	 * @since 1.0.0
	 */
	protected function destroy( $id, $force_delete ) {
		$destroy = wp_delete_post( $id, $force_delete );
		if ( 0 === $destroy || is_null( $delete ) ) {
			return new WP_Error( 'post-delete-failed', __( "Couldn't delete post", 'activity-streams' ) );
		}
		if ( $destroy instanceof WP_Post ) {
			return $destroy;
		}
	}

	/**
	 * Method update updates the post object in the database.
	 *
	 * @param array $args Post data. Arrays are expected to be escaped, objects are not. See wp_insert_post() for accepted arguments. Default array.
	 *
	 * @return int|WP_Error The post ID on success. WP_Error on failure.
	 *
	 * @since 1.0.0
	 */
	protected function update( $args ) {
		$update = wp_update_post( $args, $wp_error = true, $fire_after_hooks = true );
		return $update;
	}

}
