<?php

require 'partials/top-default.php';

if(isset($_GET['accept'])){
  $applicantId = $_GET['accept'];

  $res = $conn->query("SELECT * FROM tbl_applicants WHERE id='$applicantId'");
  $Row=$res->fetch_array();

  $cnme = $Row['companyName'];
  $nme = $Row['userName'];
  $eml = $Row['userEmail'];
  $status = "Yes";
  $txt = "Congratulations. You have been shortlisted for a job at $cnme. And you have been booked for interview next week! Please Print your application and visit our main office at Meza Towers.";

  $SQL = $conn->prepare("UPDATE tbl_applicants SET status=?, textMssg=? WHERE id=?");
  //$email = $eml;
  //$message = $txt;
  //$subject = "Invitation for an Interview";
  //$user_home->send_mail($email,$message,$subject);
      //send the message, check for errors
      if (!$SQL){
        $msg = "
          <div class='alert alert-danger'>
           <button class='close' data-dismiss='alert'>&times;</button>
           <strong>Sorry!</strong>  Couldn't send.
            We noticed you are having issues with sending your review to ".$nme.".
             Please try again later or contact us if you need help.
            </div>
          ";
      } else {
        $msg = "
          <div class='alert alert-success'>
           <button class='close' data-dismiss='alert'>&times;</button>
           <strong>Success!</strong>  We've sent an Acceptance message to ".$nme."
            </div>
          ";
          $SQL->bind_param("ssi", $status, $txt, $_GET['accept']);
          $SQL->execute();

    }

}

if(isset($_GET['decline'])){
  $applicantId = $_GET['decline'];

  $res = $conn->query("SELECT * FROM tbl_applicants WHERE id='$applicantId'");
  $Row=$res->fetch_array();

  $cnme = $Row['companyName'];
  $nme = $Row['userName'];
  $eml = $Row['userEmail'];
  $status = "No";
  $txtDecline =  "We are sorry to Inform you that you have not been shortlisted to join $cnme. Please try again next time.";
      //send the message, check for errors
      $SQL = $conn->prepare("UPDATE tbl_applicants SET status=?, textMssg=? WHERE id=?");
  //$email = $eml;
  //$message = $txtDecline;
  //$subject = "Application not Successful";
  //$user_home->send_mail($email,$message,$subject);
      //send the message, check for errors.
      if (!$SQL){
        $msg = "
          <div class='alert alert-danger'>
           <button class='close' data-dismiss='alert'>&times;</button>
           <strong>Sorry!</strong>  Couldn't send.
            We noticed you are having issues with sending your review to ".$nme.".
             Please try again later.
            </div>
          ";
      } else {

          $msg = "
            <div class='alert alert-success'>
             <button class='close' data-dismiss='alert'>&times;</button>
             <strong>Success!</strong>  We've sent a Decline message to ".$nme."
              </div>
            ";

          $SQL->bind_param("ssi", $status, $txtDecline, $_GET['decline']);
          $SQL->execute();
    }
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
                <h4 style="padding-left:10px;">Notifications
                </h4>
              </div>

            <div class="panel panel-default" style="margin-right:10px;margin-top:10px;">
              <div class="panel panel-body" style="min-height:400px;">
                <?php
                $yes = "Yes";
                $nop = "No";
                $res = $conn->query("SELECT * FROM tbl_applicants WHERE textMssg='N' AND adminSeen='N' ORDER BY id DESC");
                 while($RowUser=$res->fetch_array()){
                   ?>
                   <?php
                    $thePost = $RowUser['postId'];
                    $response = $conn->query("SELECT * FROM tbl_posts WHERE id='$thePost'");
                    $RowPost=$response->fetch_array();
                    ?>
                    <div class="well" style="background-color:#dbecdb;">
                      <span class="pull-right text-muted"><?php echo $RowUser['postTime'];?></span>
                      <p><?php echo $RowUser['userName'];?> has applied for a job position (<?php echo $RowPost['position'];?>) at <?php echo $RowUser['companyName']; ?></p>

                      <?php
                      $acc = "Yes";
                      $den = "No";
                       if($RowUser['status']==$acc){
                       ?>
                       <a href="?accept=<?php echo $RowUser['id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-check" style="color:green"></i>Accept</a>
                       <a href="?decline=<?php echo $RowUser['id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-times"></i>Decline</a>
                     <?php }else if($RowUser['status']==$den){ ?>
                        <a href="?accept=<?php echo $RowUser['id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-check"></i>Accept</a>
                        <a href="?decline=<?php echo $RowUser['id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-times" style="color:green"></i>Decline</a>
                       <?php }else{ ?>
                        <a href="?accept=<?php echo $RowUser['id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-check"></i>Accept</a>
                        <a href="?decline=<?php echo $RowUser['id']; ?>" class="btn btn-default btn-sm"><i class="fa fa-times"></i>Decline</a>
                        <?php } ?>

                    </div>
                   <?php }
                   //UPDATE DB THAT YOU HAVE READ THE NOTIFICATIONS
                   $update="UPDATE tbl_applicants SET adminSeen='Y' WHERE textMssg!='N' AND adminSeen='N'";
                   $conn->query($update);
                   ?>
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
