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
    if (empty($rssfeed_url)) {
        return;
    }
    $feed_title  = rss_feed_title($rssfeed_url, 'title');
    $channel_name  = rss_feed_title($rssfeed_url, 'channel');
    $channel_url  = rss_feed_title($rssfeed_url, 'channel_url');
    $xml_content = file_get_contents($rssfeed_url);
    $xml = simplexml_load_string($xml_content, 'SimpleXMLElement', LIBXML_NOCDATA);
    $namespaces = $xml->getNamespaces(true);
    $xml->registerXPathNamespace('default', $namespaces['']);
    $xml->registerXPathNamespace('media', $namespaces['media']);
    $entries = $xml->xpath('//default:entry');

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
                <?php
                if (!empty($entries)) {
                    $index = 1;

                    foreach ($entries as $entry) {
                        $video_id = (string)$entry->xpath('yt:videoId')[0];
                        $title = (string)$entry->title;
                        $thumbnail_url = isset($entry->xpath('media:group/media:thumbnail/@url')[0]) ? (string)$entry->xpath('media:group/media:thumbnail/@url')[0] : '';
                        $author_name = (string)$entry->author->name;
                        $author_url = (string)$entry->author->uri;
                ?>
                        <div class="video-con <?php echo esc_attr($index == 1 ? 'active-con' : ''); ?>" data-video="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>">
                            <div class="index title"><?php echo esc_html($index); ?></div>
                            <div class="thumb">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="" />
                            </div>
                            <div class="v-titles">
                                <div class="title"><?php echo wp_kses_post($title); ?></div>
                                <div class="sub-title">
                                    <a href="<?php echo esc_url($author_url); ?>" class="channel" target="_blank"><?php echo wp_kses_post($author_name); ?></a>
                                </div>
                            </div>
                        </div>
                <?php
                        $index++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('episodes_playlist_single', 'episodes_playlist_single_shortcode');
