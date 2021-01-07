<?php

require_once 'databases/dbconfig.php';

class USER
{

 private $conn;

 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
    }

 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }

 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }

 public function register($uname,$email,$upass,$uphone,$urole)
 {
  try
  {
   $password = md5($upass);
   $stmt = $this->conn->prepare("INSERT INTO users(userName,userEmail,userPass,userPhone,loginType)
                                                VALUES(:user_name, :user_mail, :user_pass, :user_phone,:user_type)");
   $stmt->bindparam(":user_name",$uname);
   $stmt->bindparam(":user_mail",$email);
   $stmt->bindparam(":user_pass",$password);
   $stmt->bindparam(":user_phone",$uphone);
   $stmt->bindparam(":user_type",$urole);
   $stmt->execute();
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }

 public function login($email,$upass){
  try{
   $stmt = $this->conn->prepare("SELECT * FROM users WHERE userEmail=:email_id");
   $stmt->execute(array(":email_id"=>$email));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
   //$type = $userRow['loginType'];

   if($stmt->rowCount() == 1){
     if($userRow['userPass']==md5($upass)){
       if($userRow['loginType']=="admin"){
         $_SESSION['userSession'] = $userRow['userID'];
         echo "<script>window.location.assign('admin/home.php')</script>";
       } else{
         $_SESSION['userSession'] = $userRow['userID'];
         echo "<script>window.location.assign('client/home.php')</script>";
       }
     } else {
      header("Location: login.php?error");
      echo "Wrong password";
      exit;
     }
   } else {
    header("Location: login.php?error");
    echo "No user found";
    exit;
   }
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }


 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }

 public function redirect($url)
 {
  header("Location: $url");
 }

 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
 }

 function send_mail($email,$message,$subject){
   require_once('assets/mailer/class.phpmailer.php');
   $mail = new PHPMailer();
   $mail->IsSMTP();
  $mail->SMTPDebug  = 0;
  $mail->SMTPAuth   = true;
  $mail->SMTPSecure = "ssl";
  $mail->Host       = "smtp.gmail.com";
  $mail->Port       = 465;
  $mail->AddAddress($email);
  $mail->Username="kenyamoja54@gmail.com";
  $mail->Password="oceansea@uganda";
  $mail->SetFrom('you@yourdomain.com','Online Job Recruitment Portal');
  $mail->Subject    = $subject;
  $mail->MsgHTML($message);
  $mail->Send();

  return true;
 }

}
