<?php
global $wpdb;
$tablename = $wpdb->prefix . 'review';
$current_user = wp_get_current_user();
if (in_array('jury', $current_user->roles)) {
    $results = $wpdb->get_results("SELECT `category` FROM {$tablename} WHERE `review` = 'pass' ORDER BY `id` DESC", ARRAY_A);
}
if (in_array('reviewer', $current_user->roles)) {
    $results = $wpdb->get_results("SELECT `category` FROM {$tablename} ORDER BY id DESC", ARRAY_A);
}
if (in_array('administrator', $current_user->roles)) {
    $results = $wpdb->get_results("SELECT `category` FROM {$tablename} ORDER BY id DESC", ARRAY_A);
}

$categories = [];
$category_count = '';
if ($results) {
    foreach ($results as $category) {
        $categories[] = $category['category'];
    }

    function get_categories_count($category_name)
    {
        global $wpdb;
        $tablename = $wpdb->prefix . 'review';
        $current_user = wp_get_current_user();
        $count = 0;
        if ($category_name) {

            if (in_array('jury', $current_user->roles)) {
                $count = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$tablename} WHERE category = %s AND `review` = 'pass'", $category_name));
            } else {
                $count = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$tablename} WHERE category = %s", $category_name));
            }
        }
        return $count;
    }
} else {
    echo 'No Category Found';
}

$user_role = ucwords($this->current_user->roles[0]);

?>
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo plugins_url('images/sm-logo.png', __DIR__) ?>" class="img-fluid" />
                    <span>IGI Expressions</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link small active" aria-current="page" href="<?php echo admin_url('admin.php?page=review'); ?>">Expressions List</a>
                    </li>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline small text-black"><?php echo get_the_author_meta('display_name', $current_user->id); ?> </span>
                            <?php
                            echo '<img class="img-profile rounded-circle" src="https://www.igi.org/assets/images/expressions-2021/profile.svg">';
                            ?>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="">
                                <i class="icon-sign-out"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <h6>User Login as: <strong><?php echo esc_attr($user_role) ?></strong></h6>
            <div class="container-fluid">

                <?php
                if (in_array('jury', $current_user->roles)) {
                    require_once 'admin/jury-dashboard.php';
                } else {
                    require_once 'admin/review-dashboard.php';
                }
                ?>

                <!-- Page Heading -->
                <div class="row">
                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <h1 class="h3 mb-4 text-black">Expressions List</h1>
    </div> -->
                    <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                        <a class='btn btn-primary' href='https://www.igi.org/expressions_admin/submissions_check/'>Start Review</a>

                        <a class='btn btn-primary' data-fancybox="" href='https://www.igi.org//assets/expressions-admin/video/ReviewerProcessVideo.mp4'>Process Video</a>
                    </div> -->
                </div>
                <?php
                if (current_user_can('manage_options')) :
                    global $wpdb;
                    $query = $wpdb->prepare(
                        "SELECT id, name, email, phone, country, category, description, file, segment, segment, jury1, jury2, jury3, jury4, jury5, review
                        FROM {$tablename}
                        ORDER BY id DESC",
                        ARRAY_A
                    );
                    $values = $wpdb->get_results($query, ARRAY_A);
                    if ($wpdb->last_error) {
                        echo 'wpdb error: ' . $wpdb->last_error;
                        return '';
                    }
                    if ($values) :
                        $first_row = reset($values);
                        $table_headers = array_keys($first_row);
                ?>
                        <div class="my-4 mx-0">
                            <table id="admin-table" class="table table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <?php foreach ($table_headers as $header) : ?>
                                            <th><?php echo esc_html($header); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($values as $row) : ?>
                                        <tr>
                                            <?php foreach ($row as $key => $cell) :
                                                if ($key == 'id') :
                                            ?>
                                                    <td><a target="_blank" href="<?php echo admin_url('admin.php?page=single-design&category_template=' . urlencode($row['category']) . '&id=' . $cell); ?>"><?php echo esc_html($cell); ?></td>
                                                <?php else : ?>
                                                    <td><?php echo esc_html($cell); ?></td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div><!--container-fluid--->

        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; IGI Expressions 2023</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="#">Logout</a>
            </div>
        </div>
    </div>
</div>