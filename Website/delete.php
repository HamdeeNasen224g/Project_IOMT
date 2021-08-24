<?php 
 include 'db_con.php';
$studentID = $_GET["stdid"];

$sql = "delete from disease WHERE diseaseID = '$studentID'";
$conn->query($sql);
header( "location: Table.php" );
        exit(0);
include 'db_close.php';
?>