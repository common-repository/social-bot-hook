<?php
/*
Plugin Name: Social bot hook.
Description: This plugin acts as hook for social bot SaaS Service.
Author: Shahid Shaikh
Author URI: https://codeforgeek.com/about
Version: 1.1.2
*/
function sbh_retrieve_random_post() {
  $sbhArguement = array('posts_per_page' => 1,'orderby' => 'rand','post_status' => 'publish');
  $sbhRandomPost = get_posts($sbhArguement);
  if (empty($sbhRandomPost)) {
        return null;
  }
  $sbhPost = $sbhRandomPost[0];
  if (!isset($sbhResponse)) 
     $sbhResponse= new stdClass();
  $sbhResponse->post_title = $sbhPost->post_title;
  $sbhResponse->permalink = get_permalink($sbhPost->ID);
  $sbhResponse->hash_tags = wp_get_post_tags($sbhPost->ID,array( 'fields' => 'names' ));
  return $sbhResponse;
}
add_filter('allowed_http_origins','add_allowed_origins');
add_action('wp_head', 'sbh_retrieve_random_post');
add_action('rest_api_init', function(){
        register_rest_route( 'socialbot/v1', '/posts/', array(
                'methods' => 'GET',
                'callback' => 'sbh_retrieve_random_post',
        ));
});
?>
