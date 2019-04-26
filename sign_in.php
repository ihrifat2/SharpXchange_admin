<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/style.css">
    <link rel="stylesheet" href="https://asset.sharpxchange.com/assets/css/sxcadmin.css">
    <script src="https://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://asset.sharpxchange.com/assets/js/sxcadmin.js"></script>
</head>
<?php

session_start();
require 'xsrf.php';
require "dbconnect.php";
require "helpertwo.php";

if (isset($_SESSION['admin_login_session'])) {
	header("Location: index.php");
}

if (isset($_SESSION['badIP'])) {
    header("HTTP/1.1 401 Unauthorized");
    header("Location: block.php");
    die();
}

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnSub'])) {

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
                unset($_SESSION['failattempts']);
                unset($_SESSION['badIP']);
                $md5uniqid  = md5(uniqid());
                $dt         = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                $time       = $dt->format('F j, Y, l g:i a');
                
                $sqlSession = "INSERT INTO `tbl_admin_sessiontoken`(`session_id`, `session_token`, `session_uname`, `session_create`) VALUES (NULL,'$md5uniqid','$uname','$time')";
                $rstSession = mysqli_query($dbconnect, $sqlSession);
                if ($rstSession) {
                    $_SESSION['admin_login_session'] = $uname;
                    echo "<script>javascript:document.location='index.php'</script>";
                } else {
                    echo '<div id="snackbar">Unexpected Error.</div>';
                    echo "<script>snackbarMessage()</script>";
                }
            }else{
                echo '<div id="snackbar">Username or Password Invalid.</div>';
                echo "<script>snackbarMessage()</script>";
                $ip = get_ip_address();
                if (isset($_SESSION['failattempts'])) {
                    $failattempt = $_SESSION['failattempts'];
                    $failattempt++;
                    $_SESSION['failattempts'] = $failattempt;
                    if ($_SESSION['failattempts'] >= 6) {
                        $error = "Too many request.";
                        header("HTTP/1.1 429 Too Many Requests");
                    }
                    /* Rate limiting user request */
                    if ($_SESSION['failattempts'] >= 10) {
                        $_SESSION['badIP'] = $ip;
                        header("HTTP/1.1 401 Unauthorized");
                    }
                }else{
                    $failattempt = 1;
                    $_SESSION['failattempts'] = $failattempt;
                }
            }
        }
    }
}
generateSessionToken();
?>
<body>
    <div class="container login-panel-row">
        <div class="row justify-content-md-center login-panel-container">
            <div class="col-md-8 login-panel-body">
                <div class="header" style="background-image: url(assets/img/bg-01.jpg);">
                </div>

                <form class="login-panel-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" name="uname" placeholder="Enter username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="passwd" placeholder="Enter password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="hidden" name="csrf_token" value="<?php echo tokenField(); ?>">
                            <button class="btn btn-outline-success" type="submit" name="btnSub">
                                Login
                            </button>
                        </div>
                    </div>
                    <p id="error"></p>
                    <p id="success"></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>