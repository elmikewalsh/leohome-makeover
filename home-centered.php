<?php
/**
 * Template Name: Centered Home Page
 */
?>
<?php get_header(); ?>

		<h2><?php the_title(); ?></h2>


		<div id="leo-centered-home">
        <div class="wrapper grid4">
			<?php wp_nav_menu( array('theme_location'  => 'primary', 'fallback_cb' => false, 'container_class' => 'nav', 'menu_id' => 'nav', 'walker' => new centered_description_walker() ) ); ?>
        </div>
        <div class="wrapper fullwidth">
            <?php wp_nav_menu( array('theme_location'  => 'latest_post', 'fallback_cb' => false, 'container_class' => 'latestpost', 'menu_id' => 'nav', 'walker' => new centered_description_walker() ) ); ?>
        </div>

		</div> <!-- /end #leo -->

<?php get_footer(); ?>