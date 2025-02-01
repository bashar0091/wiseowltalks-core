<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;

/**
 * Shortcodes for Dropdown Filter
 */
function dropdown_filter_shortcode()
{
    ob_start();
    $terms = get_terms([
        'taxonomy'   => 'tags',
        'hide_empty' => false,
    ]);
?>
    <style>
        .tag_list_pc {
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            list-style-type: none;
        }

        .tag_list_pc input[type="radio"] {
            position: absolute;
            visibility: hidden;
            opacity: 0;
        }

        .tag_list_pc label {
            cursor: pointer;
            padding: 6px 22px;
            background: #D2982D;
            color: #fff;
            border-radius: 100px;
            font-family: 'Figtree', sans-serif;
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s;
        }

        .tag_list_pc label.active,
        .tag_list_pc label:hover {
            background: #095269
        }
    </style>
    <ul class="tag_list_pc">
        <li>
            <label class="active">
                <input class="tag_filter_on_input" data-field="tag" type="radio" name="tag_list_item" value="">
                All
            </label>
        </li>
        <?php
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
        ?>
                <li>
                    <label>
                        <input class="tag_filter_on_input" data-field="tag" type="radio" name="tag_list_item" value="<?php echo esc_attr($term->slug); ?>">
                        <?php echo esc_html($term->name); ?>
                    </label>
                </li>
        <?php
            }
        }
        ?>
    </ul>
    <div
        class="elementor-element elementor-element-c0b4669 elementor-button-align-stretch elementor-widget elementor-widget-form"
        data-id="c0b4669"
        data-element_type="widget"
        data-settings='{"step_next_label":"Next","step_previous_label":"Previous","button_width":"100","step_type":"number_text","step_icon_shape":"circle"}'
        data-widget_type="form.default" style="display:none">
        <div class="elementor-widget-container">
            <form class="elementor-form">
                <div class="elementor-form-fields-wrapper elementor-labels-">
                    <div class="elementor-field-type-select elementor-field-group elementor-column elementor-field-group-name elementor-col-100">
                        <label for="form-field-name" class="elementor-field-label elementor-screen-only"> Name </label>
                        <div class="elementor-field elementor-select-wrapper remove-before">
                            <div class="select-caret-down-wrapper">
                                <svg aria-hidden="true" class="e-font-icon-svg e-eicon-caret-down" viewBox="0 0 571.4 571.4" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M571 393Q571 407 561 418L311 668Q300 679 286 679T261 668L11 418Q0 407 0 393T11 368 36 357H536Q550 357 561 368T571 393Z"></path>
                                </svg>
                            </div>
                            <select name="" id="form-field-name" data-field="tag" class="tag_filter_on_input elementor-field-textual elementor-size-md tag_filter_on_change">
                                <option value="">Select Tag</option>
                                <?php
                                if (!is_wp_error($terms)) {
                                    foreach ($terms as $term) {
                                ?>
                                        <option value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
    return ob_get_clean();
}
add_shortcode('dropdown_filter', 'dropdown_filter_shortcode');
