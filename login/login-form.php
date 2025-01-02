<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcodes For Membership Login Form 
 */
function membership_form_shortcode()
{
?>
    <form action="" method="POST" class="login_form_on_submit">
        <div>
            <div></div>
            <div>
                <h1>Register with Wise Owl</h1>
                <p>GET 50% OFF On All Courses</p>
            </div>
        </div>
        <div class="form_gapping">
            <?php
            input_render('Name', 'member_name', 'Enter Your Name', 'text', true);
            input_render('Email', 'member_email', 'Enter Your Email', 'email', true);
            input_render('Country', 'member_country', 'Enter Your Country', 'text', false);
            input_render('Referral', 'member_referral', 'Referral', 'text', false);
            ?>
            <div>
                <div></div>
                <div class="form_gapping2">
                    <button type="submit" class="tutor-btn tutor-btn-primary">Continue</button>
                    <label>
                        <input type="checkbox" name="agree_terms">
                        Agree to wise owl terms
                    </label>
                </div>
            </div>
            <div>
                <p>Already Have member? <a href="<?php echo esc_url(home_url('/dashboard')) ?>">Login Now</a></p>
            </div>
        </div>
    </form>
<?php
}
add_shortcode('membership_form', 'membership_form_shortcode');


function input_render($title = '', $name = '', $placeholder = '', $type = '', $require = true, $class = '')
{
?>
    <div>
        <div>
            <label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($title); ?></label>
        </div>
        <div>
            <input type="<?php echo esc_attr($type); ?>" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($name); ?>" class="tutor-form-control bg_white <?php echo esc_attr($class); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" <?php echo esc_attr($require ? 'required' : ''); ?>>
        </div>
    </div>
<?php
}
