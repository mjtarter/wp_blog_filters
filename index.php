<div class="container blog-archive">
	<div class="row">
		<?php $categories = get_categories(); ?>
		<ul class="cat-list">
			<li class="category-all-filter">All</li>
		  	<?php foreach($categories as $category) : ?>
		    	<li class="<?= $category->slug; ?>-filter"><?= $category->name; ?></li>
		  	<?php endforeach; ?>
		</ul>

		<?php
		//Display posts from the current page and set the ‘paged’ parameter to 1 when the query variable is not set (first page).
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$attr = array(
		  'posts_per_page' => 6,
		  'orderby' => 'date',
		  'order' => 'DESC',
		  'paged' => $paged, //number of page
		);
		$query = new WP_Query($attr);
		if($query->have_posts()) :?>

		<?php
			while($query->have_posts()) : $query->the_post();?>
				<?php
				$categories = get_the_category();
				$cat_slug = '';
				if ( ! empty( $categories ) ) {
					foreach ( $categories as $cat ) {
				    	$cat_slug .= $cat->slug . ' ';
				  	}
				}
				?>
				<div class="col-md-6 col-lg-4 <?php echo $cat_slug;?> category-all">
					<a href="<?php echo get_permalink();?>" class="blog-archive-col">
						<div class="blog-img" style="background-image:url(<?php echo get_field('featured_image'); ?>)"></div>
						<?php $categories = get_the_category();
						if ( ! empty( $categories ) ) {
						    echo '<p class="post-cat">' . esc_html( $categories[0]->name ) . '</p>';
						}?>
						<p class="blog-date"><?php echo get_the_date();?></p>
						<h2><?php the_title();?></h2>
						<p class="read-more">Read More <i class="fa-solid fa-arrow-right-long"></i></p>
					</a>
				</div>
			<?php endwhile; ?>
			<div class="container pagination-wrap">
			<?php
				$big = 999999999; // need an unlikely integer
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'prev_text' => __('<i class="fa-solid fa-arrow-left-long"></i>'),
		  			'next_text' => __('<i class="fa-solid fa-arrow-right-long"></i>'),
					'total' => $query->max_num_pages
				) );?>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php get_template_part( 'template-parts/content-cta-blog'); ?>

<!-- Category Filtering Scripts -->
<script>
jQuery('.category-all-filter').click(function () {
	jQuery('.category-all').removeClass("d-none");
});
</script>

<?php $categories = get_categories(); ?>
<?php $counter == 0; ?>
<?php foreach($categories as $category) : ?>
	<script>
	var category_slug_<?php echo $counter;?> = "<?php echo $category->slug; ?>";
	jQuery('.'+category_slug_<?php echo $counter;?>+'-filter').click(function () {
		jQuery('.category-all').addClass("d-none");
	    jQuery('.'+category_slug_<?php echo $counter;?>).removeClass("d-none");
	});
	</script>
	<?php $counter++; ?>
<?php endforeach; ?>
