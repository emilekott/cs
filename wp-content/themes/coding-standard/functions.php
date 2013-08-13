<?php

/*
 * 
 * Rule post type
 * 
 */
add_action('init', 'rule_init');

function rule_init() {

  $rule_labels = array(
    'name' => _x('Rules', 'post type general name'),
    'singular_name' => _x('Rule', 'post type singular name'),
    'all_items' => __('All Rules'),
    'add_new' => _x('Add new rule', 'rule'),
    'add_new_item' => __('Add new rule'),
    'edit_item' => __('Edit rule'),
    'new_item' => __('New rule'),
    'view_item' => __('View rule'),
    'search_items' => __('Search rules'),
    'not_found' => __('No rule found'),
    'not_found_in_trash' => __('No rule found in trash'),
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $rule_labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'author', 'excerpt', 'comments', 'custom-fields'),
    'taxonomies' => array('section'),
    'has_archive' => 'rule'
  );
  register_post_type('rule', $args);
}

/*
 * 
 * Section taxonomy
 * 
 */


add_action('init', 'rule_create_taxonomies', 0);

function rule_create_taxonomies() {
  // Project Categories
  register_taxonomy('section', array('rule'), array(
    'hierarchical' => true,
    'label' => 'Sections',
    'singular_name' => 'Section',
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'section'),
    'labels' => array(
      'name' => _x('Section', 'taxonomy general name'),
      'singular_name' => _x('Section', 'taxonomy singular name'),
      'search_items' => __('Search Sections'),
      'all_items' => __('All Sections'),
      'parent_item' => __('Parent Section'),
      'parent_item_colon' => __('Parent Section:'),
      'edit_item' => __('Edit Section'),
      'update_item' => __('Update Section'),
      'add_new_item' => __('Add New Section'),
      'new_item_name' => __('New Section Name'),
      'menu_name' => __('Sections'),
    ),
  ));
}

/*
 * 
 * Add section to columns in rules listing
 */

add_filter('manage_taxonomies_for_rule_columns', 'section_column');

function section_column($taxonomies) {
  $taxonomies[] = 'section';
  return $taxonomies;
}

/*
 * 
 * Custom taxonomy breadcrumb
 */

function postTypeCrumbs($postType, $postTax) {

  $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
  
  
  
  $taxonomy = get_taxonomy($term->taxonomy);
  $parents = get_ancestors($term->term_id, $postTax);
  $parents = array_reverse($parents);

  $archive_link = get_post_type_archive_link($postType);

  echo '<ul class="custom-crumbs">';
  //add home link
  if (!is_front_page()){
    echo '<li><a href="'.get_home_url().'">Home</a></li>';
  
  }
  

  foreach ($parents as $parent) {
    $p = get_term($parent, $postTax);
    echo '<li><a href="' . get_term_link($p->slug, $postTax) . '" title="' . $p->name . '">' . $p->name . '</a></li>';
  }

  if ($term) {
    echo '<li>' . $term->name . '</li>';
  }

  echo '</ul>';
}