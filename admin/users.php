<?php
require 'partials/top-default.php';

if(isset($_GET['applications'])){
  $_SESSION['userName'] = $_GET['applications'];
  header("location: applications.php");
}

/* code for data delete */
if(isset($_GET['del'])){
 $SQL = $conn->prepare("DELETE FROM users WHERE userID=".$_GET['del']);
 $SQL->bind_param("i",$_GET['del']);
 $SQL->execute();
 header("Location: users.php");
}
/* code for data delete */
?>
<!DOCTYPE html>
<html lang="en">

<?php require "partials/head.php"; ?>

<body>

    <div id="wrapper">

        <?php require "partials/navbar.php"; ?>

        <div id="page-wrapper">
        <!-- /.row -->
            <div class="row" style="padding-top:10px;">
                <div class="col-md-12">

                  <div style="background-color:white;width:100;height:40px;border:1px solid #e0e0e0;margin-bottom:10px;">
                    <h4 style="padding-left:10px;">Users
                      <button class="pull-right btn btn-info btn-sm" onclick="printContent('users')" style="margin-top:-6px;margin-right:5px;"> <i class="fa fa-print"></i> Print</button>
                    </h4>
                  </div>

                    <div class="panel panel-default" style="margin-top:10px;">
                        <div class="panel-body">

                          <div id="users" class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                              <thead>
                                <tr>
                                  <th colspan="10" style="text-align:center;">Users</th>
                                </tr>
                                <tr>
                                  <th>User Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>About</th>
                                  <th>CV</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>

                                <?php
                                $user = "user";
                                $res = $conn->query("SELECT * FROM users WHERE loginType='$user' ORDER BY userID DESC");
                                 while($row=$res->fetch_array()){ ?>
                                   <tr>
                                     <td><?php echo $row['userName']; ?></td>
                                    <td><?php echo $row['userEmail']; ?></td>
                                    <td><?php echo $row['userPhone']; ?></td>
                                    <td><?php echo $row['about']; ?></td>
                                    <td>
                                      <?php if($row['cv']){ ?>
                                        Added
                                      <?php }else{ ?>
                                        Not Added
                                      <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                        $name = $row['userName'];
                                        $respo = $conn->query("SELECT * FROM tbl_applicants WHERE userName='$name'");
                                        $num = $respo->num_rows;
                                        ?>
                                        <?php echo $num; ?><a href="?applications=<?php echo $row['userName']; ?>"> Applications</a>
                                    </td>
                                    </tr>
                                    <?php } ?>

                              </tbody>
                            </table>
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
