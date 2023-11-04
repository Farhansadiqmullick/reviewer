                <!--dashboard-start-->
                <div class="row dashboard-boxes-row">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Total</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-primary total-categories-count"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Submit</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-success total-pass-count"></h3>
                                    </div>

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
                                    <div class="col-auto">
                                        <h3 class="text-warning total-pending-count"></h3>
                                    </div>
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
                        if (in_array('jury', $current_user->roles)) {
                            $name = get_jury_name();
                            $convertible_jewelry_content = get_jury_review_content('convertible-jewelry-' . $name . '-value-option');
                            echo wp_kses($convertible_jewelry_content['submit'], 'post');
                            echo wp_kses($convertible_jewelry_content['pending'], 'post');
                        }
                    }
                    ?>
                </div>
                <div class="row dashboard-boxes-row">
                    <?php
                    if ("" != categories_cell($categories, 1)) {
                        echo categories_cell($categories, 1);
                        if (in_array('jury', $current_user->roles)) {
                            $name = get_jury_name();
                            $convertible_jewelry_content = get_jury_review_content('statement-piece-' . $name . '-value-option');
                            echo wp_kses($convertible_jewelry_content['submit'], 'post');
                            echo wp_kses($convertible_jewelry_content['pending'], 'post');
                        }
                    }

                    ?>
                </div>

                <div class="row dashboard-boxes-row">

                    <?php
                    if ("" != categories_cell($categories, 2)) {
                        echo categories_cell($categories, 2);
                        if (in_array('jury', $current_user->roles)) {
                            $name = get_jury_name();
                            $convertible_jewelry_content = get_jury_review_content('perfume-bottle-or-jewelry-box-' . $name . '-value-option');
                            echo wp_kses($convertible_jewelry_content['submit'], 'post');
                            echo wp_kses($convertible_jewelry_content['pending'], 'post');
                        }
                    }
                    ?>
                </div>

                <!--dashboard-end-->

                <div class="process-video my-3 text-center">
                    <div class="btn btn-primary">Process Video</div>
                </div>