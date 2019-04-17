<?php

require 'pusher/vendor/autoload.php';

$options = array(
    'cluster' => 'ap2',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    'c0d39fd7bd9c14eb2b6a',
    '8c4db4e31baead871afd',
    '764369',
    $options
);

require "adminsqlhelper.php";
if (isset($_POST['exchangeGw'])) {
	$exchangeGw = $_POST['exchangeGw'];
	echo getExchangeRate($exchangeGw);
}

if (isset($_POST['activeStatus'])) {
	$activeStatus = $_POST['activeStatus'];
	if ($activeStatus == "on") {
		$activeStatus = 1;
		$data['message'] = 2;
    	$pusher->trigger('sharpxchange', 'notification', $data);
	} else {
		$activeStatus = 0;
		$data['message'] = 3;
    	$pusher->trigger('sharpxchange', 'notification', $data);
	}
	
	$status = updateActiveStatus($activeStatus);
	echo $status;
}

?>