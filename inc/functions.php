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

function get_unique_categories()
{
    $categories = get_all_design_category();
    $category_name = [];
    foreach ($categories as $category) {
        $category_name[] = $category['category'];
    }

    return array_unique($category_name);
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
        'jury1' => '',
        'jury2' => '',
        'jury3' => '',
        'jury4' => '',
        'jury5' => '',
    ];

    if (isset($data[$key])) {
        $result = [
            'id' => $data[$key]->id,
            'title' => $data[$key]->name,
            'image' => $data[$key]->file,
            'segment' => $data[$key]->segment,
            'category' => $data[$key]->category,
            'review' => $data[$key]->review,
            'description' => $data[$key]->description,
            'jury1' => $data[$key]->jury1,
            'jury2' => $data[$key]->jury2,
            'jury3' => $data[$key]->jury3,
            'jury4' => $data[$key]->jury4,
            'jury5' => $data[$key]->jury5
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

//jury Tasks
function update_jury_tasks_status()
{
    global $wpdb;

    // Define your table name
    $tablename = $wpdb->prefix . 'review';

    // Get distinct categories from the table
    $categories = $wpdb->get_col("SELECT DISTINCT `category` FROM {$tablename}");

    foreach ($categories as $category) {

        $current_user = wp_get_current_user();
        if (in_array('jury', $current_user->roles)) {
            $user_id = get_current_user_id();
            $roles = get_option('jury_assign_roles', array());
            if (in_array($user_id, $roles)) {
                $name = array_search($user_id, $roles);
                // Count 'submit' and 'pending' reviews for the current category and jury
                $id_query = $wpdb->prepare(
                    "SELECT `id` FROM {$tablename} WHERE `category` = %s AND `review` = 'pass'",
                    $category
                );

                $ids = $wpdb->get_results($id_query); // Get an array of IDs

                $submit_count = 0; // Initialize submit count
                $pending_count = 0;

                foreach ($ids as $id) {
                    $id_value = $id->id;

                    // Check if the jury has given a value for the current ID
                    $jury_value = $wpdb->get_var($wpdb->prepare(
                        "SELECT {$name} FROM {$tablename} WHERE `id` = %d",
                        $id_value
                    ));

                    if ($jury_value !== null) {
                        $submit_count++;
                    } else {
                        // The column is null
                        $pending_count++;
                    }
                }
                if ($wpdb->last_error) {
                    error_log(print_r($wpdb->last_error));
                    return '';
                }
                // Update the WordPress option for the current category
                update_option(strtolower(str_replace([' ', '_'], '-', $category . '-' . $name)) . "-value-option", array(
                    'submit' => $submit_count,
                    'pending' => $pending_count
                ));
            }
        }
    }
}

add_action('admin_init', 'get_all_tasks');
add_action('admin_init', 'update_jury_tasks_status');

function categories_cell($all_category, $key)
{
    $all_category = array_values(array_unique($all_category));
    // Check if the key exists in the array
    if (isset($all_category[$key])) {
        $category = $all_category[$key];
        $count = get_categories_count($category);
        $url = current_user_can('manage_options') ? '#' : esc_url(admin_url('admin.php?page=single-design&category_template=' . urlencode($category)));
        // Create the HTML for the category cell at the specified position
        $cell = <<<HEREDOC
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <a href="$url">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-lg font-weight-bold text-uppercase mb-1">$category</div>
                    </div>
                    <div class="col-auto">
                        <h3 class="text-primary categories-count">$count</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
HEREDOC;
        return $cell;
    } else {
        // Handle the case where the key does not exist in the array
        return '';
    }
}

function get_review_content($option_name)
{
    $options = get_option($option_name);

    if (!$options) return []; // If the option doesn't exist or has no values

    $content = [];

    foreach ($options as $key => $option) {
        switch ($key) {
            case 'pass':
                $content[$key] = '<div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                                </div>
                                                <div class="col-auto">
                                                <h3 class="text-success pass-count">' . $option . '</h3>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                break;

            case 'pending':
                $content[$key] = '<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-uppercase mb-1">Pending</div>
                            </div>
                            <div class="col-auto">
                                  <h3 class="text-warning pending-count">' . $option . '</h3>
                              </div>

                        </div>
                    </div>
                </div>
            </div>';
                break;

            case 'fail':
                $content[$key] = '<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-uppercase mb-1">Fail</div>
                            </div>
                            <div class="col-auto">
                                  <h3 class="text-danger fail-count">' . $option . '</h3>
                              </div>
                        </div>
                    </div>
                </div>
            </div>';

                break;

            default:
                return;
        }
    }

    return $content;
}

function get_jury_review_content($option_name)
{
    $options = get_option($option_name);

    if (!$options) return []; // If the option doesn't exist or has no values

    $content = [];

    foreach ($options as $key => $option) {
        switch ($key) {
            case 'submit':
                $content[$key] = '<div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-lg font-weight-bold text-uppercase mb-1">Submit</div>
                                                </div>
                                                <div class="col-auto">
                                                <h3 class="text-success pass-count">' . $option . '</h3>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                break;

            case 'pending':
                $content[$key] = '<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-uppercase mb-1">Pending</div>
                            </div>
                            <div class="col-auto">
                                  <h3 class="text-warning pending-count">' . $option . '</h3>
                              </div>

                        </div>
                    </div>
                </div>
            </div>';
                break;
            default:
                return;
        }
    }

    return $content;
}


function get_jury_name()
{
    $current_user = wp_get_current_user();
    $name = '';
    if (in_array('jury', $current_user->roles)) {
        $user_id = get_current_user_id();
        $roles = get_option('jury_assign_roles', array());
        if (in_array($user_id, $roles)) {
            $name = array_search($user_id, $roles);
        }
    }
    return $name;
}

function counting_start($number)
{
    $value = 2024011000000 + $number;
    return $value;
}
