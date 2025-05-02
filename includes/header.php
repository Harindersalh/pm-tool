    <?php
    require_once 'db.php';
    require_once __DIR__ . '/functions.php';

    if (!isAuth()) {
        header('Location: ' . BASE_URL . '/login.php');
        exit();
    }

    $user_id = $_SESSION['user_id'] ?? null;
    $userProfile = userProfile();
    $userId = $userProfile['id'];
    $sql = "SELECT * FROM notifications WHERE user_id = '$userId' ORDER BY created_at DESC ";
    $query = mysqli_query($conn, $sql);

    $notifications = [];
    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $notifications[] = $row;
        }
    }
    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?php echo isset($page_title) ? $page_title : 'PM Tool'; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
        <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/assets/images/favicon.ico">
        <link href="<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>/assets/css/style.css" id="style" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/assets/libs/bootstrap-daterangepicker/css/daterangepicker.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>/assets/libs/summernote/summernote-bs4.min.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">
        <script src="<?php echo BASE_URL; ?>/assets/libs/jquery/jquery.min.js"></script>
    </head>

    <body data-sidebar="dark">
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box">
                            <a href="<?php echo BASE_URL; ?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/small-logo.png" alt="" height="32">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="" height="17">
                                </span>
                            </a>
                            <a href="<?php echo BASE_URL; ?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/small-logo.png" alt="" height="32">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="" height="32">
                                </span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                    </div>
                    <div class="d-flex">
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="bx bx-fullscreen"></i>
                            </button>
                        </div>


                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-bell bx-tada"></i>
                                <span class="badge bg-danger rounded-pill"><?php echo count($notifications); ?></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="<?php echo BASE_URL; ?>/notifications.php" class="btn btn-sm btn-link font-size-14 text-center">view more</a>

                                        </div>
                                    </div>
                                </div>

                                <?php foreach (array_slice($notifications, 0, 5) as $noti): ?>
                                    <a href="<?php echo htmlspecialchars($noti['link']); ?>" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 32px;">
                                                    <i class="bx bxs-bell"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?php echo htmlspecialchars($noti['message']); ?></h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-0">
                                                        <i class="mdi mdi-clock-outline"></i>
                                                        <?php echo htmlspecialchars($noti['created_at']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>


                                <?php if (count($notifications) > 5): ?>
                                    <div class="p-2 border-top d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center" href="http://localhost/test/pm-tool/notifications.php">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                                        </a>

                                    </div>

                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?php echo BASE_URL; ?>/assets/images/default-user.png"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1"><?php echo userProfile()['name']; ?></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile.php"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span>Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/logout.php"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span>Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="vertical-menu">
                <div data-simplebar class="h-100">
                    <div id="sidebar-menu">
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="<?php echo BASE_URL ?>/index.php" class="waves-effect">
                                    <i class="bx bx-home"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-title">Daily Report</li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/daily-report/index.php" class="waves-effect">
                                    <i class="bx bxs-report"></i>
                                    <span>Daily Report</span>
                                </a>
                            </li>
                            <li class="menu-title">Projects</li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/projects/index.php" class="waves-effect">
                                    <i class="bx bx-rocket"></i>
                                    <span>Projects</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/milestones/index.php" class="waves-effect">
                                    <i class="bx bx-target-lock"></i>
                                    <span>Milestones</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/clients/index.php" class="waves-effect">
                                    <i class="bx bx-user"></i>
                                    <span>Clients</span>
                                </a>
                            </li>
                            <li class="menu-title">HR</li>
                            <?php
                            if (isset($userProfile['role']) && ($userProfile['role'] == 'hr' || $userProfile['role'] == 'admin')) {
                            ?>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/employees/index.php" class="waves-effect">
                                        <i class="bx bx-user"></i>
                                        <span>Employees</span>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/holidays/index.php" class="waves-effect">
                                    <i class="bx bx-calendar"></i>
                                    <span>Holidays</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/attendance/index.php" class="waves-effect">
                                    <i class="bx bx-calendar"></i>
                                    <span>Attendance</span>
                                </a>
                            </li>
                            <?php
                            if (isset($userProfile['role']) && ($userProfile['role'] == 'hr' || $userProfile['role'] == 'admin')) {
                            ?>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="bx bx-stats"></i>
                                        <span>Expenses</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="<?php echo BASE_URL; ?>/expense-categories//index.php">Expense Categories</a></li>
                                        <li><a href="<?php echo BASE_URL; ?>/expenses/">Expenses</a></li>
                                    </ul>
                                </li>
                            <?php
                            }
                            ?>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/leaves/index.php" class="waves-effect">
                                    <i class="mdi mdi-login"></i>
                                    <span>leaves</span>
                                </a>
                            </li>
                            <li class="menu-title">Administrator</li>

                            <li>
                                <a href="<?php echo BASE_URL; ?>/policy/index.php" class="waves-effect">
                                    <i class="bx bx-note"></i>
                                    <span>Policies</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bxs-report"></i>
                                    <span>Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="<?php echo BASE_URL; ?>/reports/expense-report.php">Expense Report</a></li>
                                    <li><a href="#">Invoice Report</a></li>
                                    <li><a href="#">Project Report</a></li>
                                    <li><a href="#">Employee Report</a></li>
                                    <li><a href="<?php echo BASE_URL; ?>/reports/attendance-report.php">Attendance Report</a></li>
                                    <li><a href="<?php echo BASE_URL; ?>/reports/leaves-report.php">Leave Report</a></li>
                                    <li><a href="#">Daily Report</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="waves-effect">
                                    <i class="bx bx-cog"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">