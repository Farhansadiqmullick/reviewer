<?php
// Use prepare to avoid SQL injection
$query = $wpdb->prepare("SELECT * FROM {$tablename} WHERE category = %s AND `review` LIKE 'pass'", $category_name);

if ($query) {
    // Use get_results to retrieve multiple rows
    $results = $wpdb->get_results($query);
    // var_dump($results);
    // Check for errors
    if ($wpdb->last_error) {
        echo "Database error: " . $wpdb->last_error;
    } else {
        $key_value = 0;
        $total = absint(count($results));
        if (isset($results[$key_value])) {
            $result = get_data_by_key($results, $key_value);
            $value = isset($result) && !empty($result) ? $result : [];
        }
    }

    function marks_icon($number, $class)
    {
        $content = '';
        $content .= '<div class="d-flex flex-row ' . $class . '">';
        for ($i = 0; $i < $number; $i++) {
            $content .= '<i class="icon-rectangle"></i>';
        }
        $content .= '<span class="' . $class . '"></span></div>';
        return $content;
    }

    if ($value) :
        $name = get_jury_name();
        $user_id = get_current_user_id();
?>

        <div class="single-design mb-4">
            <div class="container" style="background-color: #eee;">
                <a href="<?php echo esc_url(admin_url('admin.php?page=jury-worksheet')); ?>" class="float-right btn btn-secondary back">Back</a>
                <div class="d-flex flex-column m-3 p-0 w-75">
                    <?php
                    if ($value['title']) {
                        printf('<h4 class="entry-content d-inline-block mb-4">%s</h4>', esc_html($value['title']));
                    }
                    printf('<h6>Items <span class="review-jury-key">%s</span>/<span>%s</span></h6>', $key_value, $total);
                    ?>
                    <div class="d-flex flex-row m-2">
                        <button class="prev-jury btn btn-secondary" data-category="<?php echo $category_name; ?>" data-key=<?php echo $key_value; ?> data-count="0">Prev</button>
                        <button class="next-jury btn btn-primary" data-category="<?php echo $category_name; ?>" data-key=<?php echo $key_value; ?> data-count="<?php echo $total; ?>">Next</button>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <div class="d-flex flex-column align-items-start bg-white shadow p-3 mb-5 rounded">
                        <span class="align-self-center">Roll Over Image to Zoom in</span>
                        <?php
                        if ($value['image']) {
                            echo '<div class="zoom-box">';
                            printf('<img src="%s" width="400" height="500" />', esc_url($value['image']));
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="d-flex flex-column align-items-start bg-white shadow p-3 mb-5 rounded h-auto" style="min-width: 650px; width: auto;">
                        <h5 style="color:#BE768A">Submission Details</h5>
                        <div class="d-flex flex-column flex-md-row w-100 align-items-start">
                            <div class="w-25">
                                <?php
                                if ($value['id']) {
                                    echo '<span>ID</span>';
                                    printf('<p class="entry-id">%s</p>', absint($value['id']));
                                }
                                ?>
                            </div>
                            <div class="w-25">
                                <?php
                                if ($value['segment']) {
                                    echo '<span>Segement</span>';
                                    printf('<p class="segment" data-juryuserid="%s">%s</p>', absint($user_id), esc_html($value['segment']));
                                }
                                ?>

                            </div>
                            <div class="w-50">
                                <?php
                                if ($value['category']) {
                                    echo '<span>Category</span>';
                                    printf('<p class="review-category">%s</p>', esc_html($value['category']));
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                        if ($value['description']) {
                            echo '<div>
                            <span>Description</span>';
                            printf('<p class="description">%s</p>', $value['description']);
                            echo '</div>';
                        }

                        if ((isset($value[$name]))) {
                            printf('<h6>Marks Submitted: <span class="jury-total-marks" data-name=%s data-juryvalue=%s>%s</span></h6>', array_search($value[$name], $value), esc_attr($value[$name]), esc_attr($value[$name]));
                        }

                        ?>

                        <div class="jury-marking d-flex flex-row flex-wrap m-2">
                            <div class="d-flex flex-column">
                                <label for="relevant-design">Relevant design</label>
                                <?php echo marks_icon(10, 'relevant-design'); ?>
                            </div>
                            <div class="d-flex flex-column">
                                <label for="wearability">Wearability</label>
                                <?php echo marks_icon(10, 'wearability'); ?>
                            </div>
                            <div class="d-flex flex-column">
                                <label for="aesthatics">Aesthatics</label>
                                <?php echo marks_icon(10, 'aesthatics'); ?>
                            </div>
                        </div>
                        <div class="jury-average d-flex flex-column mt-2 mb-4 mx-0">
                            <span>Total Average Marks</span>
                            <span class="jury-average-marks"></span>
                        </div>
                        <input type="submit" name="single-jury-submit" class="single-jury-submit btn btn-primary text-white fw-bold px-5 py-2" value="Submit" />
                    </div>

                </div>
            </div>
        </div>
    <?php
    else :
    ?>
        <div class="text-center my-4 mx-auto">
            <h5 class='text center my-4'>Please get back to the Jury Page. This page needs for Reviewer <a class='btn btn-primary my-2 mx-4' href="<?php echo admin_url('admin.php?page=jury-worksheet'); ?>">Jury Worksheet</a></h5>
        </div>

<?php
    endif;
}
?>