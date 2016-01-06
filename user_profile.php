<?php
include("session.php");
// $session=mysql_query("SELECT * FROM `customerdata` WHERE login_name='$check'");
// $row=mysql_fetch_array($session);
$pnum=$row[3];
$padd=$row[6];;
$cc=$row[7];
$f = $row[5];
$l=$row[4];
$query = mysql_query("select OrderNumber, ISBN, DateOrdered, Status from booksordered where PersonID = '$session_id'");
$queryF = mysql_query("select FeedBackID, ISBN, Rating, Comments from feedback where UserID = '$session_id'");
$queryU = mysql_query("select FeedBackID, FeedBack from usefulness where RaterID = '$session_id'");
$per = mysql_query("(select (B.count/A.count)*100 as Percentage 
from (select FeedBackID, RaterID, count(RaterID) as count
from usefulness
where (FeedBack like 'Useful%' OR FeedBack like 'Useless%') and RaterID = '$session_id'
group by RaterID order by count) As A, (select FeedBackID, RaterID, count(RaterID) as count
from usefulness
where FeedBack like 'Useful%' and RaterID = '$session_id'
group by RaterID order by count) As B 
where A.RaterID = B.RaterID
Order by Percentage desc)");
$percen = 0;
$roww = mysql_fetch_assoc($per);
$percen = $roww['Percentage'];
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
                                                <a href="#" class="btn btn-primary btn-block btn-sm">Profile</a>
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
    <!-- <h1>Hello <i><?php echo $login_session; ?></i>, how are you today?</h1> -->
        <!-- <hr class="prettyline"> -->
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
  <div class="row">
    <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
       <div class="well profile">
            <div class="col-sm-12">
                <div class="col-xs-12 col-sm-8">
                    <h2><i><?php echo $login_session; ?></i></h2>
                    <p><strong>ID: </strong><i><?php echo $session_id; ?></i></p>
                    <p><strong>First Name: </strong><i><?php echo $f; ?></i></p>
                    <p><strong>Last Name: </strong><i><?php echo $l; ?></i></p>
                    <p><strong>Phone Number: </strong><i><?php echo $pnum; ?></i></p>
                    <p><strong>Address: </strong><i><?php echo $padd; ?></i></p>
                    <p><strong>Credit Card Number: </strong><i><?php echo $cc; ?></i></p>
                    <!-- <p><strong>Total Spent: </strong><i><?php echo $tot; ?></i></p> -->
                    <p><strong>Correct Feedback Percentage: </strong><i><?php echo $percen; ?></i>%</p>
                </div>             
                <div class="col-xs-12 col-sm-4 text-center">
                    <figure>
                        <img src="http://www.localcrimenews.com/wp-content/uploads/2013/07/default-user-icon-profile.png" alt="" class="img-circle img-responsive">
                        
                    </figure>
                </div>
            </div>            
            <div class="col-xs-12 divider text-center">
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h5><strong>Total Orders</strong></h5>                    
                    <!-- <p><small>Total Orders</small></p> -->
                    <button class="btn btn-success btn-block" data-toggle="modal" data-target="#orders"><span class="fa fa-eye-open"></span> View </button>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h5><strong>Feedbacks</strong></h5>                    
                    <!-- <p><small>Feedbacks</small></p> -->
                    <button class="btn btn-info btn-block" data-toggle="modal" data-target="#feedbacks"><span class="fa fa-eye-open"></span> View </button>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h5><strong>Usefulness</strong></h5>                    
                    <!-- <p><small>Usefulness</small></p> -->
                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#usefulness"><span class="fa fa-eye-open"></span> View </button>
                </div>
            </div>
       </div>                 
    </div>
  </div>
</div>

<!-- add new copies modal -->
<div class="modal fade bs-modal-lg" id="orders" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Total Orders</h4>
      </div>
      <div class="modal-body">
        <div class="span6">
            <table class="table table-striped table-condensed">
                  <thead>
                  <tr>
                      <th>OrderID</th>
                      <th>Book ISBN</th>
                      <th>Order Date</th>
                      <th>Status</th>                                          
                  </tr>
              </thead>   
              <tbody>
              <?php
              while ($row = mysql_fetch_assoc($query))
                // if ($row['Status'] == 1) {
                //     $q = '<span class="label label-success">Delivered</span>';
                // } else if ($row['Status'] == 0) {
                //     $q = '<span class="label label-warning">Pending</span>';
                // } else {
                //     $q = '<span class="label">No Status</span>';
                // }
                // // echo $q;

                echo '<tr>',
                    '<td>',$row['OrderNumber'],'</td>',
                    '<td>',$row['ISBN'],'</td>',
                    '<td>',$row['DateOrdered'],'</td>',
                    '<td>',$row['Status'],'<td>',
                    '</tr>';
                ?>                                  
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-modal-lg" id="feedbacks" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Total Orders</h4>
      </div>
      <div class="modal-body">
        <div class="span12">
            <table class="table table-striped table-condensed">
                  <thead>
                  <tr>
                      <th>FeedBackID</th>
                      <th>ISBN</th>
                      <th>Rating</th>
                      <th>Comments</th>                                          
                  </tr>
              </thead>   
              <tbody>
              <?php
              while ($row = mysql_fetch_assoc($queryF))

                echo '<tr>',
                    '<td>',$row['FeedBackID'],'</td>',
                    '<td>',$row['ISBN'],'</td>',
                    '<td>',$row['Rating'],'</td>',
                    '<td>',$row['Comments'],'<td>',
                    '</tr>';
                ?>                                  
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-modal-lg" id="usefulness" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Total Orders</h4>
      </div>
      <div class="modal-body">
        <div class="span12">
            <table class="table table-striped table-condensed">
                  <thead>
                  <tr>
                      <th>FeedBackID</th>
                      <th>Usefulness</th>                                         
                  </tr>
              </thead>   
              <tbody>
              <?php
              while ($row = mysql_fetch_assoc($queryU))

                echo '<tr>',
                    '<td>',$row['FeedBackID'],'</td>',
                    '<td>',$row['FeedBack'],'</td>',
                    '</tr>';
                ?>                                  
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>


<!-- /.row -->
<br><br>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
            <hr class="prettyline">
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
