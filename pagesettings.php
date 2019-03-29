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
    <script src="http://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
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

if (isset($_GET['pageid'])) {
    $pageid = $_GET['pageid'];
    $pageid = decode($pageid);
    if ($pageid >= 1 && $pageid <= 2) {
        $sqlQuery = "SELECT `title`, `url` FROM `tbl_page_settings` WHERE `page_id` = '$pageid'";
        $result     = mysqli_query($dbconnect, $sqlQuery);
        $rows       = mysqli_fetch_array($result);
        $title      = $rows['title'];
        $url        = $rows['url'];
    } else {
        echo "<script>javascript:document.location='error.html'</script>";
    }
} else {
    echo "<script>javascript:document.location='error.html'</script>";
}

if (isset($_POST['submitBtn'])) {

    $status = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);
    $text   = $_POST['content'];
    $dt     = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $time   = $dt->format('F j, Y, l g:i a');

    if (!$status) {
        echo '<div id="snackbar">CSRF FAILED!</div>';
        echo "<script>snackbarMessage()</script>";
    } else {
        $sqlQueryupdate = "UPDATE `tbl_page_settings` SET `text`='$text',`update_on`='$time' WHERE `page_id` = '$pageid'";
        $resultupdate     = mysqli_query($dbconnect, $sqlQueryupdate);
        if ($resultupdate) {
            echo '<div id="snackbar">Page Updated.</div>';
            echo "<script>snackbarMessage()</script>";
        } else {
            echo '<div id="snackbar">Failed To Updated Page.</div>';
            echo "<script>snackbarMessage()</script>";
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
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-chart">
                                <div class="card-header card-header-success">
                                    <h3><?php  echo "Edit " . ucfirst($title) . " Page"; ?></h3>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="email" class="form-control" id="pageTitle" value="<?php echo ucfirst($title); ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Prefix</span>
                                                    </div>
                                                    <input type="text" class="form-control" value="http://sharpxchange.com/<?php echo $url; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="form-group bmd-form-group mb-4 mt-4">
                                                    <textarea class="form-control mt-2" name="content" id="editor" placeholder="Content"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                                        <button type="submit" class="btn btn-success pull-right" name="submitBtn">Submit</button>
                                        <div class="clearfix"></div>
                                    </form>
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

                //ckEditor
                CKEDITOR.replace( 'editor' );
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