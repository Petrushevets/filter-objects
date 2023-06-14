<?php

namespace FilterObjects\Includes\Assets;

use FilterObjects\Includes\Contracts\Assets;

defined( 'ABSPATH' ) || exit;

class CssLoader implements Assets {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	public function enqueue() {
		wp_enqueue_style( 'filter-objects', plugin_dir_url( FILTER_OBJECTS_FILE ) . 'assets/css/filter.css', null, time() );
	}
}