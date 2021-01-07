<?php
require 'partials/top-default.php';

//post job
if(isset($_POST['save'])){
     // get values
   	$companyName =  $_POST['companyName'];
   	$companyEmail = $_POST['companyEmail'];
   	$companyPhone = $_POST['companyPhone'];
   	$position =  $_POST['position'];
    $category =  $_POST['category'];
    $location =  $_POST['location'];
   	$detail = $_POST['detail'];
    $startDate = $_POST['startDate'];
    $deadlineDate = $_POST['date'];

    //$today = date('m').'-'.date('d').'-'.date('Y');

    //$today = date('d').'-'.date('m').'-'.date('Y');
    $val = explode('/',$deadlineDate);
    //$value = $val['0'].'-'.$val[1].'-'.$val[2];
    if(date('Y')>$val[2]){//year passed
      $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  Cant enter passed date.
     </div>
     ";
    }else if(date('m')>$val[0] && date('Y')==$val[2]){//this year month passed
      $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  Cant enter passed date.
     </div>
     ";
    }elseif(date('d')>$val[1] && date('m')==$val[0] && date('Y')==$val[2]){//this month this year day passed
      $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  Cant enter passed date.
     </div>
     ";
    }else{
      $SQL = $conn->prepare("INSERT INTO tbl_posts(companyName, companyEmail, companyPhone, position, category, detail, location, startDate, deadlineDate) VALUES(?,?,?,?,?,?,?,?,?)");
      if(!$SQL){
         echo $conn->error;
      } else{
         $SQL->bind_param('sssssssss',$companyName, $companyEmail, $companyPhone, $position, $category,  $detail, $location, $startDate, $deadlineDate);
         if(!$SQL){
           echo $conn->error;
         }else{
           $SQL->execute();
           $msg = "
              <div class='alert alert-success'>
               <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success !</strong>  job posted.
          </div>
          ";
        }
    }
   }
   
}
/* code for data insert */

/* code for data delete */
if(isset($_GET['del'])){
 $SQL = $conn->prepare("DELETE FROM tbl_posts WHERE id=".$_GET['del']);
 $SQL->bind_param("i",$_GET['del']);
 $SQL->execute();
 header("Location: home.php");
}
/* code for data delete */

/* code for data update */
if(isset($_GET['edit'])){
 $SQL = $conn->query("SELECT * FROM tbl_posts WHERE id=".$_GET['edit']);
 $Row = $SQL->fetch_array();
}

//update job details
if(isset($_POST['update'])){
  // get values
 $companyName =  $_POST['companyName'];
 $companyEmail = $_POST['companyEmail'];
 $companyPhone = $_POST['companyPhone'];
 $position =  $_POST['position'];
 $category =  $_POST['category'];
 $detail = $_POST['detail'];
 $location = $_POST['location'];
 $startDate = $_POST['startDate'];
 $deadlineDate = $_POST['date'];

 $SQL = $conn->prepare("UPDATE tbl_posts SET companyName=?, companyEmail=?, companyPhone=?, position=?, category=?, detail=?, location=?, startDate=?, deadlineDate=? WHERE id=?");
 if(!$SQL){
  echo $conn->error;
 } else {
   $SQL->bind_param("sssssssssi",$companyName, $companyEmail, $companyPhone, $position, $category, $detail, $location,  $startDate, $deadlineDate, $_GET['edit']);
   $SQL->execute();
 }
  header("Location: home.php");
}
/* code for data update */


