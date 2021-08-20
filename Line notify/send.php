<script type="text/JavaScript">
    <!--
        function timedRefresh(timeoutPeriod) {
	        setTimeout("location.reload(true);",timeoutPeriod);
        }
//   -->
</script>

<body onLoad="JavaScript:timedRefresh(300000);">

<?php



function send_message($tempLayer1, $tempLayer2 ){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Bangkok");

    // เอา token จากที่เรา gen ขึ้นมา
	$sToken = "jVVardbFatiKOW7FSDMPeSR4ChTMmfQAM0G1zPOY4vO";
	$con = "";
	$con2 = "";
	
	
	if($tempLayer1 < 1 ){
		$con = "\n YRiH_SST \n Layer1 : $tempLayer1 C (Low)";
	}else{
	if($tempLayer1 > 8){
		$con = "\n YRiH_SST \n Layer1 : $tempLayer1 C (High)";
	}else{
		$con ="\n YRiH_SST \n Layer1 : $tempLayer1 C (Normal)";
	}
}
	if($tempLayer2 < 1 ){
		$con2 = "\n Layer2 : $tempLayer2 C (Low) ";
	
	}else{
	if($tempLayer2 > 8){
		$con2 = "\n Layer2 : $tempLayer2 C (High) ";
	}else{
		$con2 ="\n YRiH_SST \n  Layer2 : $tempLayer2 C (Normal)";
	}
}	
	
	

	$sMessage = $con."".$con2;

	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec( $chOne ); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne);
	} 
	else { 
		$result_ = json_decode($result, true); 
		echo "status : ".$result_['status']; echo "message : ". $result_['message'];
	} 
	curl_close( $chOne );
} 

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

//ดึง json จาก ais มา 
$response = file_get_contents("https://magellan.ais.co.th/pullmessageapis/api/listen/thing/59740BBAF7C0BEB8891F1896ADF19ACD", false, stream_context_create($arrContextOptions));
$json = json_decode($response);
//เลือกแค่ temp 1&2
$tempEVM = $json->Sensor->temperatureEVM;
$tempLayer2 = $json->Sensor->Temperature1;
$tempLayer1 = $json->Sensor->Temperature2;
$hum = $json->Sensor->humidity;

// echo "temp1: ".$temp1." <br>temp2: ".$temp2;

if(($tempLayer1 < 1 || $tempLayer1 > 8 ) || ($tempLayer2 < 1 || $tempLayer2 > 8)){
	send_message($tempLayer1, $tempLayer2);
}else{
	
// 	echo “<br>d-m-y = ”,date(“d-m-y”);
// echo “<br>d/m/y = ”,date(“d/m/y”);
// echo “<br>l,d M y = ”,date(“l,d M y”);
// echo “<br>เวลา H:i:s = ”,date(“H:i:s”);
// echo “<br>เวลา h: a = ”,date(“h:i a”);
echo "YRiH_SST อุณหภูมิอยู่ในเกณฑ์ปกติ TempLayer1 >> $tempLayer1 , TempLayer2 >> $tempLayer2 เวลา",  date("H:i:s");
}


?>
</body>



