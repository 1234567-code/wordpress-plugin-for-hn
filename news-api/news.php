<?php
// Ensure this file is accessed from within WordPress
if (!defined('ABSPATH')) {
    exit;
}
  

// Register the custom REST API endpoints for posts
add_action('rest_api_init', 'register_news_endpoints');

function register_news_endpoints() {
    // Get all posts
    register_rest_route('news-api', '/allnews', array(
        'methods' => 'GET',
        'callback' => 'all_news',
    ));

    // Get a single post
    register_rest_route('news-api', '/news/(?P<id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => 'news',
    ));

    // Create a new post
    register_rest_route('news-api', '/create', array(
        'methods' => 'POST',
        'callback' => 'custom_create_post',
    ));

    // // Update a post
    // register_rest_route('custom-posts-api/v1', '/posts/(?P<id>\d+)', array(
    //     'methods' => 'PUT',
    //     'callback' => 'custom_update_post',
    // ));

    // // Delete a post
    // register_rest_route('custom-posts-api/v1', '/posts/(?P<id>\d+)', array(
    //     'methods' => 'DELETE',
    //     'callback' => 'custom_delete_post',
    // ));
}

// Custom callback functions for each endpoint
function all_news($request) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    $news = $query->get_posts();
    
    return $news;
}

function news($request) {
    $news_id = $request['id'];

    $news = get_post($news_id);

    if (!$news) {
        return new WP_Error('post_not_found', 'Post not found', array('status' => 404));
    }

    return $news;
}

function custom_create_post($request) {
    $post_data = $request->get_params();

    // Validate and sanitize post_data fields before creating the post

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        return new WP_Error('post_creation_error', 'Error creating post', array('status' => 500));
    }

    return get_post($post_id);
}

// function custom_update_post($request) {
//     $post_id = $request['id'];
//     $post_data = $request->get_params();

//     // Validate and sanitize post_data fields before updating the post

//     $updated = wp_update_post(array_merge(['ID' => $post_id], $post_data));

//     if (!$updated) {
//         return new WP_Error('post_update_error', 'Error updating post', array('status' => 500));
//     }

//     return get_post($post_id);
// }

// function custom_delete_post($request) {
//     $post_id = $request['id'];

//     $deleted = wp_delete_post($post_id, true);

//     if (!$deleted) {
//         return new WP_Error('post_delete_error', 'Error deleting post', array('status' => 500));
//     }

//     return new WP_REST_Response(null, 204);
// }