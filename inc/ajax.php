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

        // add_filter('upload_dir', 'document_upload_dir');



        // Define the upload parameters

        $overrides = array('test_form' => false, 'test_upload' => true);

        $upload = wp_handle_upload($_FILES['document'], $overrides);


        // remove_filter('upload_dir', 'document_upload_dir');



        if (isset($upload['error'])) {

            wp_send_json_error(['error' => 'Upload Error: ' . $upload['error']]);
        } else {

            // File is uploaded, you can save the URL or any other information to the database

            $uploaded_file_url = $upload['url'];
        }
    }





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

    if (isset($data) && is_array($data) && !empty($data)) {

        $row = $data;

        $columns = implode(", ", array_keys($row));

        $placeholders = implode(", ", array_fill(0, count($row), "%s"));



        $query = $wpdb->prepare("INSERT INTO $table_name($columns) VALUES ($placeholders)", array_values($row));

        $wpdb->query($query);

        send_email_to_user($data);
    }



    wp_send_json_success([

        'data' => $_POST,

        'uploaded_file_url' => isset($uploaded_file_url) ? $uploaded_file_url : ''

    ]);



    wp_die();
}



add_action('wp_ajax_handle_submit_form', 'handle_submit_form');

add_action('wp_ajax_nopriv_handle_submit_form', 'handle_submit_form');


function send_email_to_user($data)
{

    global $wpdb;
    $table_name = $wpdb->prefix . 'review';

    if (isset($data) && is_array($data) && !empty($data)) {
        // Get the ID of the newly inserted record
        $last_id = $wpdb->insert_id;

        // Get the user's email from the $_POST data
        $user_email = $_POST['email'];

        // Set the subject of the email
        $subject = 'Thank you for your submission! We will review your design';

        // Set the message body of the email
        $message = "Hello " . $data['name'] . ",\n\n";
        $message .= "Thank you for your submission. Your Review ID is" . counting_start($last_id) . ".\n";
        $message .= "We will get back to you shortly.\n\n";
        $message .= "Best regards,\n";
        $message .= "IGI Expressions";

        // Use WordPress's built-in function to send the email
        wp_mail($user_email, $subject, $message);

        // Return a success message with the ID
        wp_send_json_success([
            'message' => 'Thank you for your submission! Your review ID is ' . counting_start($last_id),
            'data' => $_POST,
            'uploaded_file_url' => isset($uploaded_file_url) ? $uploaded_file_url : ''
        ]);
    } else {
        // Handle the case where data is not set or is not valid
        wp_send_json_error(['error' => 'Invalid data submitted.']);
    }
    wp_die();
}


// function document_upload_dir($default_dir_data)
// {
//     return array(
//         'path'   => plugin_dir_path(__DIR__) . 'images',
//         'url'    => plugin_dir_url(__DIR__) . 'images',
//         'subdir' => '',
//         'basedir' => plugin_dir_path(__DIR__),
//         'baseurl' => plugin_dir_url(__DIR__),
//         'error'  => false,
//     );
// }


add_action('wp_ajax_key_change', 'handle_change_key');

add_action('wp_ajax_key_jury_change', 'handle_jury_change_key');



function handle_change_key()

{

    if (isset($_POST['nonce'])) {

        if (!wp_verify_nonce($_POST['nonce'], 'review')) {

            wp_send_json_error(['error' => 'Unauthorized Access']);
        }
    }



    if (!isset($_POST['key'])) {

        return;
    } else {

        update_option('key_value', $_POST['key']);
    }

    global $wpdb;

    $tablename = $wpdb->prefix . 'review';



    $category_name = isset($_POST['category']) ? $_POST['category'] : '';

    // Use prepare to avoid SQL injection

    $query = $wpdb->prepare("SELECT * FROM {$tablename} WHERE category = %s", $category_name);

    $results = $wpdb->get_results($query);

    // Check for errors

    if ($wpdb->last_error) {

        wp_send_json_error("Database error: " . $wpdb->last_error);
    } else {

        $key_value = isset($_POST['key']) ? absint($_POST['key']) : 0;

        $result = get_data_by_key($results, $key_value);

        $value = isset($result) && !empty($result) ? $result : [];
    }



    wp_send_json_success(['key' => $key_value, 'value' => $value]);



    wp_die();
}





function handle_jury_change_key()

