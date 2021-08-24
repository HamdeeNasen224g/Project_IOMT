<?php include 'db_con.php'; ?>
<?php include 'head.html'; ?>
<?php include 'header.html'; ?>
<?php $DID = $_GET["stdid"]; 

$sql = "SELECT * FROM disease WHERE diseaseID LIKE $DID ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
     //  echo "<br> id: ". $row["diseaseID"]. " - Name: ". $row["name"]. " " . $row["icd10"] . " " . $row["TDID"] . "<br>";
      $name =$row["name"];
      $icd =$row["icd10"];
      $tdid = $row["TDID"];
     
  }
} else {
  echo "0 results";
}

?>

<form class="form-horizontal" method="post" action="edit_db.php">

    <div class="form-group">
    <input type="hidden" name="stdid" value="<?php echo $DID ; ?>">
      <label class="control-label col-sm-2" for="ID">Disease ID:</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="ID" placeholder="Enter Disease ID" name="ID" value="<?php echo $DID ; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="Dname">Disease name:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="Dname" placeholder="Enter Disease name" name="Dname" value="<?php echo $name;?>">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="icd">ICD-10:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="icd" placeholder="Enter Disease ICD-10" name="icd" value="<?php echo $icd;?>">
      </div>
    </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="tdid">Type:</label>
      <div class="col-sm-10">          
        <select class="form-control" id="tdid" name="tdid">
        <option value="<?php echo $tdid;?>"><?php 
            $sql = "SELECT * FROM typedisease WHERE TDID LIKE $tdid";
            $result = $conn->query($sql);
           // var_dump($sql);
                       if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) {
                  
                    echo "<br>".$row["name"]."<br>";
                }
            }
        ?></option>
        <?php 
            $sql = "SELECT * FROM typedisease";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row["TDID"].'">'.$row["name"].'</option>';
                }
            }
        ?>
        </select>
      </div>
    </div>


    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-info" id="<?php echo $studentID?>">Submit</button>
       
      </div>
    </div>
  </form>

<?php include 'footer.html'; ?>
<?php include 'db_close.php'; ?>