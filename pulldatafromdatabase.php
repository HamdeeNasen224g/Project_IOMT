<?php
    $bloodList = array();
         $sql = "SELECT * from patient p join patient_mass pm on p.hid = pm.hid join blood b on b.blood_id = p.blood_id";
         $resultM = $conn->query($sql);
      
         if ($resultM->num_rows > 0) {
           while($row = $resultM->fetch_assoc()) {
                $blood_id = $row['blood_id'];
                $blood_name = $row['blood_name'];
                $hid = $row['hid'];
                $p_Fname =  $row['p_Fname'];
                $p_Lname = $row['p_Lname'];
                $dob = $row['dob'];
                $address = $row['address']; 
                $zipcode = $row['p.postalcode'];             
                $weight = $row['weight'];
                $height = $row['height'];
                $timestamp = date('d/m/Y H:i:s', $row['pm.timestamp']);
           
               ?>
                    
                <?php
              }
          }      

?>