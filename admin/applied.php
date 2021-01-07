<?php
require 'partials/top-default.php';

//on clicking a category
if(isset($_GET['category'])){
  $_SESSION['category']=$_GET['category'];
  header("Location: home.php");
}

//check if someone chose a category b4
if(isset($_SESSION['category'])){
  $category = $_SESSION['category'];
}else{
  $category = "All";//get all jobs
}

if(isset($_GET['cv'])){
  $_SESSION['cv'] = $_GET['cv'];
  header("Location: cv.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php require "partials/head.php"; ?>

<body style="background-color:whitesmoke;">
    <div id="wrapper">

      <!-- Navigation -->
      <?php require "partials/navbar.php"; ?>

      <div id="page-wrapper">
            <!-- /.row -->
            <div class="row" style="padding-top: 15px;">
            <div class="col-md-12">

              <div style="background-color:white;width:100;height:40px;border:1px solid #e0e0e0;">
                <h4 style="padding-left:10px;">Applications
                  <button class="pull-right btn btn-info btn-sm" onclick="printContent('printData')" style="margin-top:-6px;margin-right:5px;"> <i class="fa fa-print"></i> Print</button>
                </h4>
              </div>


            <div class="panel panel-default" style="margin-right:10px;margin-top:10px;">
              <div class="panel panel-body" style="min-height:400px;">

                <!-- table here-->
                <div class="table-responsive" id="printData">
                <table class="table table-striped table-bordered table-hover">
                 <thead>
                   <tr>
                      <th colspan="6" class="text-center">Applied Jobs</th>
                   </tr>
                   <tr>
                     <th>User Name</th>
                     <th>Company Name</th>
                     <th>Position</th>
                     <th>Review</th>
                     <th>Date</th>
                     <th>Action</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php
                   $res = $conn->query("SELECT * FROM tbl_applicants ORDER BY id DESC");
                    while($RowUser=$res->fetch_array()){
                      $thePost = $RowUser['postId'];
                      $response = $conn->query("SELECT * FROM tbl_posts WHERE id='$thePost'");
                      $RowPost=$response->fetch_array();
                      ?>
                      <tr>
                        <td><?php echo $RowUser['userName'];?></td>
                        <td><?php echo $RowUser['companyName'];?></td>
                        <td><?php echo $RowPost['position'];?></td>
                        <td><?php echo $RowUser['status'];?></td>
                        <td><?php echo $RowUser['postTime'];?></td>
                        <td><a href="?cv=<?php echo $RowUser['targetPath'];?>">View CV</a></td>
                      </tr>
                  <?php } ?>

                 </tbody>
               </table>
               </div>

                 </div>
               </div>
              </div>
            </div>
          </div>
    </div>
    <!-- /#wrapper -->


  <?php require "partials/footer.php"; ?>
</body>
</html>
