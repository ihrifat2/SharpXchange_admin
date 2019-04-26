<?php

$dailySell = array();

date_default_timezone_set("Asia/Dhaka");
$day1 = date("F j, Y, l g:i a");

$d = strtotime("-1 day");
$day2 = date("F j, Y, l g:i a", $d);

$d = strtotime("-2 day");
$day3 = date("F j, Y, l g:i a", $d);

$d = strtotime("-3 day");
$day4 = date("F j, Y, l g:i a", $d);

$d = strtotime("-4 day");
$day5 = date("F j, Y, l g:i a", $d);

$d = strtotime("-5 day");
$day6 = date("F j, Y, l g:i a", $d);

$d = strtotime("-6 day");
$day7 = date("F j, Y, l g:i a", $d);

function getSqlDateFormat($data){
    $date = trim($data);
    $date = explode(",",$date);
    $date = $date[0] . $date[1];
    $date = explode(" ",$date);
    $date =  $date[0] . " " . $date[1] . ", " . $date[2] . "%";
    return $date;
}

function getTotalExchangeNumber($date){
	require "dbconnect.php";
	$day 		= getSqlDateFormat($date);
	$sqlQuery 	= "SELECT COUNT(`exchange_id`) FROM `tbl_exchange_info` WHERE `create` LIKE '$day'";
	$result 	= mysqli_query($dbconnect, $sqlQuery);
	$rows 		= mysqli_fetch_array($result);
	$data 		= $rows['COUNT(`exchange_id`)'];
	return $data;
}

$dailySell[] = (int)getTotalExchangeNumber($day1);
$dailySell[] = (int)getTotalExchangeNumber($day2);
$dailySell[] = (int)getTotalExchangeNumber($day3);
$dailySell[] = (int)getTotalExchangeNumber($day4);
$dailySell[] = (int)getTotalExchangeNumber($day5);
$dailySell[] = (int)getTotalExchangeNumber($day6);
$dailySell[] = (int)getTotalExchangeNumber($day7);

function getWeak($data){
    $date = trim($data);
    $date = explode(",",$date);
    $date = $date[2];
    $date = trim($date);
    $date = explode(" ",$date);
    $date = $date[0];
    return $date;
}

function getCompleteTask($date){
	require "dbconnect.php";
	$day 		= getSqlDateFormat($date);
	$sqlQuery 	= "SELECT COUNT(`exchange_id`) FROM `tbl_exchange_info` WHERE `up_date` LIKE '$day' AND `status` = 3";
	$result 	= mysqli_query($dbconnect, $sqlQuery);
	$rows 		= mysqli_fetch_array($result);
	$data 		= $rows['COUNT(`exchange_id`)'];
	return $data;
}

$cTWeaklyEx = array();
$cTWeakName = array();

$cTWeaklyEx[] = (int)getCompleteTask($day1);
$cTWeaklyEx[] = (int)getCompleteTask($day2);
$cTWeaklyEx[] = (int)getCompleteTask($day3);
$cTWeaklyEx[] = (int)getCompleteTask($day4);
$cTWeaklyEx[] = (int)getCompleteTask($day5);
$cTWeaklyEx[] = (int)getCompleteTask($day6);
$cTWeaklyEx[] = (int)getCompleteTask($day7);

$cTWeakName[] = getWeak($day1);
$cTWeakName[] = getWeak($day2);
$cTWeakName[] = getWeak($day3);
$cTWeakName[] = getWeak($day4);
$cTWeakName[] = getWeak($day5);
$cTWeakName[] = getWeak($day6);
$cTWeakName[] = getWeak($day7);

for ($i=0; $i < count($cTWeakName); $i++) { 
	if ($cTWeakName[$i] == "Saturday") {
		$cTWeakName[$i] = "S";
	} elseif ($cTWeakName[$i] == "Sunday") {
		$cTWeakName[$i] = "S";
	} elseif ($cTWeakName[$i] == "Monday") {
		$cTWeakName[$i] = "M";
	} elseif ($cTWeakName[$i] == "Tuesday") {
		$cTWeakName[$i] = "T";
	} elseif ($cTWeakName[$i] == "Wednesday") {
		$cTWeakName[$i] = "W";
	} elseif ($cTWeakName[$i] == "Thursday") {
		$cTWeakName[$i] = "T";
	} elseif ($cTWeakName[$i] == "Friday") {
		$cTWeakName[$i] = "F";
	} else {
		$cTWeakName[$i] = "LOL";
	}
}

?>