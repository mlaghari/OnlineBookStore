<?php
include("session.php");
    $limit = $_POST['quantity'];
    $querytop = mysql_query("select Distinct FirstName, LastName, PersonID, Percentage from customerdata ,(select Distinct UserID, Percentage 
          from feedback, (select Distinct A.FeedBackID, (B.count/A.count)*100 as Percentage 
          from (select Distinct FeedBackID, RaterID, count(FeedBackID) as count
          from usefulness
          where FeedBack like 'Useful%' OR FeedBack like 'Useless%'
          group by FeedBackID order by count) As A, (select Distinct FeedBackID, RaterID, count(FeedBackID) as count
          from usefulness
          where FeedBack like 'Useful%'
          group by FeedBackID order by count) As B
          where A.FeedBackID = B.FeedBackID
          Order by Percentage desc Limit $limit) AS C
          where feedback.FeedBackID =  C.FeedBackID) As D
          where D.UserID = customerdata.PersonID order by Percentage desc");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Online Book Store</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/small-business.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation -->
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand active" href="index.php">BookStore</a>
        </div>
        <center>
            <div class="navbar-collapse collapse" id="navbar-main">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> 
                            <strong>Welcome, </strong><i><?php echo $login_session; ?></i>
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="navbar-login">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <p class="text-center">
                                                <span class="glyphicon glyphicon-user icon-size"></span>
                                            </p>
                                        </div>
                                        <div class="col-lg-8">
                                            <p class="text-left"><strong>Name: </strong><i><?php echo $login_session; ?></i></p>
                                            <p class="text-left"><strong>UserID: </strong><i><?php echo $session_id; ?></i></p>
                                            <p class="text-left"><strong>Account Type: </strong><i><?php echo $type; ?></i></p>
                                            <p class="text-left">
                                            <?php
                                                if ($type == "Admin") {
                                                    echo '<a href="admin_profile.php" class="btn btn-primary btn-block btn-sm">Profile</a>';
                                                } else {
                                                    echo '<a href="user_profile.php" class="btn btn-primary btn-block btn-sm">Profile</a>';
                                                }
                                            ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="navbar-login navbar-login-session">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>
                                                <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </center>
    </div>
</div>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="span12">
            <table class="table table-striped table-condensed">
                  <thead>
                  <tr>
                      <th>PersonID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Percentage</th>                                         
                  </tr>
              </thead>   
              <tbody>
              <?php
                while ($row = mysql_fetch_assoc($querytop)) {
                    echo '<tr><td>',$row['PersonID'],'</td>',
                    '<td>',$row['FirstName'],'</td>',
                    '<td>',$row['LastName'],'</td>',
                    '<td>',$row['Percentage'],'</td>',                                      
                    '</tr>';

                }
              ?>                            
              </tbody>
            </table>
            </div>
    </div>
</div>
<!-- /.row -->
        <br><br>
        <hr class="prettyline">

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Mohammad Laghari &amp; Hamza Imran 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
