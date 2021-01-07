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

//proceed to apply
if(isset($_GET['apply'])){
  $_SESSION['apply']=$_GET['apply'];
 header("Location: application.php");
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
                  <strong>Hello <?php echo $row['userName']; ?>!</strong>  Kindly upload your cv.
                </div>
              <?php } ?>
            <?php } ?>
          <div style="background-color:white;width:100;height:40px;border:1px solid #e0e0e0;">
            <h4 style="padding-left:10px;">Available Jobs/ <?php echo $cat; ?></h4>
          </div>
          <br>
          <?php
            $i = 0;
            $b = 0;
            $c = 0;
            if($cat=='All'){
              $res = $conn->query("SELECT * FROM tbl_posts ORDER BY id DESC");
              while($Row=$res->fetch_array()) {
                    $today = date('d').'-'.date('m').'-'.date('Y');
                    $val = explode('/',$Row['deadlineDate']);
                    $value = $val['0'].'-'.$val[1].'-'.$val[2];
                    if(date('Y')>$val[2]){//year passed
                    }else if(date('m')>$val[1] && date('Y')==$val[2]){//this year month passed
                    }elseif(date('d')>$val[0] && date('m')==$val[1] && date('Y')==$val[2]){//this month this year day passed
                    }else{
                      ?>
                      <span class="list-group-item">
                          <span>
                            <b><?php echo $Row['position']; ?></b>
                            <span class="text-muted pull-right"><i class="fa fa-circle" style="color:#d70d0d;"></i> Deadline <?php  echo $Row['deadlineDate']; ?></span>
                            <hr style="max-width:800px;">
                          </span>
                          <p><?php echo $Row['detail']; ?></p>
                          <i>by <?php echo $Row['companyName']; ?></i>.
                          <span class="text-muted pull-right">Starting <?php echo $Row['startDate']; ?></span>
                           <hr style="max-width:800px;">
                           <span>
                            
                              <?php
                              //check if user had applied for this job ealier
                              $userEmail = $row['userEmail'];
                              $postId = $Row['id'];
                              $respCheck="SELECT * FROM tbl_applicants WHERE userEmail='$userEmail' AND postId='$postId'";
                              $RowCheck=mysqli_query($conn, $respCheck);
                              if (mysqli_num_rows($RowCheck) > 0) {
                                // if user applied
                                ?>
                                <a href=''  class='btn btn-info btn-block btn-outline'>
                                <i class='fa fa-check-circle fa-fw'></i>Applied
                                </a>
                                <?php
                              }else {
                                // user has not applied
                                ?>
                                <a href='?apply=<?php echo $Row['id']; ?>'  class='btn btn-info btn-block btn-outline'>
                                <i class='fa fa-pencil fa-fw'></i>Apply
                                </a>
                                <?php
                              }
                              ?>
                            
                          </span>
                      </span><br>
                      <?php
                    }
              }
            }else{
              $res = $conn->query("SELECT * FROM tbl_posts WHERE category='$cat' ORDER BY id DESC");
              while($Row=$res->fetch_array()) {
                $today = date('d').'-'.date('m').'-'.date('Y');
                $val = explode('/',$Row['deadlineDate']);
                $value = $val['0'].'-'.$val[1].'-'.$val[2];
                if(date('Y')>$val[2]){//year passed
                }else if(date('m')>$val[1] && date('Y')==$val[2]){//this year month passed
                }elseif(date('d')>$val[0] && date('m')==$val[1] && date('Y')==$val[2]){//this month this year day passed
                }else{
                  ?>
                  <span class="list-group-item">
                      <span>
                        <b><?php echo $Row['position']; ?></b>
                        <span class="text-muted pull-right"><i class="fa fa-circle" style="color:#d70d0d;"></i> Deadline <?php echo $Row['deadlineDate']; ?></span>
                        <hr style="max-width:800px;">
                      </span>
                      <p><?php echo $Row['detail']; ?></p>
                      <i>by <?php echo $Row['companyName']; ?></i>.
                      <span class="text-muted pull-right">Starting <?php echo $Row['startDate']; ?></span>
                       <hr style="max-width:800px;">
                       <span>
                        
                            <?php
                              //check if user had applied for this job ealier
                              $userEmail = $row['userEmail'];
                              $postId = $Row['id'];
                              $respCheck="SELECT * FROM tbl_applicants WHERE userEmail='$userEmail' AND postId='$postId'";
                              $RowCheck=mysqli_query($conn, $respCheck);
                              if (mysqli_num_rows($RowCheck) > 0) {
                                // if user applied
                                ?>
                                <a href=''  class='btn btn-info btn-block btn-outline'>
                                <i class='fa fa-check-circle fa-fw'></i>Applied
                                </a>
                                <?php
                              }else {
                                // user has not applied
                                ?>
                                <a href='?apply=<?php echo $Row['id']; ?>'  class='btn btn-info btn-block btn-outline'>
                                <i class='fa fa-pencil fa-fw'></i>Apply
                                </a>
                                <?php
                              }
                              ?>
                        
                      </span>
                  </span><br>
                  <?php
                }
              }
            }
          ?>
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
