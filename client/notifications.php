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

 $email = $row['userEmail'];

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
                <h4 style="padding-left:10px;">Notifications
                  <button class="pull-right btn btn-info btn-sm" onclick="printContent('printData')" style="margin-top:-6px;margin-right:5px;"> <i class="fa fa-print"></i> Print</button>
                </h4>
              </div>

            <div class="panel panel-default" style="margin-right:10px;margin-top:10px;">
              <div class="panel panel-body" style="min-height:400px;" id='printData'>
                <?php
                $yes = "Yes";
                $nop = "No";
                $res = $conn->query("SELECT * FROM tbl_applicants WHERE userEmail='$email' AND textMssg!='N' ORDER BY id DESC");
                 while($RowUser=$res->fetch_array()){
                   ?>
                   <?php
                    $thePost = $RowUser['postId'];
                    $response = $conn->query("SELECT * FROM tbl_posts WHERE id='$thePost'");
                    $RowPost=$response->fetch_array();
                    if($RowUser['status']==$yes){
                    ?>
                    <div class="well" style="background-color:#dbecdb;">
                    <h3 style="margin-top:5px;">Accepted!</h3>
                    <hr>
                    <b><?php echo $RowPost['position'];?></b>
                    <span class="pull-right text-muted"><?php echo $RowUser['postTime'];?></span>
                    <p><?php echo $RowUser['textMssg'] ?></p>
                    <i>by <?php echo $RowUser['companyName'];?></i><br><!--
                    <span class="fa fa-check" style="color:green">Accepted</span>
                    <span class="fa fa-times" style="">Declined</span><br>-->
                  </div>
                    <?php
                    }else if($RowUser['status']==$nop){
                    ?>
                    <div class="well" style="background-color:#e3d3d3;">
                    <h3 style="margin-top:5px;">Declined</h3>
                    <hr>
                    <b><?php echo $RowPost['position'];?></b>
                    <span class="pull-right text-muted"><?php echo $RowUser['postTime'];?></span>
                    <p><?php echo $RowUser['textMssg'] ?></p>
                    <i>by <?php echo $RowUser['companyName'];?></i><br><!--
                    <span class="fa fa-check" style="">Accepted</span>
                    <span class="fa fa-times" style="color:red">Declined</span><br>-->
                    </div>
                    <?php
                    }
                   ?>
                   <?php }

                   //UPDATE DB THAT YOU HAVE READ THE NOTIFICATIONS
                   $update="UPDATE tbl_applicants SET clientSeen='Y' WHERE userEmail='$email' AND textMssg!='N' AND clientSeen='N'";
                   $conn->query($update);
                   ?>
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
