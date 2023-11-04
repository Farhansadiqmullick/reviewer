<?php

/*
  Plugin Name: Desgin Reviewer
  Description: Review the Submitted Design
  Author: Farhan Mullick
  Author URI: https://farhanmullick.com
  Version: 1.0.0
  License: GPLv2 or later
  Text Domain: review
  Domain Path: /languages/
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class DES_REVIEW
{
    public $tablename;
    public $charset;
    public $current_user;
    public function __construct()
    {
        global $wpdb;
        $this->charset = $wpdb->get_charset_collate();
        $this->tablename = $wpdb->prefix . 'review';
        $this->current_user = '';
        $plugin_basename = plugin_basename(__FILE__);
        add_action('plugins_loaded', array($this, 'review_plugins_loaded'));
        add_action('admin_enqueue_scripts', array($this, 'load_assets'));
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));
        add_filter('admin_menu', array($this, 'review_menu'));
        register_activation_hook(__FILE__, array($this, 'review_database_init'));
        add_filter("plugin_action_links_$plugin_basename", [$this, 'add_settings_link']);
    }

    public function review_plugins_loaded()
    {
        load_plugin_textdomain('review_languages', false, plugin_dir_path(__FILE__) . '/languages');
        $this->include_files('inc/ajax.php');
        $this->include_files('helpers.php');
        $this->include_files('public/frontend.php');
        $this->include_files('inc/functions.php');
    }

    public function load_assets($hooks)
    {
        wp_enqueue_style('google-nunito-min', 'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i', null, '');
        wp_enqueue_style('sb-admin', plugin_dir_url(__FILE__) . 'assets/css/sb-admin.css', null, '', 'all');
        // $plugin_pages = [
        //     'design-review_page_single-design', 'toplevel_page_review', 'design-review_page_jury-worksheet',
        // ];

        wp_enqueue_script('jquery-min', '//code.jquery.com/jquery-3.6.0.min.js');
        wp_enqueue_script('popper-bootstrap', '//cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js', ['jquery'], '', true);
        wp_enqueue_script('bootstrap-min', '//cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js', ['jquery'], '', true);

        wp_enqueue_style('font-awesome-min', plugin_dir_url(__FILE__) . 'assets/css/all.min.css', null, '', 'all');
        wp_enqueue_style('datatables-bootstrap-min', plugin_dir_url(__FILE__) . 'assets/css/dataTables-bootstrap.min.css', null, '', 'all');
        wp_enqueue_style('jq-zoom', plugin_dir_url(__FILE__) . 'assets/css/jquery.jqZoom.css', null, rand(111, 999), 'all');
        wp_enqueue_style('datatable', '//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css', null, '', 'all');
        wp_enqueue_style('buttons-datatable', 'https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css', null, '', 'all');
        wp_enqueue_style('custom', plugin_dir_url(__FILE__) . 'assets/css/custom.css', null, '', 'all');
        wp_enqueue_style('review-style', plugin_dir_url(__FILE__) . 'assets/css/style.css', null, rand(111, 999), 'all');

        // wp_enqueue_script('jquery-slim', '//code.jquery.com/jquery-3.3.1.slim.min.js');
        wp_enqueue_script('iconify-icon', 'https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js', ['jquery'], '', true);
        wp_enqueue_script('datatable', '//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js', ['jquery'], '', true);
        wp_enqueue_script('datatable-button', 'https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js', ['jquery'], '', true);
        wp_enqueue_script('jsZip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js', ['jquery'], '', true);
        wp_enqueue_script('pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', ['jquery'], '', true);
        wp_enqueue_script('pdf-vfs', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', ['jquery'], '', true);
        wp_enqueue_script('button-html', 'https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js', ['jquery'], '', true);
        wp_enqueue_script('jq-zoom', plugin_dir_url(__FILE__) . 'assets/js/jquery.jqZoom.js', ['jquery'], rand(111, 999), true);
        wp_enqueue_script('review-script', plugin_dir_url(__FILE__) . 'assets/js/main.js', ['jquery'], rand(111, 999), true);
        $data_to_localize = array(
            'ajaxurl' => admin_url("admin-ajax.php"),
            'nonce'   => wp_create_nonce('review'),
        );
        $localize_names = array('formurl', 'keyurl', 'keyjuryurl', 'reviewstatus', 'totalcategory', 'juryassign', 'jurymarks', 'logout');

        foreach ($localize_names as $variable_name) {
            wp_localize_script('review-script', $variable_name, $data_to_localize);
        }
    }

    public function review_database_init()
    {
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
        dbDelta("CREATE TABLE $this->tablename (
id INT NOT NULL AUTO_INCREMENT,
name varchar(120) NOT NULL DEFAULT '',
email varchar(120) NOT NULL DEFAULT '',
phone varchar(30) NOT NULL DEFAULT '',
country varchar(60) NOT NULL DEFAULT '',
category varchar(60) NOT NULL DEFAULT '',
segment varchar(60) NOT NULL DEFAULT '',
description varchar(256) NOT NULL DEFAULT '',
file varchar(120) NOT NULL DEFAULT '',
review varchar(300) NOT NULL DEFAULT '',
jury1 varchar(60) NOT NULL DEFAULT '',
jury2 varchar(60) NOT NULL DEFAULT '',
jury3 varchar(60) NOT NULL DEFAULT '',
jury4 varchar(60) NOT NULL DEFAULT '',
jury5 varchar(60) NOT NULL DEFAULT '',
PRIMARY KEY (id)
) $this->charset;");

        wp_safe_redirect(admin_url('admin.php?page=review'));
    }


    function redirect_review_after_activation()
    {
        $admin_url = esc_url(admin_url('admin.php?page=review'));
        wp_redirect($admin_url);
        exit();
    }

    public function add_settings_link($links)
    {
        $settings_link = '<a href=' . esc_url(admin_url('admin.php?page=review')) . '>Settings</a>';
        if (($key = array_search('Deactivate', $links)) !== false) {
            unset($links[$key]);
        }
        array_unshift($links, $settings_link);
        return $links;
    }


    public function include_files($filename)
    {
        if ($filename) {
            return require_once plugin_dir_path(__FILE__) . $filename;
        }
        return '';
    }

    public function review_menu()
    {
        add_menu_page('Design Review', 'Design Review', 'manage_options', 'review', [$this, 'review_options'], plugins_url('images/design.svg', __FILE__));
        add_submenu_page('review', 'Settings', 'Settings', 'manage_options', 'settings', [$this, 'jury_option_settings']);
        add_submenu_page('review', 'Jury Worksheet', 'Jury Worksheet', 'jury_access', 'jury-worksheet', [$this, 'jury_worksheet_options']);
        add_submenu_page('review', 'Single Design', 'Single Design', 'jury_access', 'single-design', [$this, 'jury_single_design_options']);
    }

    public function review_options()
    {
        $this->current_user = wp_get_current_user();
        echo '<h3>Design Reviewer</h3>';
        if (in_array('jury', $this->current_user->roles)) {
            wp_safe_redirect(admin_url('admin.php?page=jury-worksheet'));
            exit;
        } else if (in_array('reviewer', $this->current_user->roles)) {
            wp_safe_redirect(admin_url('admin.php?page=jury-worksheet'));
            exit;
        }
        $this->include_files('inc/admin-dashboard.php');
    }

    public function jury_worksheet_options()
    {
        $this->current_user = wp_get_current_user();
        $this->include_files('inc/admin-dashboard.php');
    }

    public function jury_single_design_options()
    {
        $this->include_files('inc/single-dashboard.php');
    }

    public function jury_option_settings()
    {
        $this->include_files('inc/settings.php');
    }
}

new DES_REVIEW();
