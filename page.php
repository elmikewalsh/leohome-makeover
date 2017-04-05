<?php get_header(); ?>

		<div id="leo-centered">
		<h2><?php the_title(); ?></h2>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?>

			<?php wp_link_pages(array('before' => __('<p><strong>Pages:</strong> '), 'after' => '</p>', 'next_or_number' => 'number')); ?>

			<h5><?php edit_post_link(__('Edit'), '<p>', '</p>'); ?></h5>
				
		<?php endwhile; endif; ?>
        </div>
<?php get_footer(); ?>