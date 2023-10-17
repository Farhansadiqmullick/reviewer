<?php

function handle_submit_form()
{
    if (isset($_POST['nonce'])) {
        if (!wp_verify_nonce($_POST['nonce'], 'review')) {
            wp_send_json_error(['error' => 'Unauthorized Access']);
        }
    }
    // Handle the file upload
    if (isset($_FILES['document']) && !empty($_FILES['document']['name'])) {
        // Give the file a random name but keep the extension
        $filename = wp_unique_filename(dirname(__FILE__) . '/images/', $_FILES['document']['name']);
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $random_name = md5(time() . $_FILES['document']['name']) . '.' . $file_ext;
        $_FILES['document']['name'] = $random_name;

        //use the filter hook
        add_filter('upload_dir', 'document_upload_dir');

        // Define the upload parameters
        $overrides = array('test_form' => false, 'test_upload' => true);
        $upload = wp_handle_upload($_FILES['document'], $overrides);

        remove_filter('upload_dir', 'document_upload_dir');

        if (isset($upload['error'])) {
            wp_send_json_error(['error' => 'Upload Error: ' . $upload['error']]);
        } else {
            // File is uploaded, you can save the URL or any other information to the database
            $uploaded_file_url = $upload['url'];
        }
    }

    // update_option( 'submit_form_data', [
    //         'data' => $_POST,
    //         'uploaded_file_url' => isset($uploaded_file_url) ? $uploaded_file_url : ''
    // ] );


    $data = [
        'name' => (isset($_POST['firstName']) && isset($_POST['lastName'])) ? $_POST['firstName'] . ' ' . $_POST['lastName'] : '',
        'email' => isset($_POST['email']) ? $_POST['email'] : '',
        'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
        'country' => isset($_POST['country']) ? $_POST['country'] : '',
        'category' => isset($_POST['category']) ? $_POST['category'] : '',
        'segment' => isset($_POST['segment']) ? $_POST['segment'] : '',
        'description' => isset($_POST['description']) ? $_POST['description'] : '',
        'file' => isset($uploaded_file_url) ? $uploaded_file_url : '',
    ];

    global $wpdb;

    $table_name = $wpdb->prefix . 'review';
    global $wpdb;
    if (isset($data) && is_array($data) && !empty($data)) {
        $row = $data;
        $columns = implode(", ", array_keys($row));
        $placeholders = implode(", ", array_fill(0, count($row), "%s"));

        $query = $wpdb->prepare("INSERT INTO $table_name($columns) VALUES ($placeholders)", array_values($row));
        $wpdb->query($query);
    }

    wp_send_json_success([
        'data' => $_POST,
        'uploaded_file_url' => isset($uploaded_file_url) ? $uploaded_file_url : ''
    ]);

    wp_die();
}

add_action('wp_ajax_handle_submit_form', 'handle_submit_form');
add_action('wp_ajax_nopriv_handle_submit_form', 'handle_submit_form');


function document_upload_dir($default_dir_data)
{
    return array(
        'path'   => plugin_dir_path(__DIR__) . 'images',
        'url'    => plugin_dir_url(__DIR__) . 'images',
        'subdir' => '',
        'basedir' => plugin_dir_path(__DIR__),
        'baseurl' => plugin_dir_url(__DIR__),
        'error'  => false,
    );
}
