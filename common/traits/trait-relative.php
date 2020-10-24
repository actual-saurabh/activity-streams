<?php
/**
 * Contains relative behaviour.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Bodh/Activity_Streams/Common
 */

namespace \Bodh\Activity_Streams\Common\Traits;

/**
 * Methods for relatives.
 *
 * @todo Figure out relationships a little better.
 * Are relationships mutual or are we only thinking of one-way relationships.
 *
 * @since 1.0.0
 */
trait Relative {

	/**
	 * Adds relatives.
	 *
	 * @param [type] $relatives
	 * @return void
	 */
	public function add_relatives( $relatives ) {

		if ( ! $relatives ) {

			// Bail, with error.
			$this->error(
				'empty-relative',
				__( 'Please provide a relative to add, when adding a relative', 'bodh' ),
			);

			return false;
		}

		if ( ! is_array( $relatives ) ) {
			$relatives = array( $relatives );
		}

		foreach ( $relatives as $relative ) {
			$this->set_relative( $relative );
		}
	}

	/**
	 * Removes relatives.
	 *
	 * @param [type] $relatives
	 * @return void
	 */
	public function remove_relatives( $relatives ) {

		if ( ! $relatives ) {

			// Bail, with error.
			$this->error(
				'empty-relative',
				__( 'Please provide a relative to remove, when removing a relative', 'bodh' ),
			);

			return false;
		}

		if ( ! is_array( $relatives ) ) {
			$relatives = array( $relatives );
		}

		foreach ( $relatives as $relative ) {
			$this->unset_relative( $relative );
		}
	}

