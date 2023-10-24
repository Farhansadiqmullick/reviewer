<div class="table-responsive w-50 my-4 ml-2">
    <caption>List of Jury and Assign Their Roles</caption>
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Jury</th>
            <th>Assign Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Get users with the "jury" role in WordPress
        $jury_users = get_users(array('role' => 'jury'));

        // Loop through the static values for the first column
        for ($i = 1; $i <= 5; $i++) {
            echo '<tr>';
            // First column with static value
            echo '<td>Jury ' . $i . '</td>';
            // Second column with select box
            echo '<td>';
            echo '<select name="jury_' . $i . '">';

            // Loop through the "jury" role users for the select options
            foreach ($jury_users as $user) {
                echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
            }

            echo '</select>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
</div>