function snackbarMessage() {
	var x = document.getElementById("snackbar");
	x.className = "show";
	setTimeout(function(){
		x.className = x.className.replace("show", "");
	}, 5000);
}

function getExchangeRate() {
    jQuery.ajax({
        url: "check_ajax.php",
        data:'exchangeGw='+$("#exchangeGw").val(),
        type: "POST",
        success:function(data){
        	var exchangeRate = JSON.parse(data);
            $("#rateFrom").val(exchangeRate[0]);
            $("#rateTo").val(exchangeRate[1]);
            // console.log(data);
        },
        error:function (){}
    });
}

function activeStatus() {
    var activeStatus;
    if($("#activeStatus").prop('checked') == true){
        activeStatus = "on";
    } else {
        activeStatus = "off";
    }
    console.log(activeStatus);
    jQuery.ajax({
        url: "check_ajax.php",
        data:'activeStatus='+activeStatus,
        type: "POST",
        success:function(data){
            if (activeStatus == "on") {
                $("#successful").html('<div id="snackbar">website is online.</div>');
                snackbarMessage();
            } else {
                $("#successful").html('<div id="snackbar">website is offline.</div>');
                snackbarMessage();
            }
            // console.log(data);
        },
        error:function (){}
    });
}