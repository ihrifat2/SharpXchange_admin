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
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <style type="text/css">
        .invisible {
            display: none;
            visibility: hidden;
        }
    </style>
    <script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('c0d39fd7bd9c14eb2b6a', {
        cluster: 'ap2',
        forceTLS: true
    });

    var channel = pusher.subscribe('sharpxchange');
    channel.bind('notification', function(data) {
        // alert(JSON.stringify(data));
        // console.log(data['message']);
        document.getElementById('audio').innerHTML = '<audio controls autoplay><source src="https://asset.sharpxchange.com/assets/audio/tone.mp3" type="audio/mpeg"></audio>';
    });
    </script>

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

$gateway    = 1;
$exchngRt   = getExchangeRate($gateway);
$rateFrom   = $exchngRt[2];
$rateTo     = $exchngRt[6];

$dt     = new DateTime('now', new DateTimezone('Asia/Dhaka'));
$time   = $dt->format('F j, Y, l g:i a');

if (isset($_POST['reserveUpdateBtn'])) {

    $status         = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);
    $reserveGateway = $_POST['reserveUpdateGateway'];
    $reserveAmount  = $_POST['reserveUpdateAmount'];

    if (!$status) {
        echo '<div id="snackbar">CSRF FAILED!</div>';
        echo "<script>snackbarMessage()</script>";
    } else {
        $sqlQueryRU     = "UPDATE `tbl_reserve_list` SET `amount`='$reserveAmount',`username`='$username',`update_date`='$time' WHERE `reserve_id` = '$reserveGateway'";
        $resultRU       = mysqli_query($dbconnect, $sqlQueryRU);
        if ($resultRU) {
            echo '<div id="snackbar">Reserve List Updated.</div>';
            echo "<script>snackbarMessage()</script>";
        } else {
            echo '<div id="snackbar">Failed To Update Reserve List.</div>';
            echo "<script>snackbarMessage()</script>";
        }
    }
}

if (isset($_POST['rateBtn'])) {
    $exchangeGw = $_POST['exchangeGw'];
    $rateBuy    = $_POST['rateFrom'];
    $rateSell   = $_POST['rateTo'];
    $status     = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);

    if (!$status) {
        echo '<div id="snackbar">CSRF FAILED!</div>';
        echo "<script>snackbarMessage()</script>";
    } else {
        // echo $exchangeGw . " : " . $rateBuy . " : " . $rateSell . " : " . $status;
        if (findGateway($exchangeGw)) {
            $sqlQueryRC     = "UPDATE `tbl_gateway_info` SET `username`='$countUname',`we_buy`='$rateBuy',`we_sell`='$rateSell',`date`='$time' WHERE `gateway_id` = '$exchangeGw'";
            $resultRC       = mysqli_query($dbconnect, $sqlQueryRC);
            if ($resultRC) {
                echo '<div id="snackbar">Exchange Rate Updated.</div>';
                echo "<script>snackbarMessage()</script>";
            } else {
                echo '<div id="snackbar">Exchange Rate Failed To Updated.</div>';
                echo "<script>snackbarMessage()</script>";
            }
        } else {
            echo '<div id="snackbar">Gateway Not Found!</div>';
            echo "<script>snackbarMessage()</script>";
        }
    }

}
generateSessionToken();
?>

