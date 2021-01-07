<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top navbar-fixed-top" role="navigation" style="margin-bottom: 50px">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">Online Job Recruitment Portal</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
      <li>
        <a href="notifications.php"><i class="fa fa-bell"></i><?php echo $notificationcount; ?> Notification(s)</a>
      </li>
      <li>
        <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
      </li>
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="post.php"><i class="fa fa-plus fa-fw"></i> Add Job</a>
                </li>
                <li>
                    <a href="applied.php"><i class="fa fa-th-list fa-fw"></i> Applications</a>
                </li>
                <li>
                    <a href="notifications.php"><i class="fa fa-bell fa-fw"></i> Notifications</a>
                </li>
                <li>
                    <a href="users.php"><i class="fa fa-edit fa-fw"></i> Users</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
