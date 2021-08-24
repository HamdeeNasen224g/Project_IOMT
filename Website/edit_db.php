<?php 
    include 'db_con.php';
    $stID = $_POST["stdid"];  
    
    $ID = $_POST["ID"];
    $name = $_POST["Dname"];
    $icd = $_POST["icd"];
    $tdid = $_POST["tdid"];
    $check = true;
    if((strlen($ID) <=0 || !is_numeric($ID)) || strlen($ID) > 11){
        $check = false;
    }
    if(strlen($name)<=0 || strlen($name)>45){
        $check = false;
    }
    if(strlen($tdid)<=0 ){
        $check = false;
    }
    if(strlen($icd)<=0 || $studentID > 11){
        $check = false;
    }
    
    if($check == true){
        $query = "UPDATE `disease` SET `name` = '$name', `icd10` = '$icd',`TDID` = '$tdid',`diseaseID` = '$ID' WHERE `disease`.`diseaseID` = '$stID'";
     
        echo $query;
        $num = $conn->query($query);
        
        header( "location: Table.php" );
        exit(0);
    }else{
        // Error 
        echo "Incorrect data back to try again";
        
    }
    
    include 'db_close.php'; 
?>