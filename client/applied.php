<?php
require 'partials/top-default.php';

//on clicking a category
if(isset($_GET['category'])){
  $_SESSION['category']=$_GET['category'];
  header("Location: home.php");
}

//check if someone chose a category b4
if(isset($_SESSION['category'])){
  $cat = $_SESSION['category'];
}else{
  $cat = "All";//get all jobs
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
                      <th colspan="4" class="text-center">Applied Jobs</th>
                   </tr>
                   <tr>
                     <th>Company Name</th>
                     <th>Position</th>
                     <th>Review</th>
                     <th>Date</th>
                     <th>Action</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php
                   $yes = "Yes";
                   $nop = "No";
                   $email = $row['userEmail'];
                   $res = $conn->query("SELECT * FROM tbl_applicants WHERE userEmail='$email' ORDER BY id DESC");
                    while($RowUser=$res->fetch_array()){
                      $thePost = $RowUser['postId'];
                      $response = $conn->query("SELECT * FROM tbl_posts WHERE id='$thePost'");
                      $RowPost=$response->fetch_array();
                      ?>
                      <tr>
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


    <!-- atachment modal -->
    <div class="modal fade" id="jobsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
               <h4>Job Categories</h4>
             </div>
             <div class="modal-body">
               <?php
               $response = $conn->query("SELECT * FROM tbl_posts");
               $i = 0;
               while($Row=$response->fetch_array()) {
                 $today = date('d').'-'.date('m').'-'.date('Y');
                 $val = explode('/',$Row['deadlineDate']);
                 $value = $val['0'].'-'.$val[1].'-'.$val[2];
                 if(date('Y')>$val[2]){//year passed
                 }else if(date('m')>$val[1] && date('Y')==$val[2]){//this year month passed
                 }elseif(date('d')>$val[0] && date('m')==$val[1] && date('Y')==$val[2]){//this month this year day passed
                 }else{
                   $i++;
                 }
               }
              ?>
               <div><a href="?category=All"><i class="fa fa-book fa-fw"></i> All</a><span class="fa fa-paperclip pull-right"><?php echo $i; ?></span>
               </div>
                 <hr style="max-width:800px;">
                 <?php
                 $response = $conn->query("SELECT * FROM tbl_posts WHERE category='Engineering'");
                 $i = 0;
                 while($Row=$response->fetch_array()) {
                   $today = date('d').'-'.date('m').'-'.date('Y');
                   $val = explode('/',$Row['deadlineDate']);
                   $value = $val['0'].'-'.$val[1].'-'.$val[2];
                   if(date('Y')>$val[2]){//year passed
                   }else if(date('m')>$val[1] && date('Y')==$val[2]){//this year month passed
                   }elseif(date('d')>$val[0] && date('m')==$val[1] && date('Y')==$val[2]){//this month this year day passed
                   }else{
                     $i++;
                   }
                 }
                ?>
                 <div><a href="?category=Engineering"><i class="fa fa-book fa-fw"></i> Engineering</a><span class="fa fa-paperclip pull-right"><?php echo $i; ?></span>
                 </div>
                 <hr style="max-width:800px;">
                 <?php
                 $response = $conn->query("SELECT * FROM tbl_posts WHERE category='Computing'");
                 $i = 0;
                 while($Row=$response->fetch_array()) {
                   $today = date('d').'-'.date('m').'-'.date('Y');
                   $val = explode('/',$Row['deadlineDate']);
                   $value = $val['0'].'-'.$val[1].'-'.$val[2];
                   if(date('Y')>$val[2]){//year passed
                   }else if(date('m')>$val[1] && date('Y')==$val[2]){//this year month passed
                   }elseif(date('d')>$val[0] && date('m')==$val[1] && date('Y')==$val[2]){//this month this year day passed
                   }else{
                     $i++;
                   }
                 }
                ?>
                 <div><a href="?category=Computing"><i class="fa fa-book fa-fw"></i> Computing</a><span class="fa fa-paperclip pull-right"><?php echo $i; ?></span>
                 </div>
                 <hr style="max-width:800px;">
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Cancel</button>
             </div>
        </div>
    </div>
    </div>


  <?php require "partials/footer.php"; ?>
</body>
</html>
