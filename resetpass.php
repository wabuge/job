<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id'])){
 $user->redirect('index.php');
}

if(isset($_GET['id']))
{
 $id = base64_decode($_GET['id']);
 
 $stmt = $user->runQuery("SELECT * FROM users WHERE userID=:uid");
 $stmt->execute(array(":uid"=>$id));
 $rows = $stmt->fetch(PDO::FETCH_ASSOC);

 if($stmt->rowCount() == 1)
 {
  if(isset($_POST['btn-reset-pass']))
  {
   $pass = $_POST['pass'];
   $cpass = $_POST['confirm-pass'];

   if($cpass!==$pass)
   {
    $msg = "<div class='alert alert-block'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry!</strong>  Password Doesn't match.
      </div>";
   }
   else
   {
    $cpass = md5($cpass);
    $stmt = $user->runQuery("UPDATE users SET userPass=:upass WHERE userID=:uid");
    $stmt->execute(array(":upass"=>$cpass,":uid"=>$rows['userID']));

    $msg = "<div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      Password Changed.
      </div>";
    header("refresh:5;index.php");
   }
  }
 }
 else
 {
  exit;
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

        <div class='alert alert-success'>
   <strong>Hello!</strong>  <?php echo $rows['userName'] ?> reset your forgotten password.
  </div>
        <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Password Reset.</h3><hr />
        <?php
        if(isset($msg))
  {
   echo $msg;
  }
  ?>
        <input type="password" class="input-block-level" placeholder="New Password" name="pass" minlength="8" required />
        <input type="password" class="input-block-level" placeholder="Confirm New Password" name="confirm-pass" minlength="8" required />
      <hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your Password</button>

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
