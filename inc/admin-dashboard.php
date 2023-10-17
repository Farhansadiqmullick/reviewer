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
                                    <div class="col-auto">
                                        <h3 class="text-primary">536</h3>
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
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-success">46</h3>
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
                                        <h3 class="text-warning">0</h3>
                                    </div>
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
                                    <div class="col-auto">
                                        <h3 class="text-danger">490</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard-boxes-row">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <a href="https://www.igi.org/expressions_admin/fetch_data_update/8">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-uppercase mb-1">Lightweight Jewelry Total</div>
                                        </div>
                                        <div class="col-auto">
                                            <h3 class="text-primary">186</h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-success">14</h3>
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
                                            <h3 class="text-warning">0</h3>
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
                                        <h3 class="text-danger">172</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard-boxes-row">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <a href="https://www.igi.org/expressions_admin/fetch_data_update/5">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-uppercase mb-1">Statement Piece Total</div>
                                        </div>
                                        <div class="col-auto">
                                            <h3 class="text-primary">222</h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-success">16</h3>
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
                                            <h3 class="text-warning">0</h3>
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
                                        <h3 class="text-danger">206</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row dashboard-boxes-row">

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <a href="https://www.igi.org/expressions_admin/fetch_data_update/11">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-lg font-weight-bold text-uppercase mb-1">Accessory Total</div>
                                        </div>
                                        <div class="col-auto">
                                            <h3 class="text-primary">128</h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-lg font-weight-bold text-uppercase mb-1">Pass</div>
                                    </div>
                                    <div class="col-auto">
                                        <h3 class="text-success">16</h3>
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
                                            <h3 class="text-warning">0</h3>
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
                                        <h3 class="text-danger">112</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--dashboard-end-->


                <!-- Page Heading -->
                <div class="row">
                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <h1 class="h3 mb-4 text-black">Expressions List</h1>
    </div> -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                        <a class='btn btn-primary' href='https://www.igi.org/expressions_admin/submissions_check/'>Start Review</a>

                        <a class='btn btn-primary' data-fancybox="" href='https://www.igi.org//assets/expressions-admin/video/ReviewerProcessVideo.mp4'>Process Video</a>
                    </div>
                </div>

            </div><!--container-fluid--->

        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; IGI Expressions 2021</span>
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