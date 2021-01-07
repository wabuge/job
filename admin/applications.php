<?php
require 'partials/top-default.php';

$name = $_SESSION['userName'];

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
                <h3 class="page-header"><?php echo $name; ?>'s aplications</h3>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                          <div class="list-group">
                          <?php
                          $res = $conn->query("SELECT * FROM tbl_applicants WHERE userName='$name'");
                          while($Row=$res->fetch_array()) {
                            $d = $Row['postId'];
                            $response = $conn->query("SELECT * FROM tbl_posts WHERE id='$d'");
                            $row=$response->fetch_array();
                            ?>
                            <div class="list-group-item">
                            <span>Company: <?php echo $Row['companyName']; ?></span>
                            <span class="pull-right">0<?php echo $Row['userPhone']; ?></span>
                            <br>
                            <span><?php echo $row['position']; ?></span>
                            <span class="pull-right"><?php echo $row['category']; ?></span>
                            <p><?php echo $row['detail']; ?></p>
                              <?php if($Row['status']==''){ ?>
                                <span><i class="fa fa-circle-o-notch fa-spin" style="color:orange;"></i>Pending</span>
                              <?php } else if($Row['status']=='Yes'){ ?>
                              <span><i class="fa fa-check" style="color:green;"></i>Accepted</span>
                              <?php } else if($Row['status']=='No'){ ?>
                                <span><i class="fa fa-times" style="color:red;"></i>Declined</span>
                              <?php } ?>
                            <span class="pull-right text-muted"><?php echo $Row['postTime']; ?></span>
                            <br>
                          </div>
                          <?php } ?>
                        </div>
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
