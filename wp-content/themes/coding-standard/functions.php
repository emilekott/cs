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
      'name' => _x('Sections', 'taxonomy general name'),
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
 * Add section to rules listing
 */

//'rule' is the registered post type name
add_filter('manage_rules_posts_columns', 'rule_cpt_columns');
add_action('manage_rule_posts_custom_column', 'rule_cpt_custom_column', 10, 2);

function rule_cpt_columns($defaults) {
  $defaults['section'] = 'Section'; //section is registered taxonomy name.
  return $defaults;
}

function rule_cpt_custom_column($column_name, $post_id) {
  $taxonomy = $column_name;
  $post_type = get_post_type($post_id);
  $terms = get_the_terms($post_id, $taxonomy);

  if (!empty($terms)) {
    foreach ($terms as $term)
      $post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
    echo join(', ', $post_terms);
  }
  else
    echo '<i>Not assigned.</i>';
}