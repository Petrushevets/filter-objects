<?php

namespace FilterObjects\Includes\Ajax;

use WP_Query;

defined( 'ABSPATH' ) || exit;

class AjaxRequest {
	public function __construct() {
		add_action( 'wp_ajax_filter', [ $this, 'filter' ] );
		add_action( 'wp_ajax_nopriv_filter', [ $this, 'filter' ] );
	}

	/**
	 * Filters objects.
	 *
	 * @return void
	 */
	public function filter(): void {
		$objects = [];
		$message = '';

		$args = [
			'posts_per_page' => - 1,
			'post_type'      => 'object',
			'post_status'    => [ 'publish' ],
			'orderby'        => 'id',
			'order'          => 'desc',
		];

		if ( isset( $_POST['terms'] ) ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'object-category',
					'field'    => 'slug',
					'terms'    => $_POST['terms']
				]
			];
		}

		if ( isset( $_POST['status'] ) && $_POST['status'] !== 'all' ) {
			$args['meta_query'] = [
				[
					'key'   => 'status',
					'value' => $_POST['status'],
				],
			];
		}

		$query = new WP_Query( $args );

		foreach ( $query->posts as $post ) {
			$objects[] = [
				'title' => $post->post_title,
				'link'  => get_permalink( $post )
			];
		}

		if ( ! $query->have_posts() ) {
			$message = __( 'Objects not found', 'filter-objects' );
		}

		wp_send_json_success(
			$objects ?: $message
		);
	}
}