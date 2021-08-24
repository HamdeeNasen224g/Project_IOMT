<?php 
    include 'db_con.php';
    $ID = $_POST["ID"];
    $name = $_POST["name"];
    $tdid = $_POST["tdid"];
    $icd = $_POST["icd"];
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
        $sql = "INSERT INTO `disease` (`diseaseID`, `name`, `icd10`, `TDID`) VALUES ('".$ID."', '".$name."', '".$icd."', '".$tdid."');";
        echo $sql;
        $num = $conn->query($sql);

        header( "location: Table.php" );
      
        exit(0);
    }else{
        // Error 
        echo "Incorrect data back to try again";
    }
    
    include 'db_close.php'; 
?>