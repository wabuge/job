<?php
require 'partials/top-default.php';

$apply = $_SESSION['apply'];

  if($row['cv']!="N"){ //if applicant has cv uploaded
      /* code for data insert */
      $_SESSION['applicationredirect'] = "notactive";
      if(isset($_POST['save'])) {
       // get values
      $companyName =  $_POST['companyName'];
      $userName = $_POST['userName'];
      $userEmail = $_POST['userEmail'];
      $userPhone =  $_POST['userPhone'];
      $about =  $_POST['about'];
      $postId =  $_POST['postId'];
      $targetPath = $row['cv'];

          $SQl = $conn->prepare("INSERT INTO tbl_applicants(companyName, userName, userEmail, userPhone, about, postId, targetPath) VALUES(?,?,?,?,?,?,?)");
          if(!$SQl) {
           echo $conn->error;
           $msg = "
             <div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Sorry!</strong>  Couldnt send application.
               </div>
             ";
         } else {
           $SQl->bind_param('sssssss',$companyName, $userName, $userEmail, $userPhone, $about, $postId, $targetPath);
           $SQl->execute();

           $msg = "
             <div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>  Your application is being reviewed
               </div>
             ";

         }

       header("refresh:5;home.php");
      }
 }else if($row['cv']=="N"){ //if applicant has no cv uploaded

   $_SESSION['applicationredirect'] = "active";

   $msg = "
     <div class='alert alert-danger'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry!</strong>  You have to upload a cv to apply for a job.<br>
      Add cv <a href='editprofile.php'>here</a>
       </div>
     ";
  }

    //on clicking a category
    if(isset($_GET['category'])){
      $_SESSION['category']=$_GET['category'];
      header("Location: home.php");
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
            <div class="row" style="padding-top:10px;">
              <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                      <?php
                      if(isset($msg)){
                        echo $msg;
                      }
                      $res = $conn->query("SELECT * FROM tbl_posts WHERE id='$apply'");
                      $Row=$res->fetch_array();
                      ?>
                      <b><?php echo $Row['position']; ?></b>
                      <i class="pull-right">by <?php echo $Row['companyName']; ?></i>
                      <hr style="width:100%;">

                          <?php if($row['cv']!=="N"){  ?>
                            <form method="post" enctype="multipart/form-data">
                                  <input type="hidden" name="companyName" placeholder="" class="form-control" value="<?php echo $Row['companyName']?>" autofocus required/>
                                  <div class="form-group">
                                      <label for="userName"> Name</label>
                                       <input type="text" name="userName" class="form-control" value="<?php echo $row['userName']; ?>" required/>
                                  </div>
                                  <div class="form-group">
                                      <label for="userEmail"> Email</label>
                                       <input type="text" name="userEmail" value="<?php echo $row['userEmail']; ?>" class="form-control"/>
                                  </div>
                                  <div class="form-group">
                                      <label for="userPhone"> Phone</label>
                                       <input type="text" name="userPhone" value="<?php echo $row['userPhone']; ?>" class="form-control"/>
                                  </div>
                                  <div class="form-group">
                                      <label for="about"> About</label>
                                       <textarea type="text" name="about" placeholder="Short description About you" value="<?php echo $row['about']; ?>" class="form-control" required/><?php echo $row['about']; ?></textarea>
                                  </div>
                                <div class="form-group">
                                    <input type="hidden"  name="postId" placeholder="" value="<?php echo $Row['id']; ?>" class="form-control"/>
                                </div>
                                 <button type="submit" class="btn btn-info" name="save">Submit</button>
                              </form>
                          <?php } ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
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
