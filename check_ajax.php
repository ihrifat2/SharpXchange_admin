<?php

require "adminsqlhelper.php";
if (isset($_POST['exchangeGw'])) {
	$exchangeGw = $_POST['exchangeGw'];
	echo getExchangeRate($exchangeGw);
}

if (isset($_POST['activeStatus'])) {
	$activeStatus = $_POST['activeStatus'];
	if ($activeStatus == "on") {
		$activeStatus = 1;
	} else {
		$activeStatus = 0;
	}
	$status = updateActiveStatus($activeStatus);
	echo $status;
}

?>