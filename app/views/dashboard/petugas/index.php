<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Parkify | Dashboard Petugas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Icons -->
    <link href="<?= BASE_URL ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- SB Admin 2 (TETAP) -->
    <link href="<?= BASE_URL ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="?url=petugas/index">
            <div class="sidebar-brand-icon">
                <i class="bi bi-car-front"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Parkify</div>
        </a>

        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="?url=petugas/index">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard Petugas</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Operasional Parkir</div>

        <li class="nav-item">
            <a class="nav-link" href="?url=parkir/masuk">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Parkir Masuk</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="?url=parkir/keluar">
                <i class="bi bi-box-arrow-left"></i>
                <span>Parkir Keluar</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="?url=log/index">
                <i class="fas fa-fw fa-table"></i>
                <span>Log Parkir</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- ===== END SIDEBAR ===== -->

    <!-- ===== CONTENT WRAPPER ===== -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- ===== TOPBAR ===== -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Petugas</span>
                            <img class="img-profile rounded-circle"
                                 src="<?= BASE_URL ?>assets/img/undraw_profile.svg">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow">
                            <a class="dropdown-item" href="?url=profile/index">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?url=auth/logout">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- ===== END TOPBAR ===== -->

            <!-- ===== PAGE CONTENT ===== -->
            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800">Dashboard Petugas</h1>

                <div class="row">

                    <div class="col-md-4 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Kendaraan Masuk Hari Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hariIni ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kendaraan Keluar Hari Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hariIniOut ?></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- ===== END PAGE CONTENT ===== -->

        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto text-center">
                <span>© Parkify 2026</span>
            </div>
        </footer>

    </div>
</div>

<!-- JS -->
<script src="<?= BASE_URL ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= BASE_URL ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= BASE_URL ?>assets/js/sb-admin-2.min.js"></script>

</body>
</html>
