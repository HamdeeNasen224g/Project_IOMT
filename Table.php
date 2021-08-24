

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
    $sql = "select * from patient p join patient_mass join data d join blood ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $row['hid']?> </td>
                <?php  ?>
                
                <td>
                <button type="button" class="btn btn-primary btn-edit" id="<?php echo $row['hid'];?>"> 
                EDIT</ion-icon>
               </button>
                <button type="button" class="btn btn-danger btn-del" id="<?php echo $row['hid'];?>" >DEL</button>
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
