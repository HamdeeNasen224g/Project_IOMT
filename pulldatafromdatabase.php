<?php
    $bloodList = array();
         $sql = "SELECT * from patient p join patient_mass pm on p.hid = pm.hid join blood b on b.blood_id = p.blood_id";
         $resultM = $conn->query($sql);
      
         if ($resultM->num_rows > 0) {
            while($row = $resultM->fetch_assoc()) {
              $bloodList[$row["blood_id"]] = $row["blood_name"]; 
            }
          }      

?>