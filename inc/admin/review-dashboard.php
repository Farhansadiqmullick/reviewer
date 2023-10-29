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
                    <?php
                    if ("" != categories_cell($categories, 0)) {
                        echo categories_cell($categories, 0);
                        $convertible_jewelry_content = get_review_content('convertible-jewelry_option');
                        echo wp_kses($convertible_jewelry_content['pass'], 'post');
                        echo wp_kses($convertible_jewelry_content['pending'], 'post');
                        echo wp_kses($convertible_jewelry_content['fail'], 'post');
                    }
                    ?>
                </div>
                <div class="row dashboard-boxes-row">
                    <?php
                    if ("" != categories_cell($categories, 1)) {
                        echo categories_cell($categories, 1);
                        $convertible_jewelry_content = get_review_content('statement-piece_option');
                        echo wp_kses($convertible_jewelry_content['pass'], 'post');
                        echo wp_kses($convertible_jewelry_content['pending'], 'post');
                        echo wp_kses($convertible_jewelry_content['fail'], 'post');
                    }

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

                    <?php
                    if ("" != categories_cell($categories, 2)) {
                        echo categories_cell($categories, 2);
                        $convertible_jewelry_content = get_review_content('perfume-bottle-or-jewelry-box_option');
                        echo wp_kses($convertible_jewelry_content['pass'], 'post');
                        echo wp_kses($convertible_jewelry_content['pending'], 'post');
                        echo wp_kses($convertible_jewelry_content['fail'], 'post');
                    }
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