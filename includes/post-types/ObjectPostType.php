<?php

namespace FilterObjects\Includes\PostTypes;

defined( 'ABSPATH' ) || exit;

/**
 * Register object post types
 */
class ObjectPostType {
	const POST_TYPE = 'object';
	const POST_TAXONOMY = 'object-category';

	public function __construct() {
		add_action( 'init', [ $this, 'register_object_post_type' ] );
	}

	/**
	 * Register object post type
	 *
	 * @return void
	 */
	public function register_object_post_type() {
		$labels = [
			'name'               => __( 'Objects', 'filter-objects' ),
			'singular_name'      => __( 'Object', 'filter-objects' ),
			'menu_name'          => __( 'Objects', 'filter-objects' ),
			'name_admin_bar'     => __( 'Object', 'filter-objects' ),
			'add_new'            => __( 'Add Object', 'filter-objects' ),
			'add_new_item'       => __( 'Add New Object', 'filter-objects' ),
			'new_item'           => __( 'New Object', 'filter-objects' ),
			'edit_item'          => __( 'Edit Object', 'filter-objects' ),
			'view_item'          => __( 'View Object', 'filter-objects' ),
			'all_items'          => __( 'Objects', 'tutor' ),
			'search_items'       => __( 'Search Objects', 'filter-objects' ),
			'parent_item_colon'  => __( 'Parent Objects:', 'filter-objects' ),
			'not_found'          => __( 'No objects found.', 'filter-objects' ),
			'not_found_in_trash' => __( 'No objects found in Trash.', 'filter-objects' ),
		];

		$args = [
			'labels'       => $labels,
			'description'  => __( 'Description.', 'filter-objects' ),
			'public'       => true,
			'show_ui'      => true,
			'query_var'    => true,
			'has_archive'  => true,
			'taxonomies'   => [ self::POST_TAXONOMY ],
			'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'custom-fields' ],
			'show_in_rest' => true,
		];

		register_post_type( self::POST_TYPE, $args );

		/**
		 * Taxonomy
		 */
		$labels = [
			'name'                  => __( 'Object Categories', 'filter-objects' ),
			'singular_name'         => __( 'Category', 'tutor' ),
			'search_items'          => __( 'Search Categories', 'filter-objects' ),
			'all_items'             => __( 'All Categories', 'filter-objects' ),
			'edit_item'             => __( 'Edit Category', 'filter-objects' ),
			'update_item'           => __( 'Update Category', 'filter-objects' ),
			'add_new_item'          => __( 'Add New Category', 'filter-objects' ),
			'new_item_name'         => __( 'New Category Name', 'filter-objects' ),
			'add_or_remove_items'   => __( 'Add or remove categories', 'filter-objects' ),
			'choose_from_most_used' => __( 'Choose from the most used categories', 'filter-objects' ),
			'not_found'             => __( 'No categories found.', 'filter-objects' ),
			'menu_name'             => __( 'Object Categories', 'filter-objects' ),
		];

		$args = [
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
		];

		register_taxonomy( self::POST_TAXONOMY, self::POST_TYPE, $args );
	}
}
