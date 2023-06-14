<?php

/*
Plugin Name: Filter Objects
Description: Filter custom post type by taxonomy and custom status field.
Version: 1.0.0
Author: Petrushevets Volodymyr
Text Domain: filter-objects
*/

use FilterObjects\Includes\Autoloader;

defined( 'ABSPATH' ) || exit;
const FILTER_OBJECTS_FILE = __FILE__;

require_once dirname( __FILE__ ) . '/includes/Autoloader.php';

$loader = new Autoloader();