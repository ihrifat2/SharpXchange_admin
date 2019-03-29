<?php

if (!isset($_SESSION['admin_login_session'])) {
	header("Location: sign_in.php");
    // echo "<script>javascript:document.location='sign_in.php'</script>";
}

?>