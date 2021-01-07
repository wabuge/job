<?php
require 'partials/top-default.php';

//edit profile
/* code for data insert */
if(isset($_POST['editprofile'])) {
     // get values
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPhone =  $_POST['userPhone'];
    $about =  $_POST['about'];

      if(isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === UPLOAD_ERR_OK){//check if user uploaded a cv
        $sourcePath = $_FILES['uploaded_file']['tmp_name']; // Storing source path of the file in a variable
        $targetPath = "../upload/".$_FILES['uploaded_file']['name']; // Target path where file is to be stored
        $update="UPDATE users SET userName='$userName', userEmail='$userEmail', userPhone='$userPhone', about='$about', cv='$targetPath' WHERE userID='$id'";
        $conn->query($update);
        move_uploaded_file($sourcePath,$targetPath);
      }else {
        $update="UPDATE users SET userName='$userName', userEmail='$userEmail', userPhone='$userPhone', about='$about' WHERE userID='$id'";
        $conn->query($update);
      }
     header("location:editprofile.php");
  }

//to view cv
if(isset($_GET['cv'])){
  $_SESSION['cv'] = $_GET['cv'];
  header("Location: cv.php");
}

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

          <div class="col-md-12" style="min-height:100px;">
            <?php if($row['about']=="") { ?>
              <div class='alert alert-warning'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Hey <?php echo $row['userName']; ?>!</strong>  Add a brief description about yourself.
                <?php if($row['cv']=="") { ?>
                    Upload your cv.
                <?php } ?>
                 This should help in the job application process.
              </div>
            <?php }  else { ?>

              <?php if($row['cv']=="") { ?>
                <div class='alert alert-warning'>
                  <button class='close' data-dismiss='alert'>&times;</button>
                  <strong>Hello <?php echo $row['userName']; ?>!</strong>  Kindly upload your cv
                </div>
              <?php } ?>
            <?php } ?>

            <?php if (isset($_SESSION['applicationredirect'])) {
              if ($_SESSION['applicationredirect']=='active') {
                echo "
                <div class='alert alert-warning'>
                  <button class='close' data-dismiss='alert'>&times;</button>
                   Proceed with application. Click <a href='application.php'>here</a>
                </div>
                ";
               }
              } 
            ?>
          <div style="background-color:white;width:100;height:40px;border:1px solid #e0e0e0;">
            <h4 style="padding-left:10px;">Edit Profile
            </h4>
          </div>
            <div class="panel panel-default" style="margin-top:10px;">
              <div class="panel panel-body">
            <form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="companyName" placeholder="" class="form-control" value="<?php echo $Row['companyName']?>" autofocus required/>
                  <div class="form-group">
                      <label for="userName"> Name</label disable >
                       <input type="text" name="userName" class="form-control" value="<?php echo $row['userName']; ?>" required/>
                  </div>
                  <div class="form-group">
                      <label for="userEmail">Email</label>
                       <input type="text" name="userEmail" value="<?php echo $row['userEmail']; ?>" class="form-control"  d/>
                  </div>
                  <div class="form-group">
                      <label for="userPhone">Phone</label>
                       <input type="text" name="userPhone" value="<?php echo $row['userPhone']; ?>" class="form-control"/>
                  </div>
                  <div class="form-group">
                      <label for="about">About</label>
                       <textarea type="text" name="about" placeholder="Short description About you" value="<?php echo $row['about']; ?>" class="form-control"/><?php echo $row['about']; ?></textarea>
                  </div>
                  <div class="form-group">
                       <label for="uploaded_file">CV [should be a word document]</label>
                       <input type="file" name="uploaded_file" id="uploaded_file"/>
                  </div>
                  <button type="submit" class="btn btn-info btn-block" name="editprofile">Edit</button>
              </form>
            </div>
          </div>
          </div>
            </div>
          </div>
    </div>
    <!-- /#wrapper -->

    <!-- jobs modal -->
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
