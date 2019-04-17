<?php

function getTotalUser() {
    require "dbconnect.php";
    $sqlQuery       = "SELECT COUNT(`user_id`) FROM `tbl_user_info`";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $data           = $rows['COUNT(`user_id`)'];
    return $data;
}

function getTotalExchangeNum() {
    require "dbconnect.php";
    $sqlQuery       = "SELECT COUNT(`exchange_id`) FROM `tbl_exchange_info`";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $data           = $rows['COUNT(`exchange_id`)'];
    return $data;
}

function getTotaltstimonl() {
    require "dbconnect.php";
    $sqlQuery       = "SELECT COUNT(`testimonial_id`) FROM `tbl_user_testimonials`";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $data           = $rows['COUNT(`testimonial_id`)'];
    return $data;
}

function getTotalsuscessExchng() {
    require "dbconnect.php";
    $sqlQuery       = "SELECT COUNT(`exchange_id`) FROM `tbl_exchange_info` WHERE `status` = 3";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $data           = $rows['COUNT(`exchange_id`)'];
    return $data;
}

function getExchangeRate($data) {
    require "dbconnect.php";
    $sqlQuery       = "SELECT `we_buy`, `we_sell` FROM `tbl_gateway_info` WHERE `gateway_id` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $we_buy         = $rows['we_buy'];
    $we_sel         = $rows['we_sell'];
    $data           = array($we_buy, $we_sel);
    return json_encode($data);
}

function updateActiveStatus($data) {
    require "dbconnect.php";
    $sqlQuery       = "UPDATE `tbl_additional_info` SET `activeStatus`= '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    if ($result) {
        $data = 1;
    } else {
        $data = 0;
    }
    return $data;
}

function getActiveStatus(){
    require "dbconnect.php";
    $sqlQuery   = "SELECT `activeStatus` FROM `tbl_additional_info`";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    $rows       = mysqli_fetch_array($result);
    $data       = $rows['activeStatus'];
    return $data;
}

function countNotificationNumber($data){
    require "dbconnect.php";
    $uname = "`notify_" . $data . "`";
    $sqlQuery   = "SELECT COUNT(`notify_text`) FROM `tbl_admin_notification` WHERE {$uname} = 0";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    $rows       = mysqli_fetch_array($result);
    $data       = $rows['COUNT(`notify_text`)'];
    return $data;
}

function viewedNotification($notifyId, $username){
    require "dbconnect.php";
    $uname      = "`notify_" . $username . "`";
    $sqlQuery   = "UPDATE `tbl_admin_notification` SET {$uname}='1' WHERE `notify_id` = '$notifyId'";
    $result     = mysqli_query($dbconnect, $sqlQuery);
    if ($result) {
        $data = 1;
    } else {
        $data = 0;
    }
    return $data;
}

function matchPassword($data, $passwd){
    require "dbconnect.php";
    $sqlQuery       = "SELECT `admin_passwd` FROM `tbl_admin_info` WHERE `admin_uname` = '$data'";
    $result         = mysqli_query($dbconnect, $sqlQuery);
    $rows           = mysqli_fetch_array($result);
    $store_passwd   = $rows['admin_passwd'];
    $check          = password_verify($passwd, $store_passwd);
    return $check;
}

function findGateway($data) {
    if ($data >= 1 && $data <= 7) {
        return true;
    } else {
        return false;
    }
}

function bdtOrUsbByGTName($data){
    $currency;
    switch ($data) {
        case "Bkash Personal":
            $currency = " BDT";
            return $currency;
            break;
        case "DBBL Rocket":
            $currency = " BDT";
            return $currency;
            break;
        case "Coinbase":
            $currency = " USD";
            return $currency;
            break;
        case "Ethereum":
            $currency = " USD";
            return $currency;
            break;
        case "Neteller":
            $currency = " USD";
            return $currency;
            break;
        case "Payza":
            $currency = " USD";
            return $currency;
            break;
        case "Skrill":
            $currency = " USD";
            return $currency;
            break;
        default:
            return "Mass with the best die like the rest";
    }
}


function getbadgefromStatus($data) {
    switch ($data) {
        case 1:
            return '<span class="badge badge-info"><i class="fa fa-clock-o"></i> Processing</span>';
            break;
        case 2:
            return '<span class="badge badge-warning"><i class="fa fa-clock-o"></i> Awaiting Payment</span>';
            break;
        case 3:
            return '<span class="badge badge-success"><i class="fa fa-check"></i> Processed</span>';
            break;
        case 4:
            return '<span class="badge badge-danger"><i class="fa fa-times"></i> Timeout</span>';
            break;
        case 5:
            return '<span class="badge badge-danger"><i class="fa fa-times"></i> Canceled</span>';
            break;
        default:
            return "Mass with the best die like the rest";
    }
}

function datanameToPic($data){
    switch ($data) {
        case "Bkash Personal":
            return "bkash.png";
            break;
        case "DBBL Rocket":
            return "dutchbangla.png";
            break;
        case "Coinbase":
            return "coinbase.png";
            break;
        case "Ethereum":
            return "ethereum.png";
            break;
        case "Neteller":
            return "neteller.png";
            break;
        case "Payza":
            return "payza.png";
            break;
        case "Skrill":
            return "skrill.png";
            break;
        default:
            return "Mass with the best die like the rest";
    }
}

function getDateFormat($data){
    $date = trim($data);
    $date = explode(",",$date);
    $date = $date[0] . $date[1];
    $date = explode(" ",$date);
    $month  = getMonth($date[0]);
    $day    = $date[1];
    $year   = $date[2];
    $date = $day . "-" . $month . "-" . $year;
    return $date;
}

function getMonth($value){
    $value = ucfirst($value);
    switch ($value) {
        case "January":
            return "1";
            break;
        case "February":
            return "2";
            break;
        case "March":
            return "3";
            break;
        case "April":
            return "4";
            break;
        case "May":
            return "5";
            break;
        case "June":
            return "6";
            break;
        case "July":
            return "7";
            break;
        case "August":
            return "8";
            break;
        case "September":
            return "9";
            break;
        case "October":
            return "10";
            break;
        case "November":
            return "11";
            break;
        case "December":
            return "12";
            break;
        default:
            return "Mass with the best die like the rest";
    }
}

function getTstnoBdgeFromSts($value){
    if ($value == "Positive") {
        $value = '<span class="badge badge-success"><i class="fa fa-check"></i> Positive</span>';
    } else {
        $value = '<span class="badge badge-danger"><i class="fa fa-times"></i> Negative</span>';
    }
    return $value;
}


function getTstnoBdgeFromview($value){
    if ($value == 1) {
        $value = '<span class="badge badge-success"><i class="fa fa-check"></i>Show</span>';
    } else {
        $value = '<span class="badge badge-danger"><i class="fa fa-times"></i>Hide</span>';
    }
    return $value;
}
?>