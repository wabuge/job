<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();
if($user_login->is_logged_in()!="")
{
  $stmt = $user_login->runQuery("SELECT * FROM users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row['loginType']=="admin"){
    $user_login->redirect('admin/home.php');
  }else{
    $user_login->redirect('client/home.php');
  }
}

if(isset($_POST['btn-login'])){
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtupass']);

 if($user_login->login($email,$upass)){
  #$user_login->redirect('home.php');
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
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-info">
                    <div class="panel-heading">
                        <h2 style="text-align:center;"> LogIn</h2>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <fieldset>
                              <?php
                              if(isset($_GET['inactive']))
                              {
                               ?>
                                <div class='alert alert-danger'>
                                <button class='close' data-dismiss='alert'>&times;</button>
                                <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it.Click resend email if you didn't recieve an email.
                               </div>
                              <?php
                              }
                              ?>
                              <?php
                                    if(isset($_GET['error']))
                              {
                               ?>
                                <div class='alert alert-danger'>
                                <button class='close' data-dismiss='alert'>&times;</button>
                                <strong>Wrong Details!or Does not exist in our systems</strong>
                               </div>
                              <?php
                              }
                              ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="example@gmail.com" name="txtemail" type="email" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="txtupass" type="password" value="" pattern=".{8,}" title="8 characters minimum" required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block" type="submit" name="btn-login">Login</button></br>

                                Forgot password? <a href="fpass.php">Click Here</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
