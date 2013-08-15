<?php
/**
 *
 * Tempate to display a section
 * 
 * If a section contains sections:
 * 1. Show index of all subsections. If has parent, show up link
 * 
 * If a section contains posts:
 * 2. If contains only 1, show full post. If has parent, show uplink
 * 3. Otherwise, index of posts with uplink
 * 
 * 
 * 
 */
get_header();
?>

<section id="primary" class="site-content">
  <div id="content" role="main">

    <!-- breadcrumbs -->
    <?php postTypeCrumbs('rule', 'section'); ?>
    <?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); ?>

    <!-- main heading -->
    <header class="entry-header">
      <h1 class="entry-title"><?php echo $term->name; ?></h1>
    </header><!-- .archive-header -->



    <?php if (have_posts()) : //case 1, 2 or 3 ?>





      <?php
      $args = array(
        'child_of' => $term->term_id,
        'hide_empty' => false,
        'parent' => $term->term_id
      );
      $children = get_terms('section', $args);


      if (sizeof($children) > 0) {
        //case 1
        //
        // get list of child terms with permalinks.
        foreach ($children As $child) {
          $permalink = get_home_url() . '/section/' . $child->slug;
          $name = $child->name;
          ?>

          <h2>
            <a href="<?php echo $permalink; ?>" rel="bookmark"><?php echo $name; ?></a>
          </h2>


          <?
        }
      }
      else {
        //case 2 or 3 
        /* Start the Loop */
        $count = $wp_query->found_posts;
        if ($count > 1) { //case 3
          while (have_posts()) : the_post();
            ?>
            <h2>
              <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <?php
          endwhile;
        }
        else { //case 2 
          ?>
          <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('content', get_post_format()); ?>

            <nav class="nav-single">
              <h3 class="assistive-text"><?php _e('Post navigation', 'twentytwelve'); ?></h3>
        <?php //prev and next have been swapped so that they make sense  ?>
              <span class="nav-previous"><?php next_post_link('%link', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'twentytwelve') . '</span> %title '); ?></span> 	
              <span class="nav-next"><?php previous_post_link('%link', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'twentytwelve') . '</span>'); ?></span>
            </nav><!-- .nav-single -->

            <?php comments_template('', true); ?>

          <?php
          endwhile; // end of the loop. 
        }
      }
      ?>
      <?php
    else:
      echo "No sections or rules in this section";
      ?>
<?php endif; ?>

  </div><!-- #content -->
</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>