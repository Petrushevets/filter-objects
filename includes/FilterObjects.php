<?php

namespace FilterObjects\Includes;

use FilterObjects\Includes\Assets\CssLoader;
use FilterObjects\Includes\Assets\JsLoader;
use FilterObjects\Includes\PostTypes\ObjectPostType;
use FilterObjects\Includes\Shortcodes\FilterShortcode;

defined( 'ABSPATH' ) || exit;

class FilterObjects {

	public ObjectPostType $objectPostType;

	public FilterShortcode $filterShortcode;

	public CssLoader $cssLoader;

	public JsLoader $jsLoader;

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
		$this->objectPostType  = new ObjectPostType();
		$this->filterShortcode = new FilterShortcode();
		$this->cssLoader       = new CssLoader();
		$this->jsLoader        = new JsLoader();
	}
}