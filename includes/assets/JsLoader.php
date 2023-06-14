<?php

namespace FilterObjects\Includes\Assets;

use FilterObjects\Includes\Contracts\Assets;

defined( 'ABSPATH' ) || exit;

class JsLoader implements Assets {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	public function enqueue() {
		wp_enqueue_script( 'filter-objects', plugin_dir_url( FILTER_OBJECTS_FILE ) . 'assets/js/filter.js', 'jquery', time(), true );
		wp_localize_script( 'filter-objects', 'filter_object', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ] );
	}
}