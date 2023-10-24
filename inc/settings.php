<div class="table-responsive w-50 my-4 ml-2">
    <caption>List of Jury and Assign Their Roles</caption>
    <?php

    $users_count = count_users();
    $jury_users = get_users(array('role' => 'jury'));
    $jury_count = isset($users_count['avail_roles']['jury']) ? $users_count['avail_roles']['jury'] : 0;
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Jury</th>
                <th>Assign Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the static values for the first column
            for ($i = 1; $i <= $jury_count; $i++) {
                echo '<tr>';
                // First column with static value
                echo '<td>Jury ' . $i . '</td>';
                echo '<td>';
                echo '<select name="jury' . $i . '">';
                // Get the saved option values
                $roles = get_option('jury_assign_roles', array());

                // Check if the option exists for the current select element
                if (isset($roles['jury' . $i])) {
                    $selected_value = $roles['jury' . $i];
                } else {
                    $selected_value = ''; // Default value if not found
                }

                // Loop through the "jury" role users for the select options
                foreach ($jury_users as $user) {
                    $user_id = esc_attr($user->ID);
                    $selected = ($user_id == $selected_value) ? 'selected="selected"' : '';
            
                    echo '<option value="' . $user_id . '" ' . $selected . '>' . esc_html($user->display_name) . '</option>';
                }
                echo '</select>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <input type="submit" id="save-options" class="button button-primary" name="submit" value="Save Option">
</div>