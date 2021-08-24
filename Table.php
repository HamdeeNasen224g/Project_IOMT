
<?php include 'db_con.php'; ?>
<?php include 'head.html'; ?>
<?php include 'header.html'; ?>

<div class="container">

  <table id="example" class="table table-striped table-bordered" style="width:100%">
  
    <thead class="thead-light">
   
    <tr>
        <th>ID</th>
        <th>Disease</th>
        <th>ICD-10</th>
        <th>Type</th>
        <th><button type="button" class="btn btn-success" id="btn-add" >New</button></th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $sql = "SELECT * FROM disease";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $row['diseaseID']?> </td>
                <td><a href="view.php" target="_blank" id="<?php echo $row['diseaseID'];?>"><?php echo $row['name']?> </a></td>
                <td><?php echo $row['icd10']?></td>

                <?php  ?>
                <td>
                
                  <?php $tdid = $row['TDID'];
            $sql1 = "SELECT * FROM typedisease WHERE TDID LIKE $tdid";
            $result1 = $conn->query($sql1);
           // var_dump($sql);
                       if ($result1->num_rows > 0) {
            // output data of each row
                while($row1 = $result1->fetch_assoc()) {
                  
                    echo "<br>".$row1["name"]."<br>";
                }
            }else {
              echo "0 results";
            }
        ?>
                
              </td>
                <td>
                <button type="button" class="btn btn-primary btn-edit" id="<?php echo $row['diseaseID'];?>"> 
                EDIT</ion-icon>
               </button>
                <button type="button" class="btn btn-danger btn-del" id="<?php echo $row['diseaseID'];?>" >DEL</button>
                </td>
            </tr>
        <?php
      }
    } else {
      echo "0 results";
    }
    ?>
    </tbody>
  </table>
  <script>
    $(document).ready(function(){
        $("#btn-add").click(function(){
            $(location).attr('href', 'add.php');
        });
        $(".btn-edit").click(function(){
            $(location).attr('href', 'edit.php?stdid='+$(this).attr("id"));

        });
        $(".btn-del").click(function(){
            $(location).attr('href', 'delete.php?stdid='+$(this).attr("id"));
        });
        $("a").click(function(){
            $(location).attr('href', 'view.php?stdid='+$(this).attr("id"));
        });
    });
</script>

</div>
 
<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>

<?php include 'footer.html'; ?>
</body>
</html>
 <?php 
$conn->close();
?>