	/**
	 * Sets a relative.
	 *
	 * @since 1.0.0
	 *
	 * @param int|WP_Post $relative Relative (post id or post object) to add.
	 * @return int|bool Result of update_metadata() function.
	 */
	private function set_relative( $relative ) {

		// Get the post object if an ID was provided.
		if ( is_int( $relative ) ) {
			$relative = get_post( $relative );
		}

		// Bail, if invalid relative.
		if ( ! $relative || ! is_a( $relative, 'WP_Post' ) ) {

			// setup error data.
			$error_data = array(
				'relative' => $relative,
			);

			// Bail, with error.
			$this->error(
				'invalid-relative',
				__( 'Please provide a valid relative to add.', 'bodh' ),
				$error_data
			);

			return false;
		}

		// Set up meta key fragments.
		$meta_key_fragments = array(
			'prefix'   => $prefix,
			'type'     => $relative->post_type,
		);

		// Generate meta key.
		$meta_key = '_' . implode( '_', $meta_key_fragments );

		$existing = get_metadata( $this->type, $this->id, $meta_key, false );

		if ( in_array( $relative->ID, $existing, true ) ) {
			return true;
		}

		// update relative meta.
		return add_metadata( $this->type, $this->id, $meta_key, $relative->ID );
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $relative
	 * @return void
	 */
	private function unset_relative( $relative ) {

		// Get the post object if an ID was provided.
		if ( is_int( $relative ) ) {
			$relative = get_post( $relative );
		}

		// Bail, if invalid relative.
		if ( ! $relative || ! is_a( $relative, 'WP_Post' ) ) {

			// setup error data.
			$error_data = array(
				'relative'        => $relative,
			);

			// Bail, with error.
			$this->error(
				"$prefix-incomplete-relative",
				__( 'Please provide a valid relative to remove.', 'bodh' ),
				$error_data
			);

			return false;
		}

		// Set up meta key fragments.
		$meta_key_fragments = array(
			'prefix'   => $prefix,
			'type'     => $relative->post_type,
		);

		// Generate meta key.
		$meta_key = '_' . implode( '_', $meta_key_fragments );

		$existing = get_metadata( $this->type, $this->id, $meta_key, false );

		if ( ! in_array( $relative->ID, $existing, true ) ) {
			return true;
		}

		// update relative meta.
		return delete_metadata( $this->type, $this->id, $meta_key, $relative->ID );

	}

	/**
	 * Get all objects that are relatives of this object.
	 *
	 * Don't use this method directly. Create appropriate public/private methods to wrap this method.
	 *
	 * @param string|array $post_type A single post type or an array of post types.
	 * @return array An array of post IDs.
	 */
	private function _get_relatives_of_object__posts( $post_type ) {

		if ( empty( $post_type ) ) {
			// find a way to get all post types?
		}

		// convert a single post type to an array.
		if ( is_string( $post_type ) ) {
			$post_type = array( $post_type );
		}

		// bail, if we still don't have an array.
		if ( ! is_array( $post_type ) ) {
			$this->error( "$prefix-invalid-post-type", __( 'An invalid post type was specified when getting relatives of current object.', 'bodh' ) );
			return false;
		}

		// setup array to store relatives.
		$relatives = array();

		// fill up with relatives of each type.
		foreach ( $post_type as $type ) {
			$relatives += array( $type => $this->get_relatives_of_object_by_type( $type ) );
		}

		return $relatives;
	}

	/**
	 * Get all posts of a type that this object is a relative of.
	 *
	 * @since 1.0.0
	 *
	 * @param string $post_type
	 * @return array
	 */
	private function _get_relatives_of_object_by_type( $post_type ) {
		// Set up meta key fragments.
		$meta_key_fragments = array(
			'prefix'   => $prefix,
			'type'     => $post_type,
		);

		// Generate meta key.
		$meta_key = '_' . implode( '_', $meta_key_fragments );

		return get_metadata( $this->type, $this->id, $meta_key, false );
	}

	/**
	 * Get objects that this object is a relative of.
	 *
	 * Don't use this method directly. Create appropriate public/private methods to wrap this method.
	 *
	 * @since 1.0.0
	 *
	 * @param null|string|array $post_type A single post type or an array of post types. Null for all post types.
	 * @return array An array of post IDs.
	 */
	private function _get_object_is_relative_of__posts( $post_type = null ) {

		// if this is not a post type, bail with error.
		if ( 'post' !== $this->type ) {
			// Translators: WordPress object type.
			$error_msg = sprintf( __( '%s Objects cannot be relatives', 'bodh' ), ucfirst( $this->type ) );
			$this->error( "$prefix-invalid-object", $error_msg );
			return array();
		}

		// if no post type is specified, allow any.
		if ( empty( $post_type ) ) {
			$post_type = 'any';
		}

		// right now, post type should either be a string (single post type) or an array.
		if ( ! is_string( $post_type ) || ! is_array( $post_type ) ) {
			$this->error( "$prefix-invalid-post-type", __( 'An invalid post type was specified when getting posts that the current object is a relative of.', 'bodh' ) );
			return array();
		}

		// Set up meta key fragments.
		$meta_key_fragments = array(
			'prefix'   => $prefix,
			'type'     => $this->subtype,
		);

		// Generate meta key.
		$meta_key = '_' . implode( '_', $meta_key_fragments );

		/**
		 * Runs before query for posts that this object is a relative of, is set up.
		 *
		 * @since 1.0.0
		 *
		 * @param int    $id     The post ID of the current object.
		 * @param object $object The current wp object
		 */
		do_action( 'bodh_activity_stream_before_relative_of_query', $this->id, $this );

		$post_args = array(
			'meta_query' => array(
				array(
					'meta_key'   => $meta_key,
					'meta_value' => $this->id,
					'type'       => 'NUMERIC',
				),
			),
			'fields'     => 'ids',
			'post_type'  => $post_type,
		);

		/**
		 * Filters arguments for WP_Query for objects that are relative of an object.
		 *
		 * @since 1.0.0
		 *
		 * @param array $post_args WP_Query arguments.
		 */
		$post_args = apply_filters( 'bodh_activity_stream_relative_of_query', $post_args );

		$indirect_relative_query = new WP_Query( $post_args );

		/**
		 * Runs after query for posts that this object is a relative of, is run.
		 *
		 * @since 1.0.0
		 *
		 * @param int    $id     The post ID of the current object.
		 * @param object $object The current wp object
		 */
		do_action( 'bodh_activity_stream_after_relative_of_query', $this->id, $this );

		return $indirect_relative_query->posts;
	}
}
