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
require "hash.php";

$username = $_SESSION['admin_login_session'];
$uname = explode("admin@",$username);
$countUname = $uname[1];

if (isset($_GET['notifyid'])) {
    $notifyid = $_GET['notifyid'];
    $notifyid = decode($notifyid);
    viewedNotification($notifyid, $countUname);
}

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
                        <a class="navbar-brand" href="javascript:void(0)">Exchanges</a>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-chart">
                                <div class="card-header card-header-success">
                                    <h3>Exchanges</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead class="thead-dark">
                                            <th>From</th>
                                            <th>To</th>
                                            <th>We receive</th>
                                            <th>Phone Number</th>
                                            <th>Gateway Address</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                // Pagination Start

                                                include("pagination.php");

                                                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                                                $limit = 10;
                                                $startpoint = ($page * $limit) - $limit;
                                                $statement = "`tbl_exchange_info`";
                                                
                                                // Pagination End

                                                $gwInfodata = array();
                                                $gwInfoquery = "SELECT `exchange_id`, `gateway_sell`, `gateway_recieve`, `amount_sell`, `phone_number`, `gateway_info_address`, `status`, `date` FROM {$statement} ORDER BY `exchange_id` DESC LIMIT {$startpoint} , {$limit}";
                                                $gwInforesult = $dbconnect->query($gwInfoquery);
                                                if ($gwInforesult) {
                                                    while ($gwInforows = $gwInforesult->fetch_array(MYSQLI_ASSOC)) {
                                                        $gwInfodata[] = $gwInforows;
                                                    }
                                                    $gwInforesult->close();
                                                }                                
                                                foreach ($gwInfodata as $gwInfoRow) {
                                                    echo '
                                                        <tr>
                                                            <td>' . $gwInfoRow['gateway_sell'] . '</td>
                                                            <td>' . $gwInfoRow['gateway_recieve'] . '</td>
                                                            <td>' . $gwInfoRow['amount_sell'] . bdtOrUsbByGTName($gwInfoRow['gateway_sell']) . '</td>
                                                            <td>' . $gwInfoRow['phone_number'] . '</td>
                                                            <td>' . $gwInfoRow['gateway_info_address'] . '</td>
                                                            <td>' . getbadgefromStatus($gwInfoRow['status']) . '</td>
                                                            <td>' . getDateFormat($gwInfoRow['date']) . '</td>
                                                            <td><a class="btnn btn-outline-sxc" href="explore.php?exid='.encode($gwInfoRow['exchange_id']).'"><i class="fa fa-pencil"></i></a></td>
                                                        </tr>
                                                    ';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                        // Pagination 
                                        echo "<div id='paging' >";
                                        echo pagination($statement,$limit,$page);
                                        echo "</div>";
                                    ?>
                                </div>
                            </div>
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
<?php


$dt     = new DateTime('now', new DateTimezone('Asia/Dhaka'));
$time   = $dt->format('F j, Y, l g:i a');

if (isset($_POST['UpdateGwaBtn'])) {
    $UpdateGateway  = $_POST['UpdateGateway'];
    $UpdateAddress  = $_POST['UpdateAddress'];
    $sqlQuery       = "UPDATE `tbl_gateway_info` SET `gateway_address`='$UpdateAddress',`username`='$username',`date`='$time' WHERE `gateway_id` = '$UpdateGateway'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    if ($result) {
        echo '<div id="snackbar">Reserve Address Updated.</div>';
        echo "<script>snackbarMessage()</script>";
    } else {
        echo '<div id="snackbar">Failed To Update Reserve Address.</div>';
        echo "<script>snackbarMessage()</script>";
    }
}