<?php
require 'partials/top-default.php';

$postId = $_SESSION['applicants'];


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

        <?php require "partials/navbar.php"; ?>
            <div id="page-wrapper">
            <!-- /.row -->
            <div class="row" style="padding-top:10px;">
                <div class="col-md-12">
                  <?php
                  if(isset($msg)){ echo $msg; }
                  ?>
                  <div class="row">

                    <div class="col-md-12">
                      <div style="background-color:white;width:100;height:40px;border:1px solid #e0e0e0;margin-bottom:10px;">
                        <h4 style="padding-left:10px;">Report <span class="pull-right fa fa-print" onclick="printContent('applicants')" style="margin-right:10px;color:blue;"></span></h4>

                      </div>
                      <div class="panel panel-default">
                          <div class="panel-body">
                            <div id="applicants" class="col-md-12">
                              <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover">
                               <thead>
                                 <tr>
                                   <?php
                                   $response = $conn->query("SELECT * FROM tbl_posts WHERE id='$postId'");
                                   $Ro=$response->fetch_array();
                                    ?>
                                    <h3 class="text-center"><?php echo $Ro['position'];?></h3>
                                 </tr>
                                 <tr>
                                   <th>Name</th>
                                   <th>Phone</th>
                                   <th>About</th>
                                   <th>Review</th>
                                 </tr>
                               </thead>
                               <tbody>
                                 <?php
                                 $x = 0;
                                 $y = 0;
                                 $z = 0;
                                 $i = 0;

                                 $re = $conn->query("SELECT * FROM tbl_posts WHERE id='$postId'");
                                 $rowpost=$re->fetch_array();
                                 $res = $conn->query("SELECT * FROM tbl_applicants WHERE postId='$postId'");
                                 while($Row=$res->fetch_array()){
                                   $i++;
                                   ?>
                                 <tr>
                                   <td><?php echo $Row['userName']; ?></</td>
                                   <td><?php echo $Row['userPhone']; ?></td>
                                   <td><?php echo $Row['about']; ?></td>
                                   <td><?php
                                   if(empty($Row['status'])){
                                     echo "Pending";
                                     $x++;
                                   }else if($Row['status']=="Yes"){
                                     echo "Accepted";
                                     $y++;
                                   }else if($Row['status']=="No"){
                                     echo "Declined";
                                     $z++;
                                   }  ?></td>
                                 </tr>
                                 <?php } ?>
                               </tbody>
                             </table>
                           </div>
                                 <i class="fa fa-briefcase" style="color:black"></i> Position: <?php echo $rowpost['position']; ?>
                                 <br>
                                 <i class="fa fa-user" style="color:black"></i> Company: <?php echo $rowpost['companyName']; ?>
                                 <br>
                                 <i class="fa fa-clock-o" style="color:green;"></i> Posted on: <?php echo $rowpost['postTime']; ?>
                                 <br>
                                 <i class="fa fa-square" style="color:red;"></i> Deadline: <?php echo $rowpost['deadlineDate']; ?>.
                                 <br>
                                 <i class="fa fa-group" style="color:blue;"></i> Aplicants:
                                 <br>
                                 - Pending: <?php echo $x; ?>/ <?php echo $i; ?>.
                                 <br>
                                 - Accepted: <?php echo $y; ?>/ <?php echo $i; ?>.
                                 <br>
                                 - Declined: <?php echo $z; ?>/ <?php echo $i; ?>.
                            </div>
                          </div>
                          <!-- /.panel-body -->
                      </div>
                      <!-- /.panel -->
                    </div>

                  </div>
                </div>
            </div>
            <!-- /.row -->
          </div>
    </div>
    <!-- /#wrapper -->


    <?php require "partials/footer.php"; ?>
</body>
</html>
