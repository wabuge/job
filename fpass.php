<?php
session_start();
require_once 'class.user.php';
$user = new USER();


if(isset($_POST['btn-submit']))
{
 $email = $_POST['txtemail'];

 $stmt = $user->runQuery("SELECT userID FROM users WHERE userEmail=:email LIMIT 1");
 $stmt->execute(array(":email"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 if($stmt->rowCount() == 1)
 {
  $id = base64_encode($row['userID']);
 
  $to = $email;
  $subject = 'OJRP! Reset password';
  $message = "Hello $email,
  We got a request to reset your password.
  Click Following Link To Reset Your Password if you sent the request.
  http://localhost/jobs/resetpass.php?id=$id

  Thanks,";
  //send the message, check for errors
   // send email
         
  if ($user->send_mail($email,$message,$subject)) {
    $msg = "<div class='alert alert-success'>
         <button class='close' data-dismiss='alert'>&times;</button>
         We've sent an email to $email.
                        Please click on the password reset link in the email to generate new password.
          </div>";
  } else {
    $msg = "<div class='alert alert-success'>
         <button class='close' data-dismiss='alert'>&times;</button>
         Couldnt send an email to $email.
          </div>";
  }
 }
 else
 {
  $msg = "<div class='alert alert-danger'>
     <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry!</strong>  this email not found.
       </div>";
 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login|Online Job Recruitment Portal</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body style="background-image: url(assets/img/parallax/1.jpg)">
          <!-- Navigation -->
          <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.php">Online Job Recruitment Portal</a>
              </div>
              <!-- /.navbar-header -->
              <div class="collapse navbar-collapse">
              <ul class="nav navbar-top-links navbar-right">
                <li>
                  <a class="navbar-brand" href="signup.php">Signup</a>
                </li>
              </ul>
            </div>
              <!-- /.navbar-top-links -->
              <!-- /.navbar-static-side -->
          </nav>


    <div class="container">
       <div class='panel panel-default' style='margin-top:50px;'>
        <div class='panel-body'>

          <form class="form-signin" method="post" >
        <h2 class="form-signin-heading" style="color:brown;">Forgot Password</h2><hr />

         <?php
   if(isset($msg))
   {
    echo $msg;
   }
   else
   {
    ?>
    <div class='alert alert-info'>
    Please enter your email address. You will receive a link to create a new password via email!
    </div>
                <?php
   }
   ?>

        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
      <hr />
        <button class="btn btn-info btn-primary" type="submit" name="btn-submit">Generate new Password</button>
      </form>
        </div>
       </div>
      

    </div> <!-- /container -->
    
    <!-- jQuery -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="assets/dist/js/sb-admin-2.js"></script>
  </body>
</html>