if(isset($_GET['applicants'])){
  $_SESSION['applicants']=$_GET['applicants'];
 header("Location: applicants.php");
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
                <div class="col-MD-12">
                  <div style="background-color:white;width:100;height:40px;border:1px solid #e0e0e0;margin-bottom:10px;">
                    <h4 style="padding-left:10px;">Post Job
                      <button class="pull-right btn btn-info btn-sm" data-toggle="modal" data-target="#jobsModal" style="margin-top:-6px;margin-right:5px;"> <i class="fa fa-briefcase"></i> View Jobs</button>
                    </h4>
                  </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                          <?php
                          if (isset($msg)) {
                            # code...
                            echo $msg;
                          }
                          ?>
                          <form method="post">
                                <div class="form-group">
                                    <label for="companyName">Company Name</label>
                                    <input type="text" name="companyName" placeholder="Company Name." value="<?php  if(isset($_GET['edit'])){echo $Row['companyName'];}   ?>" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label for="companyEmail">Company Email</label>
                                    <input type="text" name="companyEmail" placeholder="Company Email." value="<?php  if(isset($_GET['edit'])){echo $Row['companyEmail'];}   ?>" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label for="companyPhone">Company Phone</label>
                                    <input type="text" name="companyPhone" placeholder="Company Phone." value="<?php  if(isset($_GET['edit'])){echo $Row['companyPhone'];}   ?>" class="form-control" required/>
                                </div>
                              <div class="form-group">
                                  <label for="position">Available Position</label>
                                  <input type="text" name="position" placeholder="Position you are looking for." value="<?php  if(isset($_GET['edit'])){echo $Row['position'];}   ?>" class="form-control" required/>
                              </div>
                              <div class="form-group">
                                  <label for="location"> Location</label>
                                  <input type="text" name="location" placeholder="Location." value="<?php  if(isset($_GET['edit'])){echo $Row['location'];}   ?>" class="form-control" required/>
                              </div>
                              <div class="form-group">
                                <label for="category">Category</label>
                               <select name="category" class="form-control">
                                <option value="Engineering">Engineering</option>
                                <option value="Computing">Computing</option>
                               </select>
                               </div>
                              <div class="form-group">
                                  <label for="detail">Detail</label>
                                  <textarea type="text" name="detail" placeholder="Explain the position" value="<?php  if(isset($_GET['edit'])){echo $Row['detail'];}   ?>" class="form-control"><?php  if(isset($_GET['edit'])){echo $Row['detail'];}   ?></textarea>
                              </div>
                             <div class="form-group">
                                 <div class="row">
                                   <div class="col-md-6">
                                     <label for="deadline">Application Deadline</label><br>
                                     <input type="text" id="date" class="form-control" name="date" placeholder="Deadline" value="<?php  if(isset($_GET['edit'])){echo $Row['deadlineDate'];}   ?>" />
                                   </div>
                                   <div class="col-md-6">
                                     <label for="startDate">Start Date</label><br>
                                     <input type="text" id="date" class="form-control" name="startDate" placeholder="Job Starts" value="<?php  if(isset($_GET['edit'])){echo $Row['startDate'];}   ?>" />
                                   </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <?php if(isset($_GET['edit'])) { ?>
                                  <button type="submit" class="btn btn-primary pull-right" name="update">Update Job</button>
                                  <?php } else { ?>
                                  <button type="submit" class="btn btn-primary pull-right" name="save">Post Job</button>
                                  <?php } ?>
                             </div>

                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->
          </div>
         <!--/#page-wrapper -->
    </div>
    <!-- /#wrapper -->


    <!-- jobs modal -->
    <div class="modal fade" id="jobsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
               <h4>Job Posted</h4>
             </div>
             <div class="modal-body">
               <div class="list-group">
                 <?php
                 $name = $row['userName'];
                 $res = $conn->query("SELECT * FROM tbl_posts ORDER BY id DESC");
                 while($Row=$res->fetch_array())
                 {
                  ?>
                 <span class="list-group-item">
                     <a href="?applicants=<?php echo $Row['id']; ?>"><span class="fa fa-eye fa-fw"></span>View Applicants</a>
                     <i class="pull-right"><a href="?edit=<?php echo $Row['id']; ?>"><span class="fa fa-edit fa-fw"></span>Edit</a>
                     <a href="?del=<?php echo $Row['id']; ?>"><span class="fa fa-trash-o fa-fw"></span>Delete</a>
                     </i>
                     <br>
                     <b><?php echo $Row['position']; ?></b>
                     <p><?php echo $Row['detail']; ?></p>
                     <span class="text-muted">By <?php echo $Row['companyName']; ?></span>
                     <i class="text-muted pull-right">Deadline: <?php echo $Row['deadlineDate'] ?></i>
                     <br>
                 </span>
                 <?php
                 }
                 ?>
               </div>
               <!-- /.list-group -->
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
