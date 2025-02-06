<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;

/**
 * Shortcodes For Membership Login Form 
 */
function membership_form_shortcode()
{
    if (!session_id()) {
        session_start();
    }

    $login = isset($_GET['login']) ? $_GET['login'] : '';

    // Retrieve token from session
    $membership_token = isset($_SESSION['membership_token']) ? $_SESSION['membership_token'] : '';
    $loader_image_url = plugin_dir_url(__FILE__) . '../assets/images/loader.gif';

    // Retrieve tokenverify from GET params
    $tokenverify = isset($_GET['tokenverify']) ? $_GET['tokenverify'] : '';

    // Flags for checking token validity
    $is_empty = empty($membership_token) || empty($tokenverify);
    $is_valid_token = ($membership_token == $tokenverify) && !empty($membership_token);

    // Start output buffering
    ob_start();
?>
    <style type="text/css">
        .auth-box input[type='text'],
        .auth-box input[type='email'],
        .auth-box input[type='password'] {
            border-radius: 0.5rem;
            padding: auto 1rem;
            border: 1px solid #CED1D7;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.75rem;
            -webkit-transition: 0.5s;
            background: #fff;
        }

        .auth-box input[type='text']:focus-visible,
        .auth-box input[type='email']:focus-visible,
        .auth-box input[type='password']:focus-visible {
            outline: none;
            border: 1px solid #D2982D !important;
        }

        .auth-box button:disabled,
        .auth-box button[disabled] {
            opacity: 0.5;
        }

        #mv-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80px;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.05);
        }

        .password-field {
            position: relative;
            width: 100%;
        }

        .password-field svg {
            position: absolute;
            top: 0.6rem;
            right: 1rem;
            cursor: pointer;
        }

        .password-field input[type='text'],
        .password-field input[type='password'] {
            width: calc(100% - 1.5rem);
            /* minus input padding and border  */
        }

        hr {
            margin: 1.5rem auto;
            width: 100%;
            border: 0.5px solid #CED1D7;
        }

        #error-box,
        #error-box-rpr {
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: #FFEAE9;
            border-radius: 0.5rem;
            margin-bottom: 2.5rem;
        }

        #error-box svg,
        #error-box-rpr svg {
            margin-right: 0.5rem;
        }

        #error-box .error-message,
        #error-box-rpr .error-message {
            color: #61121A;
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* justify-content: center; */
        }

        @media only screen and (max-width: 640px) {
            .container {
                /* minus mv-nav */
                margin-top: 0;
            }
        }

        /* Auth Section */
        #auth-section {
            /* margin-top: 80px; */
            /* margin-top: auto; */
            margin-bottom: auto;
        }

        .auth-box {
            padding: 1rem 1.5rem;
            /* border: 1px solid black; */
            display: flex;
            flex-direction: column;
            min-width: 400px;
            max-width: 400px;
        }

        .logo {
            width: 100%;
            text-align: center;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
        }

        .tabs {
            display: flex;
            margin: 0 0 2rem 0;
            padding: 0;
            list-style: none;
        }

        .tabs:after {
            content: ' ';
            display: table;
            clear: both;
        }

        .tabs .tab {
            width: 100%;
            text-align: center;
            border-bottom: 2px solid #979CA5;
            transition: transform .25s;
        }

        .tabs .tab.active {
            border-bottom: 2px solid #D2982D;
        }

        .tabs .tab a {
            display: block;
            padding: 1rem;
            color: #979CA5;
            text-decoration: none;
        }

        .tabs .tab.active a {
            color: #181D26;
        }

        #login {
            display: flex;
            flex-direction: column;
        }

        #create-account {
            display: none;
            /* display: flex; */
            flex-direction: column;

        }

        #forgot-password {
            color: #D2982D;
            text-decoration: none;
            text-align: right;
            margin: 0.5rem 1rem;
        }

        .social-login {
            display: flex;
            justify-content: space-between;

        }

        .social-login button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: 0.25rem;
            padding: 1rem 1.5rem;
            border-radius: 100px;
            background: #fff;
        }

        .social-login button:first-child {
            margin-left: 0;
        }

        .social-login button:last-child {
            margin-right: 0;
        }

        .social-login button#btn-google {
            border: 1px solid #9B9B9B;
            color: #6B6B6B;
        }

        .social-login button#btn-facebook {
            border: 1px solid #1D6CED;
            color: #1D6CED;
        }

        .social-login button#btn-apple {
            border: 1px solid #292D38;
            color: #181D26;
        }


        .social-login button .icon {
            display: flex;
            align-items: center;
            margin-right: 0.5rem;
        }

        @media only screen and (max-width: 640px) {
            .social-login {
                display: flex;
                flex-direction: column;
            }

            .social-login button {
                margin: 0.5rem 0;
            }

            .social-login button span {
                width: 100%;
                padding-right: 16px;
            }
        }

        .privacy-and-tnc,
        .privacy-and-tnc span {
            margin-top: 1.5rem;
            text-align: center;
            font-weight: 400;
            font-size: 0.875rem;
            color: #595E67;
            line-height: 1.5;
        }

        .privacy-and-tnc a {
            text-decoration: none;
            color: #D2982D;
        }


        /* Reset Password Section */
        #request-password-reset-section {
            display: none;
            margin-top: 5rem;
        }

        .request-password-reset-box {
            padding: 1rem 1.5rem;
            display: flex;
            flex-direction: column;
            min-width: 400px;
        }

        .request-password-reset-box .title-box {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .request-password-reset-box svg {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            cursor: pointer;
        }

        .request-password-reset-box .title {
            text-align: center;
            width: 100%;
            padding-right: 24px;
        }

        .request-password-reset-box label {
            font-weight: 400;
            color: #292D38;
        }



        /* Request Password Reset Success Section */
        #request-password-reset-success-section {
            display: none;
            margin-top: 5rem;
        }

        .request-password-reset-success-box {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            min-width: 400px;
        }

        .request-password-reset-success-box svg.mail {
            width: 100%;
            margin-bottom: 1rem;
            text-align: center;
        }

        .request-password-reset-success-box .title {
            margin-bottom: 0.25rem;
            text-align: center;
        }

        .request-password-reset-success-box label {
            font-weight: 600;
            text-align: center;
            color: #292D38;
        }

        #btn-back-login {
            color: #D2982D;
            cursor: pointer;
            text-align: center;
        }


        /* General */
        @media only screen and (max-width: 640px) {

            #auth-section,
            #request-password-reset-section,
            #request-password-reset-success-section {
                width: 100%;
                /* margin-top: 2rem; */
            }

            .auth-box,
            .request-password-reset-box,
            .request-password-reset-success-box {
                min-width: 0;
            }
        }

        .btn {
            cursor: pointer;
            width: 100%;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            padding: 1rem;
            text-align: center;
            color: #fff;
            background: #D2982D;
            border-radius: 100px;
            border: none;
        }

        .or-with {
            width: 100%;
            text-align: center;
            border-bottom: 0.5px solid #B3B8C1;
            line-height: 0.1em;
            margin: 1rem 0 1.5rem;
        }

        .or-with span {
            color: #595E67;
            background: #fff;
            padding: 0 1rem;
        }

        .size-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .size-1 {
            font-size: 1rem;
            font-weight: 500;
        }

        .size-2 {
            font-size: 0.875rem;
            font-weight: 400;
        }

        .size-3 {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .hidden {
            display: none !important;
        }

        .text-center {
            text-align: center;
        }

        .checkbox-field {
            display: flex;
        }

        .checkbox-field .round {
            position: relative;
        }

        .checkbox-field .round label {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 50%;
            cursor: pointer;
            height: 1.5rem;
            left: 0;
            position: absolute;
            top: 1px;
            width: 1.5rem;
        }

        .checkbox-field .round label:after {
            border: 2px solid #fff;
            border-top: none;
            border-right: none;
            content: "";
            height: 6px;
            left: 5px;
            opacity: 0;
            position: absolute;
            top: 6px;
            transform: rotate(-45deg);
            width: 12px;
        }

        .checkbox-field .round input[type="checkbox"] {
            visibility: hidden;
        }

        .checkbox-field .round input[type="checkbox"]:checked+label {
            background-color: #66bb6a;
            border-color: #66bb6a;
        }

        .checkbox-field .round input[type="checkbox"]:checked+label:after {
            opacity: 1;
        }

        .checkbox-field>label {
            font-family: 'Noto Sans';
            font-size: 0.875rem;
            color: #0F131A;
            text-align: justify;
            margin-left: 1rem;
            cursor: pointer;
        }

        .member_form {
            display: none;
        }

        .member_form.active {
            display: block;
        }
    </style>

    <div class="container">
        <!-- Auth Section -->
        <section id="auth-section">
            <div class="auth-box">
                <img lass="logo" width="120" height="32" src="<?php echo esc_url('/wp-content/uploads/2024/12/cropped-WOT-Logo.jpg'); ?>" alt="" style="margin: 0 auto 20px auto;border-radius: 100px;">
                <ul class="tabs">
                    <li class="tab <?php echo esc_attr($login ? '' : 'active'); ?>">
                        <a id="member_otp_tab" href="#create-account">Create account</a>
                    </li>
                    <li class="tab <?php echo esc_attr($login ? 'active' : ''); ?>">
                        <a id="member_login_tab" href="#login">Login</a>
                    </li>
                </ul>
                <?php
                membership_form_render([
                    'fields' => [
                        ['title' => 'Email or Username', 'name' => 'member_email', 'placeholder' => 'Enter Your Email or Username', 'type' => 'text', 'required' => true],
                        ['title' => 'Password', 'name' => 'member_password', 'placeholder' => 'Enter Your Password', 'type' => 'password', 'required' => true],
                    ],
                    'button_text' => 'Login',
                    'form_class' => 'login_submission_on_submit member_form member_login_form ' . ($login ? 'active' : ''),
                ]);

                if ($is_empty) {
                    membership_form_render([
                        'fields' => [
                            ['title' => 'Name', 'name' => 'member_name', 'placeholder' => 'Enter Your Name', 'type' => 'text', 'required' => true],
                            ['title' => 'Email', 'name' => 'member_email', 'placeholder' => 'Enter Your Email', 'type' => 'email', 'required' => true],
                            ['title' => 'Country', 'name' => 'member_country', 'placeholder' => 'Enter Your Country', 'type' => 'text', 'required' => false],
                        ],
                        'button_text' => 'Continue',
                        'form_class' => 'login_form_on_submit member_form member_otp_form ' . ($login ? '' : 'active'),
                    ]);
                } else {
                    if (!$is_valid_token) {
                        echo '<p style="text-align: center; color: #000;"> <b>Invalid Token</b></p>';
                    } else {
                        // Show the Password form if the token is valid
                        membership_form_render([
                            'fields' => [
                                ['title' => 'Password', 'name' => 'member_password', 'placeholder' => 'Enter Your Password', 'type' => 'password', 'required' => true],
                                ['title' => 'Confirm Password', 'name' => 'member_confirm_password', 'placeholder' => 'Confirm Your Password', 'type' => 'password', 'required' => true],
                            ],
                            'button_text' => 'Register',
                            'form_class' => 'password_form_on_submit',
                            'link' => true // Indicating to show the "Already have a member?" link
                        ]);
                    }
                }
                ?>
				
				
				<?php //echo do_shortcode('[nextend_social_login]'); ?>
				
                <!-- Privacy & T&C -->
                <div class="privacy-and-tnc">
                    <span id="privacy-and-tnc-text">By continuing, you agree to our</span> <br>
                    <a id="label-tnc" href="https://wiseowltalks.com/terms-of-services/" target="_blank">terms of services</a> <span id="label-and">and</span>
                    <a id="label-privacy" href="https://wiseowltalks.com/privacy-policy/" target="_blank">privacy policy</a>
                </div>
            </div>
        </section>
    </div>

<?php
    // Get the buffered content
    return ob_get_clean();
}

add_shortcode('membership_form', 'membership_form_shortcode');

/**
 * Function to render the form
 */
function membership_form_render($args = [])
{
    $fields = isset($args['fields']) ? $args['fields'] : [];
    $button_text = isset($args['button_text']) ? $args['button_text'] : 'Submit';
    $form_class = isset($args['form_class']) ? $args['form_class'] : '';

    $loader_image_url = plugin_dir_url(__FILE__) . '../assets/images/loader.gif';
?>
    <form action="" method="POST" class="<?php echo esc_attr($form_class); ?>">
        <div style="position:relative">
            <span class="loader_img" style="display:none;">
                <img src="<?php echo esc_url($loader_image_url); ?>">
            </span>
            <div class="form_processing">
                <?php
                foreach ($fields as $field) {
                    input_render($field['title'], $field['name'], $field['placeholder'], $field['type'], $field['required']);
                }
                ?>

                <div>
                    <div class="error_text"></div>
                    <div class="form_gapping2"></div>
                    <button type="submit" class="btn"><?php echo esc_html($button_text); ?></button>
                </div>
            </div>
        </div>
    </form>
<?php
}

/**
 * Function to render form inputs
 */
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
?>