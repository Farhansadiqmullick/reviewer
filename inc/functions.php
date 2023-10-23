<?php
if (!defined('ABSPATH')) exit;


function logout_current_user()
{
    wp_logout();
    wp_redirect(home_url('/wp-admin'));
    exit;
}

function add_roles()
{
    $capabilities = array(
        'read'           => true,
        'jury_access'    => true,
    );

    add_role('jury', 'Jury', $capabilities);
    add_role('reviewer', 'Reviewer', $capabilities);

    $admin_role = get_role('administrator');
    if ($admin_role) {
        $admin_role->add_cap('jury_access');
    }
}
add_action('init', 'add_roles');


function get_all_design_category()
{
    global $wpdb;
    $tablename = $wpdb->prefix . 'review';
    return $wpdb->get_results("SELECT `category` FROM {$tablename} ORDER BY id DESC", ARRAY_A);
}


function get_data_by_key($data, $key)
{
    $result = [
        'id' => '',
        'title' => '',
        'image' => '',
        'segment' => '',
        'category' => '',
        'description' => '',
        'review' => '',
    ];

    if (isset($data[$key])) {
        $result = [
            'id' => $data[$key]->id,
            'title' => $data[$key]->name,
            'image' => $data[$key]->file,
            'segment' => $data[$key]->segment,
            'category' => $data[$key]->category,
            'review' => $data[$key]->review,
            'description' => $data[$key]->description
        ];
    }

    return $result;
}


//get all category tasks

function get_all_tasks()
{
    global $wpdb;

    // Define your table name
    $tablename = $wpdb->prefix . 'review';

    // Get distinct categories from the table
    $categories = $wpdb->get_col("SELECT DISTINCT `category` FROM {$tablename}");

    foreach ($categories as $category) {
        // Count for 'pass' reviews
        $pass_count = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$tablename} WHERE `category` = %s AND `review` LIKE 'pass'", $category));


        // Count for 'fail' reviews
        $fail_count = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$tablename} WHERE `category` = %s AND `review` LIKE 'fail%'", $category));
        // Count for 'pending' reviews (neither 'pass' nor 'fail')
        $pending_count = (int) $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$tablename} WHERE `category` = %s AND `review` NOT LIKE 'pass' AND `review` NOT LIKE 'fail%'", $category));

        // Update the WordPress option for the current category
        update_option(str_replace([' ', '_'], '-', strtolower($category)) . "_option", array(
            'pass' => $pass_count,
            'fail' => $fail_count,
            'pending' => $pending_count
        ));
    }
}

add_action('admin_init', 'get_all_tasks');

// function category_template_query_var($vars) {
//     $vars[] = 'category_template';
//     return $vars;
// }
// add_filter('query_vars', 'category_template_query_var');

// function category_template($template) {
//     $category_template = get_query_var('category_template');
//     foreach(get_all_design_category() as $category){
//         if (isset($_GET['page']) && $_GET['page'] == 'jury-worksheet' && isset($_GET['category_template']) && ($category_template == $category['category'])) {
//             $template = dirname(__DIR__) . '/templates/category-template.php';   
//         }
//     }

//     return $template;
// }
// add_filter('template_include', 'category_template');
