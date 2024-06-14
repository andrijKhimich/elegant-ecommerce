<?php

// function load_more_news()
// {

//     die();
// }
// add_action('wp_ajax_load_more_news', 'load_more_news');
// add_action('wp_ajax_nopriv_load_more_news', 'load_more_news');
function search_autocomplete() {
  $term = $_POST['term'];

  // Query posts
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    's' => $term,
  );

  $query = new WP_Query($args);

  $results = array();
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $results[] = array(
        'title' => get_the_title(),
        'link' => get_permalink()
      );
    }
  }

  wp_reset_postdata();

  echo json_encode($results);
  wp_die();
}
add_action('wp_ajax_search_autocomplete', 'search_autocomplete');
add_action('wp_ajax_nopriv_search_autocomplete', 'search_autocomplete');
