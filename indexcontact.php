<?php
session_start();
require_once 'dbconfig.php';

if(isset($_POST['name'])){
    // get values
   	$Name =  $_POST['name'];
   	$Email = $_POST['email'];
   	$Subject = $_POST['subject'];
   	$Message =  $_POST['message'];

    $SQL = $conn->prepare("INSERT INTO tbl_contact(name, email, subject, message) VALUES(?,?,?,?)");

    if(!$SQL){
     echo $conn->error;
    }else{
      $SQL->bind_param('ssss',$Name, $Email, $Subject, $Message);
      $SQL->execute();
      echo "<div class='alert alert-success'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Success!</strong>.Message Sent.</div>";
    }
}
?>
