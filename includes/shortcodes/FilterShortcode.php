<?php

namespace FilterObjects\Includes\Shortcodes;

use WP_Query;

defined( 'ABSPATH' ) || exit;

class FilterShortcode {

	public function __construct() {
		add_shortcode( 'object_filter', [ $this, 'filter' ] );
	}

	/**
	 * Render filter.
	 *
	 * @return void
	 */
	public function filter(): void {
		$args = [
			'categories' => $this->getCategories(),
			'statuses'   => $this->getStatuses(),
			'slags'      => $this->getParametersSlags(),
			'query'      => $this->getObjects()
		];

		load_template( dirname( FILTER_OBJECTS_FILE ) . '/templates/shortcode/filter.php', true, $args );
	}

	/**
	 * Get object statuses.
	 *
	 * @return array
	 */
	public function getStatuses(): array {
		$statuses = [];

		$args = [
			'posts_per_page' => - 1,
			'post_type'      => 'object',
			'post_status'    => [ 'publish' ]
		];

		$query = new WP_Query( $args );

		foreach ( $query->posts as $post ) {
			$statuses[] = get_post_meta( $post->ID, 'status', true );
		}

		return array_filter( array_unique( $statuses ), function ( $element ) {
			return ! empty( $element );
		} );
	}

	/**
	 * Get category slugs.
	 *
	 * @return array
	 */
	private function getCategoriesSlags(): array {
		$slugs      = [];
		$categories = $this->getCategories();

		foreach ( $categories as $category ) {
			$slugs[] = $category->slug;
		}

		return $slugs;
	}

	/**
	 * Get category slugs from url.
	 *
	 * @return false|string[]
	 */
	private function getParametersSlags() {
		return isset( $_GET['categories'] ) ? explode( ',', $_GET['categories'] ) : [];
	}

	/**
	 * Get the categories.
	 *
	 * @return array
	 */
	private function getCategories(): array {
		return get_terms(
			[
				'taxonomy' => 'object-category',
				'orderby'  => 'name'
			]
		);
	}

	/**
	 * Get the objects.
	 *
	 * @return WP_Query
	 */
	private function getObjects(): WP_Query {
		$args = [
			'posts_per_page' => - 1,
			'post_type'      => 'object',
			'post_status'    => [ 'publish' ],
			'orderby'        => 'id',
			'order'          => 'desc',
			'tax_query'      => [
				[
					'taxonomy' => 'object-category',
					'field'    => 'slug',
					'terms'    => $this->getCategoriesSlags()
				]
			]
		];

		if ( isset( $_GET['categories'] ) ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'object-category',
					'field'    => 'slug',
					'terms'    => $this->getParametersSlags()
				]
			];
		}

		if ( isset( $_GET['status'] ) && $_GET['status'] !== 'all' ) {
			$args['meta_query'] = [
				[
					'key'   => 'status',
					'value' => sanitize_text_field( $_GET['status'] ),
				]
			];
		}

		return new WP_Query( $args );
	}
}
