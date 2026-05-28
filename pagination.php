<?php

if ( isset( $portfolio_posts_query ) ) {

	// Use the manual query created by template-portfolio.php if it exists, or...
	$pagination_query = $portfolio_posts_query;

} else {

	// ...the default $wp_query.
	global $wp_query;
	$pagination_query = $wp_query;
}

// Set the type of pagination to use. Available types: button, links, scroll, and numbers.
$pagination_type = get_theme_mod( 'eksell_pagination_type', 'button' );

// -----------------------------------------------------------------------
// Numbered pagination – output paginate_links() and exit early.
// -----------------------------------------------------------------------
if ( $pagination_type === 'numbers' ) :

	$total_pages  = $pagination_query->max_num_pages;
	$current_page = max( 1, get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? (int) get_query_var( 'page' ) : 1 ) );

	// Build query args array so the AJAX category filter can reuse the #pagination element.
	$numbers_query_args = array_merge( $pagination_query->query, $pagination_query->query_vars );
	if ( ! array_key_exists( 'max_num_pages', $numbers_query_args ) ) {
		$numbers_query_args['max_num_pages'] = $pagination_query->max_num_pages;
	}
	if ( ! array_key_exists( 'post_status', $numbers_query_args ) ) {
		$numbers_query_args['post_status'] = 'publish';
	}
	if ( ! array_key_exists( 'paged', $numbers_query_args ) || 0 == $numbers_query_args['paged'] ) {
		$numbers_query_args['paged'] = $current_page;
	}

	if ( $total_pages > 1 ) :
		?>
		<div class="pagination-wrapper pagination-type-numbers">

			<?php /* Hidden #pagination container keeps the AJAX category filter working */ ?>
			<div id="pagination" class="section-inner" style="display:none;" data-query-args="<?php echo esc_attr( wp_json_encode( $numbers_query_args ) ); ?>" data-pagination-type="numbers" data-load-more-target=".load-more-target"></div>

			<nav class="numbered-pagination section-inner" aria-label="<?php esc_attr_e( 'Page navigation', 'grand4you' ); ?>">
				<?php
				echo paginate_links( array(
					'base'      => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
					'format'    => '?paged=%#%',
					'current'   => $current_page,
					'total'     => $total_pages,
					'prev_text' => '<span class="arrow stroke-cc">' . eksell_get_theme_svg( 'ui', 'arrow-left', 96, 49 ) . '</span><span class="screen-reader-text">' . esc_html__( 'Previous', 'grand4you' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next', 'grand4you' ) . '</span><span class="arrow stroke-cc">' . eksell_get_theme_svg( 'ui', 'arrow-right', 96, 49 ) . '</span>',
					'type'      => 'list',
				) );
				?>
				<p class="page-counter">
					<?php
					printf(
						/* translators: 1 = current page number, 2 = total pages */
						esc_html_x( 'Page %1$s of %2$s', 'numbered pagination counter', 'grand4you' ),
						'<span class="current-page">' . esc_html( $current_page ) . '</span>',
						'<span class="total-pages">' . esc_html( $total_pages ) . '</span>'
					);
					?>
				</p>
			</nav>
		</div><!-- .pagination-wrapper -->
		<?php
	else :
		// Single page: still render hidden #pagination so the filter has an anchor point.
		?>
		<div id="pagination" style="display:none;" data-query-args="<?php echo esc_attr( wp_json_encode( $numbers_query_args ) ); ?>" data-pagination-type="numbers" data-load-more-target=".load-more-target"></div>
		<?php
	endif;

	return; // Exit – no load-more / AJAX output needed for numbered pagination.
endif;

// -----------------------------------------------------------------------
// Load-more / links pagination (existing behaviour).
// -----------------------------------------------------------------------

// Combine the query with the query_vars into a single array.
$query_args = array_merge( $pagination_query->query, $pagination_query->query_vars );

// If max_num_pages is not already set, add it.
if ( ! array_key_exists( 'max_num_pages', $query_args ) ) {
	$query_args['max_num_pages'] = $pagination_query->max_num_pages;
}

// If post_status is not already set, add it.
if ( ! array_key_exists( 'post_status', $query_args ) ) {
	$query_args['post_status'] = 'publish';
}

// Make sure the paged value exists and is at least 1.
if ( ! array_key_exists( 'paged', $query_args ) || 0 == $query_args['paged'] ) {
	$query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
}

// Encode our modified query.
$json_query_args = wp_json_encode( $query_args );

// Set up the wrapper class.
$wrapper_class = 'pagination-type-' . $pagination_type;

// Indicate when we're loading into the last page, so the pagination can be hidden for the button and scroll types.
if ( ! ( $query_args['max_num_pages'] > $query_args['paged'] ) ) {
	$wrapper_class .= ' last-page';
} else {
	$wrapper_class .= '';
}

?>

<div class="pagination-wrapper <?php echo esc_attr( $wrapper_class ); ?>">

	<div id="pagination" class="section-inner" data-query-args="<?php echo esc_attr( $json_query_args ); ?>" data-pagination-type="<?php echo esc_attr( $pagination_type ); ?>" data-load-more-target=".load-more-target">

		<?php

		if ( ( $query_args['max_num_pages'] > $query_args['paged'] ) ) :

			if ( $pagination_type == 'scroll' ) :
				?>
				<div class="scroll-loading">
					<div class="loading-icon">
						<span class="dot-pulse"></span>
					</div>
				</div>
				<?php
			endif;

			if ( $pagination_type == 'button' ) :
				?>
				<button id="load-more" class="d-no-js-none do-spot spot-fade-up">
					<span class="load-text"><?php esc_html_e( 'Load More', 'grand4you' ); ?></span>
					<span class="loading-icon"><span class="dot-pulse"></span></span>
				</button>
				<?php
			endif;

		endif;

		// The pagination links also work as a no-js fallback, so they always need to be output.
		$prev_link = get_previous_posts_link( '<span class="arrow stroke-cc">' . eksell_get_theme_svg( 'ui', 'arrow-left', 96, 49 ) . '</span><span class="screen-reader-text">' . esc_html__( 'Previous Page', 'grand4you' ) . '</span></span>', $query_args['max_num_pages'] );
		$next_link = get_next_posts_link( '<span class="screen-reader-text">' . esc_html__( 'Next Page', 'grand4you' ) . '</span></span><span class="arrow stroke-cc">' . eksell_get_theme_svg( 'ui', 'arrow-right', 96, 49 ) . '</span>', $query_args['max_num_pages'] );

		if ( $prev_link || $next_link ) :
			$pagination_class = ! $prev_link ? ' only-next' : ( ! $next_link ? ' only-previous' : '' );
			?>

			<nav class="link-pagination<?php echo esc_attr( $pagination_class ); ?>">

				<?php if ( $prev_link ) : ?>
					<div class="previous-wrapper">
						<?php echo $prev_link; ?>
					</div><!-- .previous-wrapper -->
				<?php endif; ?>

				<?php if ( $next_link ) : ?>
					<div class="next-wrapper">
						<?php echo $next_link; ?>
					</div><!-- .next-wrapper -->
				<?php endif; ?>

			</nav><!-- .posts-pagination -->

		<?php endif; ?>

	</div><!-- #pagination -->

</div><!-- .pagination-wrapper -->