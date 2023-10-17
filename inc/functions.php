<?php
if (!defined('ABSPATH')) exit;


function logout_current_user()
{
    wp_logout();
    wp_redirect(home_url('/wp-admin'));
    exit;
}

function add_jury_role()
{
    $capabilities = array(
        'read'           => true,
        'jury_access'    => true,
    );

    add_role('jury', 'Jury', $capabilities);

    $admin_role = get_role('administrator');
    if ($admin_role) {
        $admin_role->add_cap('jury_access');
    }
}
add_action('init', 'add_jury_role');
