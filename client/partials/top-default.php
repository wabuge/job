<?php
session_start();
require_once '../class.user.php';
$user_home = new USER();

//check if user is logged in
if(!$user_home->is_logged_in()){
 $user_home->redirect('../login.php');
}

//get user details
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$id = $row['userID'];

//check for notifications
$email = $row['userEmail'];
$res = $conn->query("SELECT * FROM tbl_applicants WHERE userEmail='$email' AND textMssg!='N' AND clientSeen='N' ");
$notificationcount = $res->num_rows;

?>
