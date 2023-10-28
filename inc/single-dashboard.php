<?php
global $wpdb;
$tablename = $wpdb->prefix . 'review';

$category_name = $_GET['category_template']; // Get the category name from the URL parameter
$id = $_GET['id'];

if (empty($category_name)) {
    $categories = get_unique_categories();
    // print_r($categories);
    echo '<select class="text-center mx-auto my-4" name="category" id="single_page_category">
<option value="0">Choose Category</option>';
    foreach ($categories as $category) {
        printf(
            '<option value="%s">%s</option>',
            esc_url(admin_url('admin.php?page=single-design&category_template=' . esc_attr($category))),
            esc_html($category)
        );
    }
    echo '</select>';
} else {

    //get the user roles
    $current_user = wp_get_current_user();

    if (in_array('jury', $current_user->roles)) {
        require_once 'roles/jury.php';
    } elseif (in_array('reviewer', $current_user->roles)) {
        require_once 'roles/reviewer.php';
    } elseif (in_array('administrator', $current_user->roles)) {
        require_once 'roles/administrator.php';
    }
}
