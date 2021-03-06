<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        SharpXchange | Admin Panel
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' /> 
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="Shortcut Icon" href="assets/icon/icon.png" type="icon"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="assets/css/material-dashboard.min.css"/> 
    <link rel="stylesheet" href="assets/css/sxcadmin.css"/>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/sxcdashboard.js"></script>
    <script src="assets/js/sxcadmin.js"></script>
</head>
<?php

session_start();
require "adminsqlhelper.php";
require "dbconnect.php";
require "auth.php";
require "xsrf.php";
require "hash.php";

$username = $_SESSION['admin_login_session'];
$uname = explode("admin@",$username);
$countUname = $uname[1];


$tstmonid = $_GET['tstid'];
if (!empty($tstmonid)) {
    $tstmonid = decode($tstmonid);
    $sqlQuery = "SELECT `username`, `testimonial_text`, `view`, `status`, `date` FROM `tbl_user_testimonials` WHERE `testimonial_id` = '$tstmonid'";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    $rows       = mysqli_fetch_array($result);
    $username   = $rows['username'];
    $tstmn_txt  = $rows['testimonial_text'];
    $view       = $rows['view'];
    $status     = $rows['status'];
    $date       = $rows['date'];
} else {
    echo "<script>javascript:document.location='error.html'</script>";
}
if (empty($username) || empty($tstmn_txt) || empty($status)) {
    echo "<script>javascript:document.location='error.html'</script>";
}

if (isset($_POST['updateTstmnBtn'])) {

    $status     = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);
    $viewTstmn  = $_POST['updateTstmnView'];
    
    if (!$status) {
        echo '<div id="snackbar">CSRF FAILED!</div>';
        echo "<script>snackbarMessage()</script>";
    } else {
        if ($viewTstmn == 1 || $viewTstmn == 2) {
            $sqlQueryView   = "UPDATE `tbl_user_testimonials` SET `view`='$viewTstmn' WHERE `testimonial_id` = '$tstmonid'";
            $resultView     = mysqli_query($dbconnect, $sqlQueryView);
            if ($resultView) {
                echo '<div id="snackbar">View Status Updated.</div>';
                echo "<script>snackbarMessage()</script>";
            } else {
                echo '<div id="snackbar">Failed To Update View Status.</div>';
                echo "<script>snackbarMessage()</script>";
            }
        } else {
            echo "<script>javascript:document.location='error.html'</script>";
        }
    }
}

function forEmptyDate($value){
    $data = $value;
    if ($data) {
        $data = getDateFormat($data);
    } else {
        $data = "NA";
    }
    return $data;
}
generateSessionToken();
?>
<body class="dark-edition">
    <div class="wrapper ">
        <div class="sidebar" data-color="orange" data-background-color="black">
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <h3 class="sidebar-title">Exchanger management</h3>
                    <li class="nav-item ">
                        <a class="nav-link" href="gateway.php">
                            <i class="menu-icon fa fa-credit-card"></i>
                            <p>Gateway info</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="exchanges.php">
                            <i class="menu-icon fa fa-refresh"></i>
                            <p>Exchanges</p>
                        </a>
                    </li>
                    <h3 class="sidebar-title">Exchanger management</h3>
                    <li class="nav-item ">
                        <a class="nav-link" href="users.php">
                            <i class="menu-icon fa fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="testimonials.php">
                            <i class="menu-icon fa fa-comments-o"></i>
                            <p>Testimonials</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="contactus.php">
                            <i class="menu-icon fa fa-volume-control-phone"></i>
                            <p>Contact Us</p>
                        </a>
                    </li>
                    <h3 class="sidebar-title">Web management</h3>
                    <li class="nav-item ">
                        <a class="nav-link" href="pages.php">
                            <i class="menu-icon fa fa-bars"></i>
                            <p>Pages</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="settings.php">
                            <i class="menu-icon fa fa-cogs"></i>    
                            <p>Settings</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:void(0)">Testimonial</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:void(0)" id="adminNotificationNav" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification"><?php echo countNotificationNumber($countUname); ?></span>
                                    <p class="d-lg-none d-md-block">
                                        Notification
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminNotificationNav">
                                    <?php
                                        $adminName = "`notify_" . $countUname . "`";
                                        $notificationdata = array();
                                        $notificationquery = "SELECT `notify_id`, `notify_text`, `notify_url` FROM `tbl_admin_notification` WHERE {$adminName} = 0  ORDER BY `notify_id` DESC LIMIT 10";
                                        $notificationresult = $dbconnect->query($notificationquery);
                                        if ($notificationresult) {
                                            while ($notificationrows = $notificationresult->fetch_array(MYSQLI_ASSOC)) {
                                                $notificationdata[] = $notificationrows;
                                            }
                                            $notificationresult->close();
                                        }                                
                                        foreach ($notificationdata as $notificationRow) {
                                            echo '
                                                <a class="dropdown-item" href="' .$notificationRow['notify_url']. '?notifyid=' . encode($notificationRow['notify_id']) . '">' .$notificationRow['notify_text']. '</a>
                                            ';
                                        }
                                    ?>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:void(0)" id="adminnav" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account details
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminnav">
                                    <a class="dropdown-item">Hello <?php echo ucfirst($countUname); ?></a>
                                    <a class="dropdown-item" href="adminsettings.php">Account settings</a>
                                    <a class="dropdown-item" href="logout.php">logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h3>Testimonial</h3>
                        </div>
                        <div class="card-header">
                            <strong>Date : <?php echo forEmptyDate($date); ?></strong>
                            <strong>View : <?php echo getTstnoBdgeFromview($view); ?></strong>
                            <span class="float-right"> <strong>Status : </strong> <?php echo getTstnoBdgeFromSts($status); ?></span>
                            <span class="float-right mr-2"><b>|</b></span>
                            <span class="float-right mr-2"> <strong>Username : <?php echo $username; ?></strong></span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-8 row justify-content-center text-justify ml-1">
                                    <h4><b>Feedback : </b><?php echo $tstmn_txt; ?></h4> 
                                </div>
                                <div class="col-md-4 col-sm-5 ml-auto">
                                    <form method="post">
                                        <div class="form-group">
                                            <label><b>View Testimonial</b></label>
                                            <select class="form-control quickUpdate" name="updateTstmnView">
                                                <option value="1">Show</option>
                                                <option value="2" selected>Hide</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                                            <button type="submit" class="btn btn-primary" name="updateTstmnBtn"><i class="fa fa-check"></i> Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <p id="error"></p>
                            <p id="success"></p>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright" id="date">, SharpXchange</div>
                </div>
            </footer>
            <script>
                const x = new Date().getFullYear();
                let date = document.getElementById('date');
                date.innerHTML = '&copy; ' + x + date.innerHTML;
            </script>
        </div>
    </div>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap-material-design.min.js"></script>
    <script src="https://unpkg.com/default-passive-events"></script>
    <script src="assets/js/perfect-scrollbar.jquery.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/material-dashboard.js?v=2.1.0"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
</body>
</html>