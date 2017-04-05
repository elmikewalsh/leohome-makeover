<?php get_header(); ?>

		<div id="leo-centered">

		<h2><?php the_title(); ?></h2>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<div class="post"> 

        <h4><?php echo __('by'); ?> <?php if ( get_theme_mod('leohomemakeover_author_link') ) { ?><a <?php echo ( get_theme_mod( 'leohomemakeover_extlink' ) ) ? "target='_blank'" : "" ?> href="<?php the_author_url(); ?>"><?php the_author(); ?></a><?php } else { the_author_posts_link(); } ?></h4>
			<?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?>
		</div> <!-- /end .post -->
		<h5><?php edit_post_link(__('Edit'), '<p>', '</p>'); ?></h5>

	
		<?php endwhile; else: ?>

			<p><?php echo __('Sorry, no posts matched your criteria.'); ?></p>

		<?php endif; ?>

        </div>
<?php get_footer(); ?>