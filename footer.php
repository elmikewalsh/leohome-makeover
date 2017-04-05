
    <?php wp_nav_menu( array('theme_location'  => 'footer_menu', 'fallback_cb' => false, 'sort_column' => 'menu_order', 'container_class' => 'footer', 'after' => '&nbsp;<li class="menu-divider">|</li>' ) ); ?>

<?php if (get_option('leohomemakeover_credits') ==''); ?><?php echo ('<p class="credits">'.get_option('leohomemakeover_credits').'</p>'); ?>

	<?php wp_footer(); ?>

</body>
</html>