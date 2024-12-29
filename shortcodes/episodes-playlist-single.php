<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcodes for Episodes Playlist Single Page
 */
function episodes_playlist_single_shortcode()
{
    ob_start();

    $rssfeed_url = get_field('rss_feed_url');
    $feed_title  = rss_feed_title($rssfeed_url, 'title');
    $channel_name  = rss_feed_title($rssfeed_url, 'channel');
    $channel_url  = rss_feed_title($rssfeed_url, 'channel_url');
?>
    <div id="playlist">
        <div id="video-dis">
            <iframe id="display-frame" src="" title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>

        <div id="v-list" class="video-li">
            <div id="vli-info">
                <div id="upper-info">
                    <div id="li-titles">
                        <div class="title"><?php echo wp_kses_post($feed_title); ?></div>
                        <div class="sub-title">
                            <a href="<?php echo wp_kses_post($channel_url); ?>" target="_blank" class="channel"><?php echo wp_kses_post($channel_name); ?></a>
                        </div>
                    </div>
                    <div id="drop-icon"></div>
                </div>
            </div>

            <div id="vli-videos">
                <div class="video-con active-con" data-video="https://www.youtube.com/embed/BVyTt3QJfIA">
                    <div class="index title">0</div>
                    <div class="thumb">
                        <img src="https://i.ytimg.com/vi/BVyTt3QJfIA/hqdefault.jpg" alt="" />
                    </div>
                    <div class="v-titles">
                        <div class="title">Google chrome custom new tab</div>
                        <div class="sub-title">
                            <a href="https://www.youtube.com/channel/UCD7RHHe-SuFiTWEsC0S1dLg" class="channel" target="_blank">Rejwan
                                Islam</a>
                        </div>
                    </div>
                </div>

                <div class="video-con" data-video="https://www.youtube.com/embed/Eg4hPSMRtds">
                    <div class="index title">1</div>
                    <div class="thumb">
                        <img src="https://i.ytimg.com/vi/Eg4hPSMRtds/hqdefault.jpg" alt="" />
                    </div>
                    <div class="v-titles">
                        <div class="title">Calculator: Parallel and series resistance</div>
                        <div class="sub-title">
                            <a href="https://www.youtube.com/channel/UCD7RHHe-SuFiTWEsC0S1dLg" class="channel" target="_blank">Rejwan
                                Islam</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('episodes_playlist_single', 'episodes_playlist_single_shortcode');
