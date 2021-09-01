<?php 

$arrContextOptions=array(
  "ssl"=>array(
      "verify_peer"=>false,
      "verify_peer_name"=>false,
  ),
); 
//ดึง json จาก ais มา 
$response = file_get_contents("https://api.thingspeak.com/channels/1483314/feeds.json?api_key=0XNU6KDCBYBZVW0U&results=10", false, stream_context_create($arrContextOptions));
$json = json_decode($response);
//เลือกแค่ temp 1&2
$feed = $json->feeds;
$alertdata = array();
$count = 0;
for($i = 0; $i < count($feed); $i++){
if(($feed[$i]->field1 < 60) or ($feed[$i]->field1 > 100) or ($feed[$i]->field2 < 80) or ($feed[$i]->field3 < 34.5) or ($feed[$i]->field1 > 37.5) ){
  $timestamp_in_seconds = strtotime($feed[$i]->created_at);;
  $alertdata[$count][0] = date('D M d Y H:i:s',$timestamp_in_seconds);
  $alertdata[$count][1] = $feed[$i]->field1;
  $alertdata[$count][2] = $feed[$i]->field2;
  $alertdata[$count][3] = $feed[$i]->field3;
  $count =  $count + 1;
}

}
echo $alertdata[0][0];
?>
