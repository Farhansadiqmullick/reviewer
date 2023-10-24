<?php
global $wpdb;
$tablename = $wpdb->prefix . 'review';
$results = $wpdb->get_results("SELECT `category` FROM {$tablename} ORDER BY id DESC", ARRAY_A);
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
        $count = 0;
        if ($category_name) {
            $count = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$tablename} WHERE category = %s", $category_name));
        }
        return $count;
    }
} else {
    echo 'No Category Found';
}


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
                            <span class="mr-2 d-none d-lg-inline small">Gauri </span>
                            <img class="img-profile rounded-circle" src="https://www.igi.org/assets/images/expressions-2021/profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid">

                <!--dashboard-start-->
                <div class="row dashboard-boxes-row">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Total</div>

                                    </div>
                                    <?php
                                    $categories_total_count = get_option('categories-count');
                                    if ($categories_total_count) {
                                        echo '<div class="col-auto">';
                                        printf('<h3 class="text-primary">%s</h3>', esc_attr($categories_total_count));
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                    <?php
                                    $pass_count = get_option('pass-count');
                                    if ($pass_count) {
                                        echo '<div class="col-auto">';
                                        printf('<h3 class="text-success">%s</h3>', esc_attr($pass_count));
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pending</div>
                                    </div>

                                    <?php
                                    $pending_count = get_option('pending-count');
                                    if ($pending_count) {
                                        echo '<div class="col-auto">';
                                        printf('<h3 class="text-warning">%s</h3>', esc_attr($pending_count));
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Fail</div>
                                    </div>
                                    <?php
                                    $fail_count = get_option('fail-count');
                                    if ($fail_count) {
                                        echo '<div class="col-auto">';
                                        printf('<h3 class="text-danger">%s</h3>', esc_attr($fail_count));
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard-boxes-row">

                    <!-- Get the Category Details -->
                    <?php echo categories_cell($categories, 0);
                    $convertible_jewelry_content = get_review_content('convertible-jewelry_option');
                    echo wp_kses($convertible_jewelry_content['pass'], 'post');
                    echo wp_kses($convertible_jewelry_content['pending'], 'post');
                    echo wp_kses($convertible_jewelry_content['fail'], 'post');
                    ?>

                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->




                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <a href="">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-uppercase mb-1">Pending</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Fail</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row dashboard-boxes-row">
                    <?php echo categories_cell($categories, 1);
                    
                    $statement_piece_option = get_review_content('statement-piece_option');
                    echo wp_kses($statement_piece_option['pass'], 'post');
                    echo wp_kses($statement_piece_option['pending'], 'post');
                    echo wp_kses($statement_piece_option['fail'], 'post');
                    
                    ?>
                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-success pass-count">16</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <a href="https://www.igi.org/expressions_admin/fetch_data_update//P">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-uppercase mb-1">Pending</div>
                                        </div>
                                        <div class="col-auto">
                                            <h3 class="text-warning pending-count">0</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Fail</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-danger fail-count">206</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="row dashboard-boxes-row">

                    <?php echo categories_cell($categories, 2);
                    $perfume_bottle_jewelry_box_option = get_review_content('perfume-bottle-or-jewelry-box_option');
                    echo wp_kses($perfume_bottle_jewelry_box_option['pass'], 'post');
                    echo wp_kses($perfume_bottle_jewelry_box_option['pending'], 'post');
                    echo wp_kses($perfume_bottle_jewelry_box_option['fail'], 'post');

                    ?>

                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-success pass-count">16</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <a href="https://www.igi.org/expressions_admin/fetch_data_update//P">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-uppercase mb-1">Pending</div>
                                        </div>
                                        <div class="col-auto">
                                            <h3 class="text-warning pending-count">0</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Fail</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-danger fail-count">112</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!--dashboard-end-->


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
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>