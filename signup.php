<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!=""){
  $stmt = $reg_user->runQuery("SELECT * FROM users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row['loginType']=="admin"){
    $reg_user->redirect('admin/home.php');
  }else {
    $user_login->redirect('client/home.php');
  }
}

if(isset($_POST['btn-signup'])){
 //$uname = trim($_POST['txtuname']);
 $email = trim($_POST['txtemail']);
 $splitemail = explode('@', $email);
 $uname = $splitemail[0];
 $upass = trim($_POST['txtpass']);
 $uphone = trim($_POST['txtphone']);

 if (is_numeric($uphone)) {
   # code...
  if (strlen($uphone)==10) {
    # code...
     $urole = trim($_POST['txtrole']);

 $stmt = $reg_user->runQuery("SELECT * FROM users WHERE userEmail=:email_id");
 $stmt->execute(array(":email_id"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);

 if($stmt->rowCount() > 0) {
  $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  email already exists , Please Try another one
     </div>
     ";
 } else {
  if($reg_user->register($uname,$email,$upass,$uphone,$urole)) {

     $msg = "
       <div class='alert alert-success'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Success!</strong>  Account created successfully. <a href='login.php'>login here</a>
       </div>
       ";

 } else {
   echo "sorry , Query could no execute...";
  }
 }
  }else{
    //error
    $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  Plese enter  valid Phone Number
     </div>
     ";
  }
 }else{
  //error
  $msg = "
        <div class='alert alert-danger'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  Plese enter  valid Phone Number
     </div>
     ";
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

    <title>Signup|Online Job Recruitment Portal</title>
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

          <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.php">Online Jobs Recruitment Portal</a>
              </div>
              <!-- /.navbar-header -->
              <div class="collapse navbar-collapse">
              <ul class="nav navbar-top-links navbar-right">
                <li>
                  <a class="navbar-brand" href="login.php">Login</a>
                </li>
              </ul>
            </div>
              <!-- /.navbar-top-links -->
              <!-- /.navbar-static-side -->
          </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h2 style="text-align:center;">Signup</h2>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <fieldset>
                              <?php if(isset($msg)){ echo $msg; } ?>
                              <div class="form-group">
                                  <input type="email" class="form-control" id="email" placeholder="example@gmail.com" name="txtemail" type="email" required>
                              </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control"  id="tel" placeholder="Phone number" name="txtphone" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="txtpass" type="password" value="" minlength="8" required>
                                </div>
                                <input type="hidden" name="txtrole" value="user" required>
                                <button class="btn btn-lg btn-success btn-block" type="submit" name="btn-signup">Signup</button></br>
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
