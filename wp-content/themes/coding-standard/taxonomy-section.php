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
    <?php postTypeCrumbs('rule', 'section'); ?>
    <?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); ?>
    <header class="archive-header">
      <h1 class="archive-title"><?php echo $term->name; ?></h1>
    </header><!-- .archive-header -->

    
    
    <?php if (have_posts()) : //case 2 or 3 ?>


    


      <?php
      $args = array(

        'child_of' => $term->term_id,
        'hide_empty'    => false,
        'parent' => $term->term_id
        
      );
      $new_children = get_terms('section', $args);
      
      $children = get_term_children($term->term_id, get_query_var('taxonomy')); // get children

      if (sizeof($new_children) > 0) {
        
        // get list of child terms with permalinks.
        foreach ($new_children As $child) {
          $permalink = get_home_url().'/section/'.$child->slug;
          $name = $child->name;
          ?>
          <article id="post-<?php echo $child->term_id; ?>">

            <header class="entry-header">

              <h1 class="entry-title">
                <a href="<?php echo $permalink; ?>" rel="bookmark"><?php echo $name; ?></a>
              </h1>

            </header><!-- .entry-header -->
          </article><!-- #post -->

          <?
        }
      }
      else {


        /* Start the Loop */
        while (have_posts()) : the_post();
          ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">

              <h1 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
              </h1>

            </header><!-- .entry-header -->
          </article><!-- #post -->

          <?php
        endwhile;
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