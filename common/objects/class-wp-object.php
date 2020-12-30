<?php
/**
 * Contains recordable behaviour.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package activity_streams/common/objects
 */

namespace \Bodh\Activity_Streams\Common\Objects;

use \Bodh\Activity_Streams\Common as Common;

/**
 * Any WP Object
 *
 * @since 1.0.0
 */
abstract class WP_Object {

	public $id;

	public $type;

	public $subtype;

	public $object;

	use Common\Traits\Relative;
	use Common\Traits\Error;

	/**
	 * Undocumented function
	 *
	 * @param [type] $id
	 * @param [type] $type
	 * @param [type] $subtype
	 * @return void
	 */
	protected function init_object( $id ) {

	}

	protected function __construct( $id ) {

		// setup empty object if no ID was provided.
		if ( empty( $id ) ) {
			return;
		}

		$this->init_object( $id );
	}

	protected function create( $args ) {

	}

	protected function destroy() {

	}

	protected function update( $args ) {

	}

}
