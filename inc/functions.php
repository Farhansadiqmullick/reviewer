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


function get_data_by_key($data, $key) {
    $result = [
        'title' => '',
        'image' => '',
        'segment' => '',
        'category' => '',
        'description' => ''
    ];

    if (isset($data[$key])) {
        $result = [
            'title' => $data[$key]->name,
            'image' => $data[$key]->file,
            'segment' => $data[$key]->segment,
            'category' => $data[$key]->category,
            'description' => $data[$key]->description
        ];
    }

    return $result;
}



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
