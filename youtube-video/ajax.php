<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * search_filter_handler
 */
add_action('wp_ajax_search_filter_handler', 'search_filter_handler');
add_action('wp_ajax_nopriv_search_filter_handler', 'search_filter_handler');

function search_filter_handler()
{
    ob_start();
    $keyword = isset($_POST['get_val']) ? $_POST['get_val'] : '';
    $tag = isset($_POST['tag']) ? $_POST['tag'] : '';

    $args = array(
        'post_type'      => 'youtube-video',
        'posts_per_page' => -1,
    );
    if (!empty($tag)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'tags',
                'field'    => 'slug',
                'terms'    => $tag,
            ),
        );
    }
    if (!empty($keyword)) {
        $args['s'] = $keyword;
    }
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        render_card_v1($query);
        wp_reset_postdata();
    } else {
        echo '<div class="video_itemse">No Videos Found</div>';
    }

    $output = ob_get_clean();
    wp_send_json_success(['output' => $output]);

    wp_die();
}
