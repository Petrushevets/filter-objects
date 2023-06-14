<?php
/**
 * @var array $args
 */
?>

<div class="filter">
    <div class="filter-clear">Clear filter</div>
    <div class="filter-item">
        <span class="filter-label"><?php _e( 'Object type:', 'filter-objects' ); ?></span>
        <ul class="categories-list">
			<?php foreach ( $args['categories'] as $category ) : ?>
                <li class="category-item <?php echo( in_array( $category->slug, $args['slags'] ) ? 'active' : '' ); ?>"
                    data-term-slug="<?php echo $category->slug; ?>">
					<?php echo $category->name; ?>
                </li>
			<?php endforeach; ?>
        </ul>
    </div>
    <div class="filter-item">
        <span class="filter-label"><?php _e( 'Status:', 'filter-objects' ); ?></span>
        <ul>
            <li class="status <?php echo $_GET['status'] ?? 'active'; ?> <?php echo( ( isset( $_GET['status'] ) && $_GET['status'] === 'all' ) ? 'active' : '' ); ?>"
                data-status="all"><?php _e( 'All', 'filter-objects' ); ?></li>
			<?php foreach ( $args['statuses'] as $status ) : ?>
				<?php $isActive = isset( $_GET['status'] ) && $_GET['status'] === $status; ?>
                <li class="status <?php echo $isActive ? 'active' : ''; ?>"
                    data-status="<?php echo $status; ?>">
					<?php echo $status; ?>
                </li>
			<?php endforeach; ?>
        </ul>
    </div>
	<?php $query = $args['query']; ?>
    <div id="objects">
		<?php if ( $query->have_posts() ) : ?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="object-item">
                    <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                </div>
			<?php endwhile; ?>
		<?php else : ?>
            <?php _e( 'Objects not found', 'filter-objects' ); ?>
		<?php endif; ?>
    </div>
</div>