<body class="dark-edition">
    <div id="audio" class="invisible"></div>
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
                        <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item ml-3">
                                <p class="d-inline activeStatus">Offline/Online</p>
                                <label class="switch">
                                    <?php 
                                    if (getActiveStatus() == 1) {
                                        echo '<input type="checkbox" id="activeStatus" onclick="activeStatus()" checked>';
                                    } else {
                                        echo '<input type="checkbox" id="activeStatus" onclick="activeStatus()">';
                                    }
                                    ?>
                                    <span class="slider round"></span>
                                </label>
                            </li>
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
                    <div class="row">
                        <div class="col-xl-4 col-lg-12">
                            <div class="card card-chart">
                                <div class="card-header card-header-success">
                                    <div class="ct-chart" id="dailySalesChart"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Daily Sales</h4>
                                    <p class="card-category">
                                        <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span>
                                        increase in today sales.
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> updated 4 minutes ago
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12">
                            <div class="card card-chart">
                                <div class="card-header card-header-warning">
                                    <div class="ct-chart" id="websiteViewsChart"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Email Subscriptions</h4>
                                    <p class="card-category">Last Campaign Performance</p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12">
                            <div class="card card-chart">
                                <div class="card-header card-header-danger">
                                    <div class="ct-chart" id="completedTasksChart"></div>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">Completed Tasks</h4>
                                    <p class="card-category">Last Campaign Performance</p>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i> campaign sent 2 days ago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-warning card-header-icon">
                                    <div class="card-icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <p class="card-category">Users</p>
                                    <h3 class="card-title"><?php echo getTotalUser(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-warning">warning</i>
                                        <a href="#pablo" class="warning-link">Get More Space...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="fa fa-refresh"></i>
                                    </div>
                                    <p class="card-category">Exchanges</p>
                                    <h3 class="card-title"><?php echo getTotalExchangeNum(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">date_range</i> last 1 month
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-danger card-header-icon">
                                    <div class="card-icon">
                                        <i class="fa fa-comments-o"></i>
                                    </div>
                                    <p class="card-category">Testimonials</p>
                                    <h3 class="card-title"><?php echo getTotaltstimonl(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">local_offer</i> Please read some
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-info card-header-icon">
                                    <div class="card-icon">
                                        <i class="fa fa-dollar"></i>
                                    </div>
                                    <p class="card-category">Payout</p>
                                    <h3 class="card-title"><?php echo getTotalsuscessExchng(); ?></h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">update</i> Need more
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-danger">
                                    <h4 class="card-title ">New Exchanges</h4>
                                    <p class="card-category">Take a look at here first</p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-danger">
                                                <tr>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>We Receive</th>
                                                    <th>We Send</th>
                                                    <th>info</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php
                                                        $adminExchngdata = array();
                                                        $adminExchngquery = "SELECT `exchange_id`, `gateway_sell`, `gateway_recieve`, `amount_sell`, `amount_recieve`, `gateway_info_address`, `status` FROM `tbl_exchange_info` WHERE `status` = 1  ORDER BY `exchange_id` DESC LIMIT 10";
                                                        $adminExchngresult = $dbconnect->query($adminExchngquery);
                                                        if ($adminExchngresult) {
                                                            while ($adminExchngrows = $adminExchngresult->fetch_array(MYSQLI_ASSOC)) {
                                                                $adminExchngdata[] = $adminExchngrows;
                                                            }
                                                            $adminExchngresult->close();
                                                        }                                
                                                        foreach ($adminExchngdata as $adminExchngRow) {
                                                            echo '
                                                                <tr>
                                                                    <td>' . $adminExchngRow['gateway_sell'] . '</td>
                                                                    <td>' . $adminExchngRow['gateway_recieve'] . '</td>
                                                                    <td>' . $adminExchngRow['amount_sell'] . '</td>
                                                                    <td>' . $adminExchngRow['amount_recieve'] . '</td>
                                                                    <td>' . $adminExchngRow['gateway_info_address'] . '</td>
                                                                    <td>' . $adminExchngRow['status'] . '</td>
                                                                    <td><a class="btn btn-danger" href="explore.php?exid='.$adminExchngRow['exchange_id'].'">explore</a></td>
                                                                </tr>
                                                            ';
                                                        }
                                                    ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-success">
                                    <h4 class="card-title">Quickly update reserve</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating">Gateway</label>
                                                    <select class="form-control md-form mt-2 quickUpdate" name="reserveUpdateGateway">
                                                        <option value="1" selected>Bkash Personal BDT</option>
                                                        <option value="2">DBBL Rocket BDT</option>
                                                        <option value="3">Coinbase USD</option>
                                                        <option value="4">Ethereum USD</option>
                                                        <option value="5">Neteller USD</option>
                                                        <option value="6">Payza USD</option>
                                                        <option value="7">Skrill. USD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating">New reserve</label>
                                                    <input type="text" class="form-control" name="reserveUpdateAmount">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                                        <button type="submit" class="btn btn-success pull-right" name="reserveUpdateBtn">Update</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Quickly update exchange rate</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating">List with exchange rates</label>
                                                    <select class="form-control md-form mt-2 quickUpdate" id="exchangeGw" name="exchangeGw" onchange="getExchangeRate()">
                                                        <option value="1" selected>Bkash Personal BDT</option>
                                                        <option value="2">DBBL Rocket BDT</option>
                                                        <option value="3">Coinbase USD</option>
                                                        <option value="4">Ethereum USD</option>
                                                        <option value="5">Neteller USD</option>
                                                        <option value="6">Payza USD</option>
                                                        <option value="7">Skrill. USD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="bmd-label-floating">New reserve</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rate From</span>
                                                    </div>
                                                    <input type="text" aria-label="Rate From" id="rateFrom" name="rateFrom" class="form-control" value="<?php echo $rateFrom; ?>">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rate To</span>
                                                    </div>
                                                    <input type="text" aria-label="Rate To" id="rateTo" name="rateTo" class="form-control" value="<?php echo $rateTo; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                                        <button type="submit" class="btn btn-primary pull-right" name="rateBtn">Update</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title">Employees Login Status</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-info">
                                            <th>Name</th>
                                            <th>In</th>
                                            <th>out</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Imran</td>
                                                <td>9:00</td>
                                                <td>01:03</td>
                                            </tr>
                                            <tr>
                                                <td>Nur</td>
                                                <td>01:00</td>
                                                <td>5:04</td>
                                            </tr>
                                            <tr>
                                                <td>Robin</td>
                                                <td>5:00</td>
                                                <td>8:02</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright" id="date">, SharpXchange</div>
                    <p id="successful"></p>
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
    <script src="assets/js/sxcdashboard.js"></script>
    <script src="assets/js/sxcadmin.js"></script>
</body>
</html>