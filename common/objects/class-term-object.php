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
abstract class Term_Object extends Common\WP_Object {

	protected function init_object( $id ) {

		// add error handling here.
		$term = get_term( $id );

		$this->id      = $term->term_id;
		$this->type    = 'term';
		$this->subtype = $term->taxonomy;

		$this->object = $term;

	}

	protected function create( $args ) {

	}

	protected function destroy() {

	}

	protected function update( $args ) {

	}

}
