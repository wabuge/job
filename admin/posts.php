<?php
require 'partials/top-default.php';

if(isset($_GET['applicants'])){
  $_SESSION['applicants']=$_GET['applicants'];
 header("Location: postApplicants.php");
}

$name = $_SESSION['companyName'];

$i = 0;
$res = $conn->query("SELECT * FROM tbl_posts WHERE companyName='$name'");
while($Row=$res->fetch_array()){
  $i++;
}
?>

<!DOCTYPE html>
<html lang="en">

<?php require "partials/head.php"; ?>

<body>

    <div id="wrapper">

        <?php require "partials/navbar.php"; ?>

        <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Company:<?php echo $name; ?>'s Posts</h3>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                          <?php
                          $res = $conn->query("SELECT * FROM tbl_posts WHERE companyName='$name' ORDER BY id DESC");
                          while($Row=$res->fetch_array()){
                            $d = $Row['id'];
                            $response = $conn->query("SELECT * FROM tbl_applicants WHERE postId='$d'");
                            $num = $response->num_rows; ?>
                            <div class="list-group-item">
                            <b><?php echo $Row['position']; ?></b>
                            <span class="pull-right"><?php echo $Row['category']; ?></span>
                            <span class="pull-right"><i class="fa fa-map-marker"></i><?php echo $Row['location']; ?>&nbsp&nbsp</span>
                            <hr>
                            <span><?php echo $Row['detail']; ?></span>
                            <hr>
                            <span class="pull-right text-muted"><?php echo $Row['postTime']; ?></span>
                            <a href="?applicants=<?php echo $Row['id']; ?>"><?php echo $num; ?> Applicants</a>
                          </div>
                            <br>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-8 -->
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
         </div>
    </div>
    <!-- /#wrapper -->

   <?php require "partials/footer.php"; ?>
</body>
</html>
