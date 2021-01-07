<?php
require 'partials/top-default.php';


if(isset($_GET['applicants'])){
  $_SESSION['applicants'] = $_GET['applicants'];
  $id = $_GET['applicants'];
  $res = $conn->query("SELECT * FROM tbl_posts WHERE id='$id'");
  $Row=$res->fetch_array();
  $_SESSION['companyName'] = $Row['companyName'];
 header("Location: applicants.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<?php require "partials/head.php"; ?>

<body>

    <div id="wrapper">

        <?php require "partials/navbar.php"; ?>

        <div id="page-wrapper">
        <!-- /.row -->
            <div class="row" style="padding-top:10px;">
                <div class="col-md-12">

                  <div style="background-color:white;width:100;height:40px;border:1px solid #e0e0e0;">
                    <h4 style="padding-left:10px;">Dashboard
                      <button class="pull-right btn btn-info btn-sm" onclick="printContent('jobs')" style="margin-top:-6px;margin-right:5px;"> <i class="fa fa-print"></i> Print</button>
                    </h4>
                  </div>

                    <div class="panel panel-default" style="margin-top:10px;">
                        <div class="panel-body">

                         <div class="table-responsive" id="jobs">
                           <table class="table table-striped table-bordered table-hover">
                             <thead>
                               <tr>
                                 <th colspan="10" style="text-align:center;">Posted Jobs</th>
                               </tr>
                               <tr>
                                 <th>Company</th>
                                 <th>Email</th>
                                 <th>Phone</th>
                                 <th>Position</th>
                                 <th>Category</th>
                                 <th>Location</th>
                                 <th>Detail</th>
                                 <th>Deadline</th>
                                 <th>Report</th>
                                 <th>Action</th>
                               </tr>
                             </thead>
                             <tbody>

                                 <?php
                                 $res = $conn->query("SELECT * FROM tbl_posts");
                                 while($Row=$res->fetch_array()){
                                   $d = $Row['id'];
                                   $response = $conn->query("SELECT * FROM tbl_applicants WHERE postId='$d'");
                                   $num = $response->num_rows; ?>
                                  <tr>
                                   <td><?php echo $Row['companyName']; ?></td>
                                   <td><?php echo $Row['companyEmail']; ?></td>
                                   <td><?php echo $Row['companyPhone']; ?></td>
                                   <td><?php echo $Row['position']; ?></td>
                                   <td><?php echo $Row['category']; ?></td>
                                   <td><?php echo $Row['location']; ?></td>
                                   <td><?php echo $Row['detail']; ?></td>
                                   <td><?php echo $Row['deadlineDate']; ?></td>
                                   <td><?php echo $Row['startDate']; ?></td>
                                   <td><a href="?applicants=<?php echo $Row['id']; ?>"><?php echo $num; ?> Applicants</a></td>
                                   </tr>
                                   <?php } ?>

                             </tbody>
                           </table>
                         </div>

                        </div>
                    </div>
                </div>
                <!-- /.col-lg-8 -->
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
         </div>
    </div>
    <!-- /#wrapper -->

   <?php require "partials/footer.php"; ?>
</body>
</html>
