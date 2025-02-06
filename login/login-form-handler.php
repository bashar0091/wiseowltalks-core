<?php

// Prevent direct access to the plugin file
defined('ABSPATH') || exit;


/**
 * Shortcodes For Membership Login Form 
 */
add_action('wp_ajax_membership_handler', 'membership_handler');
add_action('wp_ajax_nopriv_membership_handler', 'membership_handler');

function membership_handler()
{
    // Start the session if not already started
    if (!session_id()) {
        session_start();
    }

    // Get form data and sanitize
    $member_name = isset($_POST['member_name']) ? sanitize_text_field($_POST['member_name']) : '';
    $member_email = isset($_POST['member_email']) ? sanitize_email($_POST['member_email']) : '';
    $member_country = isset($_POST['member_country']) ? sanitize_text_field($_POST['member_country']) : '';

    // Check if the email is already registered
    if (email_exists($member_email)) {
        // Email is already registered, return an error response
        wp_send_json_error(array(
            'success' => false,
            'message' => 'This email address is already registered!',
        ));
        wp_die();
    }

    // Save data to session
    $_SESSION['membership_data'] = array(
        'name' => $member_name,
        'email' => $member_email,
        'country' => $member_country,
    );

    // Generate a random token
    $token = bin2hex(random_bytes(32)); // Generates a secure random token

    // Save token in session for later verification
    $_SESSION['membership_token'] = $token;

    // Construct the verification URL
    $verification_url = home_url() . "/become-a-member?tokenverify=" . $token;

    // Send email with the verification link
    $subject = 'Membership Verification';
    $message = "Hello $member_name,\n\nThank you for signing up. Please click the following link to verify your membership:\n\n$verification_url";
    $headers = array('Content-Type: text/plain; charset=UTF-8');

    // Send the email using wp_mail
    wp_mail($member_email, $subject, $message, $headers);

    // Send a success response back to the frontend
    wp_send_json_success(array(
        'success' => true,
    ));

    // End execution
    wp_die();
}


add_action('wp_ajax_membership_password_handler', 'membership_password_handler');
add_action('wp_ajax_nopriv_membership_password_handler', 'membership_password_handler');

function membership_password_handler()
{
    // Start the session if not already started
    if (!session_id()) {
        session_start();
    }

    // Get form data and sanitize the password
    $member_name = isset($_SESSION['membership_data']['name']) ? $_SESSION['membership_data']['name'] : '';
    $member_email = isset($_SESSION['membership_data']['email']) ? $_SESSION['membership_data']['email'] : '';
    $member_country = isset($_SESSION['membership_data']['country']) ? $_SESSION['membership_data']['country'] : '';

    // Get password and confirm password
    $member_password = isset($_POST['member_password']) ? sanitize_text_field($_POST['member_password']) : '';
    $member_confirm_password = isset($_POST['member_confirm_password']) ? sanitize_text_field($_POST['member_confirm_password']) : '';

    // Check if password is at least 8 characters long and if passwords match
    if (strlen($member_password) < 8) {
        wp_send_json_error(array(
            'success' => false,
            'message' => 'Password must be at least 8 characters long!',
        ));
    }

    if ($member_password !== $member_confirm_password) {
        wp_send_json_error(array(
            'success' => false,
            'message' => 'Passwords do not match!',
        ));
    }

    // Create the user with the provided data
    $user_data = array(
        'user_login' => sanitize_user(strtolower(str_replace(' ', '_', $member_name))),  // username: lowercase and underscores
        'user_pass' => $member_password,
        'user_email' => $member_email,
        'first_name' => $member_name,
        'role' => 'customer'
    );

    // Create the user and check for errors
    $user_id = wp_insert_user($user_data);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array(
            'success' => false,
            'message' => 'There was an error creating the user!',
        ));
    }

    // Set user meta for user status as 'verified'
    update_user_meta($user_id, 'user_status', 'verified');
    update_user_meta($user_id, 'billing_state', $member_country);

    // Log the user in after creation
    wp_set_auth_cookie($user_id);
    wp_set_current_user($user_id);

    // Respond with success and redirect to the dashboard
    wp_send_json_success(array(
        'success' => true,
        'message' => 'User created and logged in successfully! Redirecting to the dashboard.',
        'redirect_url' => home_url('/dashboard'),
    ));

    // End the session
    session_unset();
    session_destroy();
    wp_die();
}


add_action('wp_ajax_login_submission_handler', 'login_submission_handler');
add_action('wp_ajax_nopriv_login_submission_handler', 'login_submission_handler');

function login_submission_handler()
{
    // Start the session if not already started
    if (!session_id()) {
        session_start();
    }

    // Get the member email and password
    $member_email = isset($_POST['member_email']) ? sanitize_text_field($_POST['member_email']) : '';
    $member_password = isset($_POST['member_password']) ? sanitize_text_field($_POST['member_password']) : '';

    // Try to authenticate the user
    $creds = array(
        'user_login'    => $member_email,
        'user_password' => $member_password,
        'remember'      => true, // Keep user logged in
    );

    // Attempt to sign the user in
    $user = wp_signon($creds, false);

    // Check for errors
    if (is_wp_error($user)) {
        $error_message = $user->get_error_message();
        wp_send_json_error(array(
            'success' => false,
            'message' => 'Username or Password doesn\'t match',
        ));
    } else {
        // Login successful
        wp_send_json_success(array(
            'success' => true,
            'message' => 'Logged in successfully! Redirecting to the dashboard.',
            'redirect_url' => home_url('/dashboard'),
        ));
    }

    wp_die();
}
