<?php

class Review_Data
{

    public function __construct()
    {
        add_action('init', array($this, 'initialize_previous_entry_time'));
    }

    public function initialize_previous_entry_time()
    {
        return '';
    }


    public function review_get_data()
    {
        $all_data = get_option('submit_form_data');
        return $all_data;
    }
}
