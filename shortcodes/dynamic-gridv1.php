<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;

/**
 * Shortcodes dynamic_gridv1_shortcode
 */
function dynamic_gridv1_shortcode()
{
    ob_start();
    $title = get_the_title();
    $link = get_the_permalink();
    $image = get_the_post_thumbnail_url();
    $youtube_episode_video = get_field('youtube_episode_video');
?>

    <div class="progression-studios-default-projects-index crosstalk-link-hover-animation">
        <div class="progression-studios-projects-feaured-image">
            <a href="<?php echo wp_kses_post($link); ?>">
                <?php
                if (!empty($youtube_episode_video)) {
                ?>
                    <div class="wise_iframe_wrap">
                        <?php echo $youtube_episode_video; ?>
                    </div>
                <?php
                } else {
                ?>
                    <img src="<?php echo esc_url($image); ?>" class="attachment-progression_studios_video-index size-progression_studios_video-index wp-post-image" alt="">
                <?php
                }
                ?>
            </a>
            <!-- <ul class="crosstalk-index-meta-taxonomy">
                <li><a href="#!">Season 3</a></li>
                <li><a href="#!">Season 4</a></li>
            </ul> -->
        </div>
        <!-- close .progression-studios-feaured-image -->
        <!-- close featured thumbnail -->
        <div class="progression-podcast-index-content">
            <div class="progression-podcast-index-border">
                <h2 class="progression-podcast-title">
                    <a href="<?php echo esc_url($link); ?>" class="hover-underline-animation"><?php echo wp_kses_post($title); ?></a>
                </h2>
                <div class="clearfix-pro"></div>
                <div class="clearfix-pro"></div>
            </div>
            <!-- close .progression-podcast-index-border -->
        </div>
        <!-- close .progression-podcast-index-content -->
        <div class="clearfix-pro"></div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('dynamic_gridv1', 'dynamic_gridv1_shortcode');
