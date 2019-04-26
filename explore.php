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
require "xsrf.php";
require "hash.php";

$username = $_SESSION['admin_login_session'];
$uname = explode("admin@",$username);
$countUname = $uname[1];

$exid = $_GET['exid'];
if (!empty($exid)) {
    $exid = decode($exid);
    $sqlQuery = "SELECT `gateway_sell`, `gateway_recieve`, `amount_sell`, `amount_recieve`, `email`, `phone_number`, `gateway_info_address`, `transaction_id`, `additional_info`, `status`, `create` FROM `tbl_exchange_info` WHERE `exchange_id` = '$exid'";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    $rows       = mysqli_fetch_array($result);
    $gt_sell    = $rows['gateway_sell'];
    $gt_rcev    = $rows['gateway_recieve'];
    $amnt_sel   = $rows['amount_sell'];
    $amnt_rce   = $rows['amount_recieve'];
    $email      = $rows['email'];
    $phnNum     = $rows['phone_number'];
    $gtinfoadd  = $rows['gateway_info_address'];
    $tranid     = $rows['transaction_id'];
    $addinfo    = $rows['additional_info'];
    $status     = $rows['status'];
    $date       = $rows['create'];
} else {
    echo "<script>javascript:document.location='error.html'</script>";
}
if (empty($gt_sell) || empty($gt_rcev) || empty($amnt_sel) || empty($amnt_rce)) {
    echo "<script>javascript:document.location='error.html'</script>";
}
if ($addinfo == NULL || $addinfo == "") {
    $addinfo = "N/A";
}

echo "exid : " . $exid;

if (isset($_POST['btn_update'])) {

    $csrfToken     = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);
    $updateStatus = $_POST['status'];

    if (!$csrfToken) {
        echo '<div id="snackbar">CSRF FAILED!</div>';
        echo "<script>snackbarMessage()</script>";
    } else {
        $dt     = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $time   = $dt->format('F j, Y, l g:i a');
        
        if ($updateStatus >= 1 && $updateStatus <= 5) {
            $sqlQueryUpdate = "UPDATE `tbl_exchange_info` SET `status`= '$updateStatus',`up_date`='$time' WHERE `exchange_id` = '$exid'";
            $resultUpdate   = mysqli_query($dbconnect, $sqlQueryUpdate);
            if ($resultUpdate) {
                echo '<div id="snackbar">Exchange info updated.</div>';
                echo "<script>snackbarMessage()</script>";
            } else {
                echo '<div id="snackbar">Failed to updated exchange info.</div>';
                echo "<script>snackbarMessage()</script>";
            }
        } else {
            echo "<script>javascript:document.location='error.html'</script>";
        }
    }
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
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <strong>Create Date : <?php echo $date; ?></strong> 
                            <span class="float-right"> <strong>Status : </strong> <?php echo getbadgefromStatus($status); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-sm-5 col-md-5 row justify-content-center">
                                    <h3 class="mt-4">From : <?php echo $gt_sell; ?></h3>
                                    <div>
                                        <img src="assets/img/<?php echo datanameToPic($gt_sell); ?>" class="img-circle ml-2" id="sxc_imageSendUs" width="72px" height="72px">
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 row justify-content-center">
                                    <h2><i class="fa fa-refresh mt-4"></i></h2>
                                </div>
                                <div class="col-sm-5 col-md-5 row justify-content-center">
                                    <h3 class="mt-4">To : <?php echo $gt_rcev; ?></h3>
                                    <div>
                                        <img src="assets/img/<?php echo datanameToPic($gt_rcev); ?>" class="img-circle ml-2" id="sxc_imageRecieve" width="72px" height="72px">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-4">
                                <div class="col-sm-12 col-md-12 row justify-content-center">
                                    <h4>Exchange ID : <?php echo $tranid; ?></h4> 
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive-sm">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>We Receive</th>
                                            <th>we Send</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Gateway Address</th>
                                            <th>Additional Info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-dark">
                                            <td><?php echo $amnt_sel . bdtOrUsbByGTName($gt_sell); ?></td>
                                            <td><?php echo $amnt_rce . bdtOrUsbByGTName($gt_rcev); ?></td>
                                            <td><?php echo $phnNum; ?></td>
                                            <td><?php echo $email; ?></td>
                                            <td><?php echo $gtinfoadd; ?></td>
                                            <td><?php echo $addinfo; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-5 ml-auto">
                                    <table class="table table-clear">
                                        <tbody>
                                            <form action="" method="POST">
                                                <tr>
                                                    <td class="left">
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select class="form-control quickUpdate" name="status">
                                                                <option value="1" selected="">Processing</option>
                                                                <option value="2">Awaiting Payment</option>
                                                                <option value="3">Processed</option>
                                                                <option value="4">Timeout</option>
                                                                <option value="5">Canceled</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="right">
                                                        <div class="form-group">
                                                            <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" name="btn_update"><i class="fa fa-check"></i> Update</button>
                                                    </td>
                                                </tr>
                                            </form>
                                        </tbody>
                                    </table>
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
    <script src="assets/js/bootstrap-notify.js"></script>
    <script src="assets/js/material-dashboard.js?v=2.1.0"></script>
    <script>
        // $(document).ready(function() { 
        //     md.initDashboardPageCharts();
        // });
    </script>
</body>
</html>