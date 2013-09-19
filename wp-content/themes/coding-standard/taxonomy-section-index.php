<?php
/**
 *
 * Tempate to display index section
 * 
 * If a section contains sections:
 * 1. Show index of all subsection and 1 level of children
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
<!-- breadcrumbs -->
<?php postTypeCrumbs('rule', 'section'); ?>

<section id="primary" class="site-content">
  <div id="content" role="main">


    <?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); ?>

    <!-- main heading -->
    <header class="entry-header">
      <h1 class="entry-title"><?php echo $term->name; ?></h1>
    </header><!-- .archive-header -->
    <?php
    $termDiscription = term_description('', get_query_var('taxonomy'));
    if ($termDiscription != '') {
      echo '<div class="tag-desc">' . $termDiscription . '</div>';
    }
    ?>


    <?php if (have_posts()) : //case 1, 2 or 3 ?>





      <?php
      $termDiscription = term_description('', get_query_var('taxonomy'));
      if ($termDiscription != '') {
        echo '<div class="tag-desc">' . $termDiscription . '</div>';
      }


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

          <h2 class="rule-list">
            <a href="<?php echo $permalink; ?>" rel="bookmark"><?php echo $name; ?></a>
          </h2>
          <?php  
            $gargs = array(
              'child_of' => $child->term_id,
              'hide_empty' => false,
              'parent' => $child->term_id,
            );
            $grandchildren = get_terms('section', $gargs);
            
            if (sizeof($grandchildren) > 0){
              //spit out second level
              echo "<ul class='grand-children'>";
              foreach ($grandchildren As $grandchild){
                $gpermalink = get_home_url() . '/section/' . $grandchild->slug;
                $gname = $grandchild->name;
                
                echo '<li><a href="'.$gpermalink.'" rel="bookmark">'.$gname.'</a></li>';
              }
              echo "</ul>";
            }
          
          ?>

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
            <h2 class="rule-list">
              <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <?php
          endwhile;
        }
        else { //case 2 
          ?>
          <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('content', get_post_format()); ?>

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