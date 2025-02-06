<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;

/**
 * Shortcodes for search Filter
 */
function search_filter_shortcode()
{
    ob_start();
?>
    <div class="elementor-element elementor-element-35390a4 elementor-widget__width-initial elementor-button-align-stretch elementor-widget elementor-widget-form" style="margin-left:auto;max-width:100%;width: 100%;" data-id="35390a4" data-element_type="widget" data-settings="{&quot;step_next_label&quot;:&quot;Next&quot;,&quot;step_previous_label&quot;:&quot;Previous&quot;,&quot;button_width&quot;:&quot;100&quot;,&quot;step_type&quot;:&quot;number_text&quot;,&quot;step_icon_shape&quot;:&quot;circle&quot;}" data-widget_type="form.default">
        <div class="elementor-widget-container">
            <form class="elementor-form" method="post">
                <div class="elementor-form-fields-wrapper elementor-labels-">
                    <div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-100">
                        <label for="form-field-name" class="elementor-field-label elementor-screen-only">
                            Search </label>
                        <input size="1" type="text" name="form_fields[name]" id="form-field-name" class="elementor-field elementor-size-md  elementor-field-textual search_filter_on_input" data-field="search" placeholder="Search Video">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('search_filter', 'search_filter_shortcode');