{

    if (isset($_POST['nonce'])) {

        if (!wp_verify_nonce($_POST['nonce'], 'review')) {

            wp_send_json_error(['error' => 'Unauthorized Access']);
        }
    }



    if (!isset($_POST['key'])) {

        return;
    } else {

        update_option('key_value', $_POST['key']);
    }

    global $wpdb;

    $tablename = $wpdb->prefix . 'review';



    $category_name = isset($_POST['category']) ? $_POST['category'] : '';

    $review_type = isset($_POST['reviewType']) ? $_POST['reviewType'] : '';

    // Use prepare to avoid SQL injection

    $query = $wpdb->prepare("SELECT * FROM {$tablename} WHERE category = %s AND review = %s", $category_name, $review_type);

    $results = $wpdb->get_results($query);

    // Check for errors

    if ($wpdb->last_error) {

        wp_send_json_error("Database error: " . $wpdb->last_error);
    } else {

        $key_value = isset($_POST['key']) ? absint($_POST['key']) : 0;

        $result = get_data_by_key($results, $key_value);

        $value = isset($result) && !empty($result) ? $result : [];
    }



    wp_send_json_success(['key' => $key_value, 'value' => $value, 'category' => $category_name, 'review' => $review_type]);



    wp_die();
}





add_action('wp_ajax_review_status_update', 'update_review_status');

function update_review_status()

{

    if (isset($_POST['nonce'])) {

        if (!wp_verify_nonce($_POST['nonce'], 'review')) {

            wp_send_json_error(['error' => 'Unauthorized Access']);
        }
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'review';

    // Get the review ID, status, and category from the user

    $review_id = $_POST['review_id'];

    $category = $_POST['category'];

    $issue = strtolower($_POST['issue']);

    // Use prepare to avoid SQL injection

    $query = $wpdb->prepare("UPDATE {$table_name} SET review=%s WHERE id=%d AND category=%s", $issue, $review_id, $category);

    $wpdb->query($query);

    wp_send_json_success(['success' => true, 'note' => 'review inserted']);

    wp_die();
}

add_action('wp_ajax_save_jury_options', 'save_jury_options');



function save_jury_options()

{

    if (isset($_POST['nonce'])) {

        if (!wp_verify_nonce($_POST['nonce'], 'review')) {

            wp_send_json_error(['error' => 'Unauthorized Access']);
        }
    }



    if (current_user_can('manage_options')) {

        $options = isset($_POST['options']) ? $_POST['options'] : array();



        update_option('jury_assign_roles', $options);



        wp_send_json_success(['data' => $options, 'message' => 'Options saved successfully']);
    } else {

        wp_send_json_error('You do not have permission to save options');
    }
}



add_action('wp_ajax_submit_jury_marks', 'submit_jury_marks');



function submit_jury_marks()

{



    if (isset($_POST['nonce'])) {

        if (!wp_verify_nonce($_POST['nonce'], 'review')) {

            wp_send_json_error(['error' => 'Unauthorized Access']);
        }
    }

    $juryUserId = isset($_POST['juryUserId']) ? intval($_POST['juryUserId']) : 0;

    $dataId = isset($_POST['dataId']) ? intval($_POST['dataId']) : 0;

    $averageMarks = isset($_POST['averageMarks']) ? sanitize_text_field($_POST['averageMarks']) : '';



    // Match the Jury User ID with get_option('jury_assign_roles') values

    $roles = get_option('jury_assign_roles', array());

    $matchedRole = array_search($juryUserId, $roles);



    if ($matchedRole) {

        global $wpdb;

        $table_name = $wpdb->prefix . 'review';



        // Update the database with the average marks for the matched role

        $wpdb->update(

            $table_name,

            array($matchedRole => $averageMarks),

            array('id' => $dataId),

            array('%s'),

            array('%d')

        );

        if ($wpdb->last_error) {

            // Handle the error, e.g., log it or display a message

            echo "Error: " . $wpdb->last_error;

            error_log(print_r($wpdb->last_error));
        }



        wp_send_json_success([

            'name' => $matchedRole,

            'number' => $averageMarks,

            'id' => $dataId

        ]);
    } else {

        wp_send_json_error('Jury User ID not found in roles');
    }

    wp_die();
}



//custom logout

add_action('wp_ajax_custom_logout', 'custom_logout');



function custom_logout()

{

    if (isset($_POST['nonce'])) {

        if (!wp_verify_nonce($_POST['nonce'], 'review')) {

            wp_send_json_error(['error' => 'Unauthorized Access']);
        }
    }

    wp_logout();

    echo json_encode(array('status' => 'success'));

    wp_redirect(home_url('/wp-admin'));

    wp_die();
}
