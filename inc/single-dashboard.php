<?php

global $wpdb;
$tablename = $wpdb->prefix . 'review';

$category_name = $_GET['category_template']; // Get the category name from the URL parameter

// Use prepare to avoid SQL injection
$query = $wpdb->prepare("SELECT * FROM {$tablename} WHERE category = %s", $category_name);

// Use get_results to retrieve multiple rows
$results = $wpdb->get_results($query);

// Check for errors
if ($wpdb->last_error) {
    echo "Database error: " . $wpdb->last_error;
} else {
    // Print the results
    print_r($results);
}
