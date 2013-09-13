<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
</div><!-- #main .wrapper -->
<footer id="colophon" role="contentinfo">
  <div class="site-info">
    <div class="copyright">
      Copyright <?php echo date("Y"); ?>, Programming Research Ltd. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      <a href="<?php echo home_url(); ?>/privacy-policy">Privacy Policy</a>
    </div>
    <div class="sponsored">
      <a href="http://www.programmingresearch.com/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sponsored.jpg"</a>
    </div>
    <div style ="clear:both"></div>
  </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>