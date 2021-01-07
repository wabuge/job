<?php
session_start();
require_once '../class.user.php';

$user_home = new USER();

if(!$user_home->is_logged_in()){
 $user_home->redirect('../login.php');
}

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//check for notifications
$email = $row['userEmail'];
$res = $conn->query("SELECT * FROM tbl_applicants WHERE textMssg='N' AND adminSeen='N' ");
$notificationcount = $res->num_rows;

?>
