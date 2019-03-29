<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/sxcadmin.css">
    <link rel="Shortcut Icon" href="assets/icon/icon.png" type="icon"/>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/sxcadmin.js"></script>
</head>
<?php

session_start();
require_once 'xsrf.php';
require "dbconnect.php";

if (isset($_SESSION['admin_login_session'])) {
	header("Location: /admin/index.php");
    // echo "<script>javascript:document.location='/admin/sign_in.php'</script>";
}

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnSub'])) {


    // echo "Csrf: " . tokenField() . "<br>";
    // echo "Auth1: " . $_REQUEST[ 'csrf_token' ] . "<br>";
    // echo "Auth2: " . $_SESSION[ 'session_token' ] . "<br>";

    $status     = checkToken( $_REQUEST[ 'csrf_token' ], $_SESSION[ 'session_token' ]);
    $uname 		= validate_input($_POST['uname']);
    $paswd 		= validate_input($_POST['passwd']);

    if (!$status) {
        $msg = "<strong>CSRF FAILED! </strong>";
        echo "<script>document.getElementById('error').innerHTML = '".$msg."';</script>";
    } else {
        if (empty($uname) || empty($paswd)) {
            echo "<script>document.getElementById('error').innerHTML = 'All fields are required';</script>";
        } else {
            $sqlQuery       = "SELECT `admin_passwd` FROM `tbl_admin_info` WHERE `admin_uname` = '$uname'";
            $result         = mysqli_query($dbconnect, $sqlQuery);
            $rows           = mysqli_fetch_array($result);
            $store_password = $rows['admin_passwd'];
            $check          = password_verify($paswd, $store_password);

            if ($check) {
                $_SESSION['admin_login_session'] = $uname;
                echo "<script>javascript:document.location='/index.php'</script>";
            }else{
                echo '<div id="snackbar">Username or Password Invalid.</div>';
                echo "<script>snackbarMessage()</script>";
            }
        }
    }
}
generateSessionToken();
?>
<body>
    <div class="container mt-4">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <input class="form-control" type="text" name="uname" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="passwd" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                    </div>
                    <button class="btn btn-info" type="submit" name="btnSub">submit</button>
                </form>
                <p id="error"></p>
                <p id="success"></p>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>