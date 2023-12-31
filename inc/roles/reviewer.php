<?php
// Use prepare to avoid SQL injection
$query = $wpdb->prepare("SELECT * FROM {$tablename} WHERE category = %s", $category_name);

// Use get_results to retrieve multiple rows
$results = $wpdb->get_results($query);
// var_dump($results);
// Check for errors
if ($wpdb->last_error) {
    echo "Database error: " . $wpdb->last_error;
} else {
    $key_value = count($results) - 1;
    $total = absint(count($results));
    if (isset($results[$key_value])) {
        $result = get_data_by_key($results, $key_value);
        $value = isset($result) && !empty($result) ? $result : [];
    }
}

if ($value) :
?>

    <div class="single-design mb-4">
        <div class="container" style="background-color: #eee;">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jury-worksheet')); ?>" class="float-right btn btn-secondary back">Back</a>
            <div class="d-flex flex-column m-3 p-0 w-75">
                <?php
                if ($value['title']) {
                    printf('<h4 class="entry-content d-inline-block mb-4">%s</h4>', esc_html($value['title']));
                }
                // $key_value =  get_option('key_value');
                printf('<h6>Items <span class="review-key">%s</span>/<span>%s</span></h6>', $key_value, $total);
                ?>
                <div class="d-flex flex-row m-2">
                    <button class="prev btn btn-secondary" data-category="<?php echo $category_name; ?>" data-key=<?php echo $key_value; ?> data-count="0">Prev</button>
                    <button class="next btn btn-primary" data-category="<?php echo $category_name; ?>" data-key=<?php echo $key_value; ?> data-count="<?php echo $total; ?>">Next</button>
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
                        <?php
                        if ($value['id']) {
                            echo '<div class="w-25">';
                            echo '<span>ID</span>';
                            printf('<p class="entry-id">%s</p>', absint($value['id']));
                            echo '</div>';
                        }
                        ?>

                        <div class="w-25">
                            <?php
                            if ($value['segment']) {
                                echo '<span>Segement</span>';
                                printf('<p class="segment">%s</p>', esc_html($value['segment']));
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
                    ?>

                    <div class="d-flex flex-row m-2">
                        <div class="form-check">
                            <input type="radio" id="passRadio" name="status" value="pass" />
                            <label class="pass form-check-label" for="passRadio">Pass</label>

                            <input type="radio" id="failRadio" name="status" value="fail" />
                            <label class="fail form-check-label" for="failRadio">Fail</label>
                        </div>
                    </div>
                    <?php
                    if (isset($value['review'])) : ?>
                        <div class="mt-4 bg-white text-dark">Review given: <p class="given-review" style="color:#BE768A"></p>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex flex-column w-100 my-3">
                        <span>Review</span>
                        <textarea name="issue" id="issue" columns="100" rows="5"></textarea>
                    </div>
                    <input type="submit" name="single-dashboard-submit" class="single-dashboard-submit btn btn-primary text-white fw-bold px-5 py-2" value="Submit" />
                </div>

            </div>
        </div>
    </div>
<?php
endif;
?>