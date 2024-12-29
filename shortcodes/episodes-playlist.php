<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcodes for Episodes Playlist Loop item from rss feed url
 */
function episodes_playlist_shortcode()
{
    ob_start();
    $playlist_args = array(
        'post_type' => 'episodes-playlist',
        'posts_per_page' => -1,
    );
    $playlist_query = new WP_Query($playlist_args);
    if ($playlist_query->have_posts()) {
?>
        <div
            class="elementor-element elementor-element-42d3082 elementor-grid-3 elementor-grid-tablet-2 elementor-grid-mobile-1 elementor-widget elementor-widget-loop-grid"
            data-id="42d3082"
            data-element_type="widget"
            data-settings='{"template_id":"1010","pagination_type":"prev_next","row_gap":{"unit":"px","size":20,"sizes":[]},"_skin":"post","columns":"3","columns_tablet":"2","columns_mobile":"1","edit_handle_selector":"[data-elementor-type=\"loop-item\"]","pagination_load_type":"page_reload","row_gap_tablet":{"unit":"px","size":"","sizes":[]},"row_gap_mobile":{"unit":"px","size":"","sizes":[]}}'
            data-widget_type="loop-grid.post">
            <div class="elementor-widget-container">
                <div class="elementor-loop-container elementor-grid">
                    <style id="loop-1010">
                        .elementor-1010 .elementor-element.elementor-element-4cd439d {
                            --display: flex;
                            --flex-direction: column;
                            --container-widget-width: 100%;
                            --container-widget-height: initial;
                            --container-widget-flex-grow: 0;
                            --container-widget-align-self: initial;
                            --flex-wrap-mobile: wrap;
                            --gap: 10px 10px;
                            --row-gap: 10px;
                            --column-gap: 10px;
                            border-style: solid;
                            --border-style: solid;
                            border-width: 2px 2px 2px 2px;
                            --border-top-width: 2px;
                            --border-right-width: 2px;
                            --border-bottom-width: 2px;
                            --border-left-width: 2px;
                            border-color: #d2982d;
                            --border-color: #d2982d;
                            --border-radius: 15px 15px 15px 15px;
                            --padding-top: 15px;
                            --padding-bottom: 15px;
                            --padding-left: 15px;
                            --padding-right: 15px;
                        }

                        .elementor-1010 .elementor-element.elementor-element-4cd439d:not(.elementor-motion-effects-element-type-background),
                        .elementor-1010 .elementor-element.elementor-element-4cd439d>.elementor-motion-effects-container>.elementor-motion-effects-layer {
                            background-color: #ffffff;
                        }

                        .elementor-1010 .elementor-element.elementor-element-bbf5ca0 img {
                            width: 100%;
                            border-radius: 15px 15px 15px 15px;
                        }

                        .elementor-1010 .elementor-element.elementor-element-ed1bb70 .elementor-heading-title {
                            font-family: "Figtree", Sans-serif;
                            font-size: 20px;
                            font-weight: 600;
                        }

                        .elementor-1010 .elementor-element.elementor-element-2733c35 {
                            font-size: 14px;
                        }

                        .elementor-1010 .elementor-element.elementor-element-f3914e1 .elementor-button {
                            background-color: #ffffff;
                            font-size: 13px;
                            fill: #000000;
                            color: #000000;
                            padding: 0px 0px 0px 0px;
                        }

                        .elementor-1010 .elementor-element.elementor-element-f3914e1 .elementor-button:hover,
                        .elementor-1010 .elementor-element.elementor-element-f3914e1 .elementor-button:focus {
                            color: #000000;
                        }

                        .elementor-1010 .elementor-element.elementor-element-f3914e1 .elementor-button:hover svg,
                        .elementor-1010 .elementor-element.elementor-element-f3914e1 .elementor-button:focus svg {
                            fill: #000000;
                        }
                    </style>

                    <?php
                    while ($playlist_query->have_posts()) {
                        $playlist_query->the_post();
                        $permalink = get_the_permalink();
                        $featured_image = get_the_post_thumbnail_url();
                        $rssfeed_url = get_field('rss_feed_url');
                        $feed_title  = rss_feed_title($rssfeed_url, 'title');
                        $description  = get_the_content();
                    ?>
                        <div
                            data-elementor-type="loop-item"
                            data-elementor-id="1010"
                            class="elementor elementor-1010 e-loop-item e-loop-item-428 post-428 post type-post status-publish format-standard has-post-thumbnail hentry category-news tag-coding tag-interview tag-news tag-notes tag-podcasting tag-videos"
                            data-elementor-post-type="elementor_library"
                            data-custom-edit-handle="1">
                            <div class="elementor-element elementor-element-4cd439d e-flex e-con-boxed e-con e-parent e-lazyloaded" data-id="4cd439d" data-element_type="container" data-settings='{"background_background":"classic"}'>
                                <div class="e-con-inner">
                                    <div class="elementor-element elementor-element-bbf5ca0 elementor-widget elementor-widget-image" data-id="bbf5ca0" data-element_type="widget" data-widget_type="image.default">
                                        <div class="elementor-widget-container">
                                            <a href="<?php echo esc_url($permalink); ?>">
                                                <img
                                                    src="<?php echo esc_url($featured_image); ?>"
                                                    class="attachment-full size-full wp-image-453"
                                                    alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-ed1bb70 elementor-widget elementor-widget-heading" data-id="ed1bb70" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h2 class="elementor-heading-title elementor-size-default"><a href="<?php echo esc_url($permalink); ?>"><?php echo wp_kses_post($feed_title); ?></a></h2>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-2733c35 elementor-widget elementor-widget-text-editor" data-id="2733c35" data-element_type="widget" data-widget_type="text-editor.default">
                                        <div class="elementor-widget-container">
                                            <?php echo wp_kses_post($description); ?>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-f3914e1 elementor-widget elementor-widget-button" data-id="f3914e1" data-element_type="widget" data-widget_type="button.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-button-wrapper">
                                                <a class="elementor-button elementor-button-link elementor-size-sm" href="<?php echo esc_url($permalink); ?>">
                                                    <span class="elementor-button-content-wrapper">
                                                        <span class="elementor-button-text">Watch Episode</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
<?php
        wp_reset_postdata();
    } else {
        echo 'No Episodes Found';
    }

    return ob_get_clean();
}
add_shortcode('episodes_playlist', 'episodes_playlist_shortcode');