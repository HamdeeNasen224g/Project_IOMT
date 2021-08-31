<?php 
$servername = "projectiot.ck1dneket7id.ap-southeast-1.rds.amazonaws.com";
$username = "dee";
$password = "62112073";
$dbname = "projectiot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
?>
