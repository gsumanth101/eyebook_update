<?php
// Start the session
// session_start();

// Include the database connection
use Models\Database;
use Models\Notification;

$conn = Database::getConnection();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login");
    exit;
}

// Get the email from the session
$email = $_SESSION['email'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM students WHERE email = :email");
if (!$stmt) {
    die('Error in preparing statement: ' . $conn->errorInfo()[2]);
}

$stmt->execute(['email' => $email]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user details are found
if ($userData) {
    // User details found, proceed with the rest of the code
    $studentId = $userData['id'];
    $notifications = Notification::getByStudentId($conn, $studentId);
} else {
    echo "Invalid Credentials";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../views/public/vendors/feather/feather.css">
    <link rel="stylesheet" href="../../views/public/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../../views/ublic/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../views/public/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../views/public//vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../../views/public/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../views/public/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../views/public\assets\images\android-chrome-512x512.png" />
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo mr-5" href="#"><img src="../../views/public\assets\images\logo1.png" class="mr-2" alt="logo" height="50">Knowbots</a>
            <a class="navbar-brand brand-logo-mini" href="#"><img src="../../views/public\assets\images\logo1.png" alt="logo"/></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
            </button>

            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="icon-bell mx-0"></i>
                        <span class="count"><?php echo count($notifications); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                        <?php if (!empty($notifications)): ?>
                            <?php foreach ($notifications as $notification): ?>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-info">
                                            <i class="ti-info-alt mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal"><?php echo htmlspecialchars($notification['message']); ?></h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            <?php echo htmlspecialchars($notification['created_at']); ?>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">No notifications</h6>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="#" id="#">
                        <img src="../../views/public\images\user.jpg" alt="profile"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="profile">
                            <i class="ti-user text-primary"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="logout">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
            <div id="settings-trigger" onclick="openChatbot()"><i class="ti-user"></i></div>
            <div id="theme-settings" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <p class="settings-heading">SIDEBAR SKINS</p>
                <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                    <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                </div>
                <div class="sidebar-bg-options" id="sidebar-dark-theme">
                    <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                </div>
                <p class="settings-heading mt-2">HEADER SKINS</p>
                <div class="color-tiles mx-0 px-4">
                    <div class="tiles success"></div>
                    <div class="tiles warning"></div>
                    <div class="tiles danger"></div>
                    <div class="tiles info"></div>
                    <div class="tiles dark"></div>
                    <div class="tiles default"></div>
                </div>
            </div>
        </div>
        
        <script>
        function openChatbot() {
            window.location.href = '/student/askguru';
        }
        </script>

        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/student/dashboard">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item"><hr></li>

                <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#faculty" aria-expanded="false" aria-controls="faculty">
                        <i class="icon-layout menu-icon"></i>
                        <span class="menu-title">Faculty</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="faculty">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="#">Upload Faculty</a></li>
                            <li class="nav-item"> <a class="nav-link" href="add_faculty">Add Faculty</a></li>
                           <li class="nav-item"> <a class="nav-link" href="#">Manage Faculty</a></li>
                        </ul>
                    </div>
                </li> -->


                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#courses" aria-expanded="false" aria-controls="courses">
                        <i class="icon-columns menu-icon"></i>
                        <span class="menu-title" >Courses</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="courses">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="/student/my_courses">My Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="/student/virtual_classroom">Virtual Classroom</a></li>
                            <li class="nav-item"><a class="nav-link" href="/student/manage_assignments">Assignments</a></li>
                            <!-- <li class="nav-item"><a class="nav-link" href="#">Meetings</a></li>  -->
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#discussion" aria-expanded="false" aria-controls="discussion">
                        <i class="icon-bar-graph menu-icon"></i>
                        <span class="menu-title" >Discussion</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="discussion">
                        <ul class="nav flex-column sub-menu">
                        <!-- <li class="nav-item"> <a class="nav-link" href="upload_students">Upload Students</a></li> -->
                            <li class="nav-item"> <a class="nav-link" href="discussion_forum">Discussion Forum</a></li>
                        </ul>
                    </div>
                </li>
                
                <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#a" aria-expanded="false" aria-controls="student">
                        <i class="icon-bar-graph menu-icon"></i>
                        <span class="menu-title" >Student</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="student">
                        <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="upload_students">Upload Students</a></li>
                            <li class="nav-item"> <a class="nav-link" href="#">Manage Student</a></li>
                        </ul>
                    </div>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#streams" aria-expanded="false" aria-controls="streams">
                        <i class="icon-grid-2 menu-icon"></i>
                        <span class="menu-title">Streams</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="streams">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="streams_team">Manage Streams</a></li>
                        </ul>
                    </div>
                </li> -->


                <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                        <i class="icon-contract menu-icon"></i>
                        <span class="menu-title">Icons</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="icons">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="icon-head menu-icon"></i>
                        <span class="menu-title">User Pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
                        <i class="icon-ban menu-icon"></i>
                        <span class="menu-title">Error pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="error">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/documentation/documentation.html">
                        <i class="icon-paper menu-icon"></i>
                        <span class="menu-title">Documentation</span>
                    </a>
                </li> -->


                <li class="nav-item"><hr></li>
                <li class="nav-item">
                    <a class="nav-link" href="/student/profile">
                        <i class="ti-user menu-icon"></i>
                        <span class="menu-title">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/student/updatePassword">
                        <i class="ti-settings menu-icon"></i>
                        <span class="menu-title">Change Password</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/student/logout">
                        <i class="ti-power-off menu-icon"></i>
                        <span class="menu-title">Logout</span>
                </a>
            </li>
            </ul>

        </nav>
        <!-- partial -->