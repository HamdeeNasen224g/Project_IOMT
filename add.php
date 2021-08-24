<?php include 'db_con.php'; ?>
<?php include 'head.html'; ?>
<?php include 'header.html'; ?>

<form class="form-horizontal" method="post" action="add_db.php">

    <div class="form-group">
    
      <label class="control-label col-sm-2" for="ID">Disease ID:</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" id="ID" placeholder="Enter Disease ID" name="ID" >
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Disease name:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="name" placeholder="Enter Disease name" name="name" >
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="icd">ICD-10:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="icd" placeholder="Enter Disease ICD-10" name="icd" >
      </div>
    </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="tdid">Type:</label>
      <div class="col-sm-10">          
        <select class="form-control" id="tdid" name="tdid">
        <option value="">Select type of disease</option>
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
      <button type="submit" class="btn btn-info">Submit</button>
        
      </div>
    </div>
  </form>

<?php include 'footer.html'; ?>
<?php include 'db_close.php'; ?>
