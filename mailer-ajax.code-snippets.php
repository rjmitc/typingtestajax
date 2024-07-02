<?php

/**
 * mailer-ajax
 */
add_action('wp_ajax_send_typing_test_results', 'send_typing_test_results');
add_action('wp_ajax_nopriv_send_typing_test_results', 'send_typing_test_results');

function send_typing_test_results() {
    $results = json_decode(file_get_contents('php://input'), true);
    
    // Debugging log
    error_log(print_r($results, true));

    if ($results && isset($results['name']) && isset($results['speed']) && isset($results['accuracy']) && isset($results['time'])) {
        $to = 'hr@example.com'; // Replace with your HR email address
        $subject = 'Typing Test Results';
        $body = 'Name: ' . $results['name'] . "\n" .
                'Speed: ' . $results['speed'] . ' WPM' . "\n" .
                'Accuracy: ' . $results['accuracy'] . '%' . "\n" .
                'Time: ' . $results['time'] . ' seconds';

        $headers = array('Content-Type: text/plain; charset=UTF-8');

        if (wp_mail($to, $subject, $body, $headers)) {
            wp_send_json_success();
        } else {
            wp_send_json_error();
        }
    } else {
        wp_send_json_error();
    }

    wp_die();
}
