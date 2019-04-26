<?php 
session_start();
if (!isset($_SESSION['badIP'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Block</title>
    <link rel="stylesheet" href="http://asset.sharpxchange.com/assets/css/bootstrap.min.css">
    <script src="http://asset.sharpxchange.com/assets/js/jquery-3.3.1.min.js"></script>
    <script src="http://asset.sharpxchange.com/assets/js/bootstrap.min.js"></script>
    <style type="text/css">
        .error-template {padding: 40px 15px;text-align: center;}
        .error-details {font-family: Courier;}
        .error-actions {margin-top:15px;margin-bottom:15px;}
        .error-actions .btn { margin-right:10px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>Oops!</h1>
                    <h3>Your IP Address is blocked. Please wait 5 minute and don't close this tab</h3>
                    <h2><p id="demo"></p></h2>
                    <div class="error-details">
                        <strong>Error Message : </strong> SharpXchange has blocked your IP address because some suspicious activity recorded from your IP address <?php echo $_SESSION['badIP']; ?> 
                    </div>
                    <div class="error-actions">
                        <img src="http://asset.sharpxchange.com/assets/img/Suspicious-activity.png">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var countDownDate = new Date().getTime()+301000;
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("demo").innerHTML =  minutes + "m " + seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "<font color='red'>EXPIRED</font>";
                location.reload();
                window.location.assign("logout.php")
            }
        }, 1000);
    </script>

</body>
</html>