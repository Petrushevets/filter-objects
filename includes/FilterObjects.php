<?php

namespace FilterObjects\Includes;

use FilterObjects\Includes\PostTypes\ObjectPostType;

defined( 'ABSPATH' ) || exit;

class FilterObjects {

	public ObjectPostType $objectPostType;

	protected static ?self $instance = null;

	/**
	 * Get the singleton instance of the class.
	 *
	 * @return self
	 */
	public static function instance(): self {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function init(): void {
		$this->components();
	}

	/**
	 * @return void
	 */
	private function components(): void {
		$this->objectPostType = new ObjectPostType();
	}
}