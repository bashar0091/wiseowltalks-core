<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;

/**
 * Shortcodes for episode_search_shortcode
 */
function episode_search_shortcode()
{
    ob_start();
?>
    <div class="elementor-element elementor-element-546e907 elementor-widget__width-initial elementor-button-align-stretch elementor-widget elementor-widget-form" style="margin-left:auto;max-width:100%;width: 100%;">
        <div class="elementor-widget-container">
            <form class="">
                <div class="elementor-form-fields-wrapper elementor-labels-">
                    <div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-100">
                        <label for="form-field-name" class="elementor-field-label elementor-screen-only">
                            Search </label>
                        <input size="1" type="text" name="" class="episode_search_filter_on_input elementor-field elementor-size-md  elementor-field-textual" placeholder="Search Podcast">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('episode_search', 'episode_search_shortcode');
