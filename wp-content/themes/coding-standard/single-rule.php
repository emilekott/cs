<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header();

//get section, prev and next sections for nav


?>
 <!-- breadcrumbs -->
    <?php postTypeCrumbs('rule', 'section'); ?>
<div id="primary" class="site-content">
  <div id="content" role="main">

   

    <?php while (have_posts()) : the_post(); ?>
    <?php $terms = wp_get_post_terms( $post->ID, 'section'); 
        //print_r($terms);
        if ($terms[0]->term_id){
          $term = $terms[0]->slug;
          $term_link = home_url().'/section/'.$term;
          $term_link = '<a href="'.$term_link.'">&uarr; Up</a>';
                 
        }?>

      <?php get_template_part('content', get_post_format()); ?>

      <nav class="nav-single">
        <h3 class="assistive-text"><?php _e('Post navigation', 'twentytwelve'); ?></h3>
        <?php //prev and next have been swapped so that they make sense ?>
        <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span> 
        <span class="nav-up"><?php echo $term_link; ?></span>
        <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
      </nav><!-- .nav-single -->
      <a name="respond"></a><a name="comments"></a>
      <?php comments_template('', true); ?>
      
    <?php endwhile; // end of the loop. ?>

  </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>