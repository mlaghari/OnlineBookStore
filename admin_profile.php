<?php
include("session.php");
$conn=mysql_connect("localhost", "root", "");
$db=mysql_select_db("bookstore", $conn);
$queryFormat = mysql_query("select Format, sum(total) as sum from (select A.ISBN, A.count, count*(select Price from books where A.ISBN = books.ISBN) as total
        from (select ISBN, count(*) as count from booksordered group by ISBN order by count desc) as A) as B, books 
        where B.ISBN = books.ISBN group by Format order by sum desc");
$queryYear = mysql_query("select YearOfPublication, sum(total) as sum from
(select A.ISBN, A.count, count*(select Price from books where A.ISBN = books.ISBN) as total
 from (select ISBN, count(*) as count from booksordered group by ISBN order by count desc) as A) as B, books 
 where B.ISBN = books.ISBN group by YearOfPublication order by sum desc Limit 5");
$queryPub = mysql_query("select Publisher, sum(total) as sum from
(select A.ISBN, A.count, count*(select Price from books where A.ISBN = books.ISBN) as total
 from (select ISBN, count(*) as count from booksordered group by ISBN order by count desc) as A) as B, books 
 where B.ISBN = books.ISBN group by Publisher order by sum desc Limit 5");
$queryGenre = mysql_query("select Genre, sum(total) as sum from
(select A.ISBN, A.count, count*(select Price from books where A.ISBN = books.ISBN) as total
 from (select ISBN, count(*) as count from booksordered group by ISBN order by count desc) as A) as B, books 
 where B.ISBN = books.ISBN group by Genre order by sum desc");
$total = mysql_query("select sum(total) as TotalEarnings from (select A.ISBN, A.count, count*(select Price from books where A.ISBN = books.ISBN) as total
 from (select ISBN, count(*) as count from booksordered group by ISBN order by count desc) as A) as C");
// zero count
$queryZero = mysql_query("select ISBN, Title, NumberOfCopies from books where NumberOfCopies=1 ");


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
    <inline><h1>Admin Dashboard</h1>
    <a href="#" class="btn btn-warning btn-lg pull-right" role="button" data-toggle="modal" data-target="#myModal-top">Award walay banday</a>
    <br><br></inline>
    <div class="modal fade bs-modal-sm" id="myModal-top" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Top M Users</h4>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade active in" id="signin">
        <form class="form-horizontal" method="POST" action="award.php" enctype="multipart/form-data">
        <fieldset>
        <div class="control-group">
          <div class="controls">
            Quantity: <input required="" type="number" class="form-control" name="quantity" placeholder="Quantity">
          </div>
        </div>
        <br><br>

        <!-- Button -->
          <label class="control-label" for="signin"></label>
          <div class="controls">
          <center><button id="signin" name="signin" class="btn btn-success">Find</button></center>
            
          </div>
        </div>
        </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></center>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <hr class="prettyline">

        <!-- Call to Action Well -->
        <!-- <div class="row" id="pa2">
            <div class="col-lg-12">
                <div class="well text-center">
                    Search Results!
                </div>
            </div>
        </div> -->
        <!-- /.row -->

        <!-- Content Row -->
        <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> Quick Shortcuts</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-danger btn-lg" role="button" data-toggle="modal" data-target="#addUser"><span class="glyphicon glyphicon-plus"></span> <br/>Add User</a>
                          <a href="#" class="btn btn-warning btn-lg" role="button" data-toggle="modal" data-target="#addbook"><span class="glyphicon glyphicon-book"></span> <br/>Add Book</a>
                          <a href="#" class="btn btn-success btn-lg" role="button" data-toggle="modal" data-target="#addadmin"><span class="glyphicon glyphicon-plus"></span> <br/>Add Admin</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#earnings"><span class="glyphicon glyphicon-usd"></span> <br/>Earnings</a>
                        </div>
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-warning btn-lg" role="button" data-toggle="modal" data-target="#booksout"><span class="glyphicon glyphicon-download"></span> <br/>Books Out</a>
                          <a href="#" class="btn btn-danger btn-lg" role="button" data-toggle="modal" data-target="#newCopies"><span class="glyphicon glyphicon-file"></span> <br/>Add Copy</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#book"><span class="glyphicon glyphicon-tower"></span> <br/>Best Books</a>
                          <a href="#" class="btn btn-success btn-lg" role="button" data-toggle="modal" data-target="#authors"><span class="glyphicon glyphicon-certificate"></span> <br/><center>Best Authors</center></a>
                        </div>
                    </div>
                    <!-- <a href="http://www.jquery2dotnet.com/" class="btn btn-success btn-lg btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add book modal -->
<div class="modal fade bs-modal-lg" id="addbook" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add New Resource</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" method="POST" action="addbook.php" enctype="multipart/form-data">
                <fieldset>

                  <!-- Form Name -->
                  <legend>Book Details</legend>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">ISBN</label>
                    <div class="col-sm-10">
                      <input type="text" name="isbn" id="first_name" class="form-control input-lg" placeholder="ISBN" tabindex="1">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="name" id="last_name" class="form-control input-lg" placeholder="Name" tabindex="2">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Author</label>
                    <div class="col-sm-10">
                      <input type="text" name="author" id="display_name" class="form-control input-lg" placeholder="Author" tabindex="3">
                    </div>
                  </div>

                  <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Price</label>
                    <div class="col-sm-10">
                      <input type="text" name="price" id="ccnumber" class="form-control input-lg" placeholder="Price" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Genre</label>
                    <div class="col-sm-10">
                      <input type="text" name="genre" id="phone" class="form-control input-lg" placeholder="Genre" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Format</label>
                    <div class="col-sm-10">
                      <input type="text" name="format" id="phone" class="form-control input-lg" placeholder="Format" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Publisher</label>
                    <div class="col-sm-10">
                      <input type="text" name="publisher" id="phone" class="form-control input-lg" placeholder="Publisher" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Number of Copies</label>
                    <div class="col-sm-10">
                      <input type="text" name="copies" id="phone" class="form-control input-lg" placeholder="Number of Copies" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Year of Publication</label>
                    <div class="col-sm-10">
                      <input type="text" name="year" id="phone" class="form-control input-lg" placeholder="Year of Publication" tabindex="4">
                    </div>
                </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="pull-right">
                        <!-- <button type="submit" class="btn btn-default">Cancel</button> -->
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </form>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>

<!-- add user modal -->
<div class="modal fade bs-modal-lg" id="addUser" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add New User Account</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" method="POST" action="addUser.php" enctype="multipart/form-data">
                <fieldset>

                  <!-- Form Name -->
                  <legend>User Details</legend>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">First Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Last Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Username</label>
                    <div class="col-sm-10">
                      <input type="text" name="display_name" id="display_name" class="form-control input-lg" placeholder="Display Name" tabindex="3">
                    </div>
                  </div>

                  <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Credit Card Number</label>
                    <div class="col-sm-10">
                      <input type="text" name="ccnumber" id="ccnumber" class="form-control input-lg" placeholder="Credit Card Number" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Address</label>
                    <div class="col-sm-10">
                      <input type="text" name="add" id="ccnumber" class="form-control input-lg" placeholder="Address" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Phone Number</label>
                    <div class="col-sm-10">
                      <input type="text" name="phone" id="phone" class="form-control input-lg" placeholder="Phone Number" tabindex="4">
                    </div>
                  </div>
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
                    </div>
                  </div>
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="pull-right">
                        <!-- <button type="submit" class="btn btn-default">Cancel</button> -->
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </form>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>



<!-- add admin modal -->
<!-- add user modal -->
<div class="modal fade bs-modal-lg" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add New Admin Account</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" method="POST" action="addAdmin.php" enctype="multipart/form-data">
                <fieldset>

                  <!-- Form Name -->
                  <legend>Admin Details</legend>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">First Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Last Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Username</label>
                    <div class="col-sm-10">
                      <input type="text" name="display_name" id="display_name" class="form-control input-lg" placeholder="Display Name" tabindex="3">
                    </div>
                  </div>

                  <!-- Text input-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Credit Card Number</label>
                    <div class="col-sm-10">
                      <input type="text" name="ccnumber" id="ccnumber" class="form-control input-lg" placeholder="Credit Card Number" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Address</label>
                    <div class="col-sm-10">
                      <input type="text" name="add" id="ccnumber" class="form-control input-lg" placeholder="Address" tabindex="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Phone Number</label>
                    <div class="col-sm-10">
                      <input type="text" name="phone" id="phone" class="form-control input-lg" placeholder="Phone Number" tabindex="4">
                    </div>
                  </div>



                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
                    </div>
                  </div>
                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="pull-right">
                        <!-- <button type="submit" class="btn btn-default">Cancel</button> -->
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </form>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>


<!-- add earnings modal -->
<div class="modal fade bs-modal-lg" id="earnings" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Earnings</h4>
      </div>
      <div class="modal-body">
            <div class="panel with-nav-tabs panel-info">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1info" data-toggle="tab">Total</a></li>
                            <li><a href="#tab2info" data-toggle="tab">By Genre</a></li>
                            <li><a href="#tab3info" data-toggle="tab">By Publisher</a></li>
                            <li><a href="#tab4info" data-toggle="tab">By Year</a></li>
                            <li><a href="#tab5info" data-toggle="tab">By Format</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1info">
                            <h3>
                                <?php
                                    while ($row = mysql_fetch_assoc($total)) {
                                        echo '<h3>$',$row['TotalEarnings'],'</h3>';
                                    }
                                ?>
                            </h3>
                        </div>
                        <div class="tab-pane fade" id="tab2info">
                            <table class="table table-striped table-condensed">
                                  <thead>
                                  <tr>
                                      <th>Genre</th>
                                      <th>Earnings</th>                                          
                                  </tr>
                              </thead>   
                              <tbody>
                            <?php
                                while ($row = mysql_fetch_array($queryGenre)) {
                                    echo '<tr><td>',$row['Genre'],'</td>',
                                            '<td>$',$row['sum'],'</td>',                                      
                                         '</tr>';
                                }
                            ?>
                            </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab3info">
                            <table class="table table-striped table-condensed">
                                  <thead>
                                  <tr>
                                      <th>Publisher</th>
                                      <th>Earnings</th>                                          
                                  </tr>
                              </thead>   
                              <tbody>                       
                            <?php
                                while ($row = mysql_fetch_assoc($queryPub)) {
                                    echo '<tr>',
                                        '<td>',$row['Publisher'],'</td>',
                                        '<td>$',$row['sum'],'</td>',
                                        '</td>',                                       
                                    '</tr>';
                                }
                            ?>
                            </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab4info">
                            <table class="table table-striped table-condensed">
                                  <thead>
                                  <tr>
                                      <th>Year of Publication</th>
                                      <th>Earnings</th>                                          
                                  </tr>
                              </thead>   
                              <tbody>                       
                            <?php
                                while ($row = mysql_fetch_assoc($queryYear)) {
                                    echo '<tr>',
                                        '<td>',$row['YearOfPublication'],'</td>',
                                        '<td>$',$row['sum'],'</td>',
                                        '</td>',                                       
                                    '</tr>';
                                }
                            ?>
                            </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab5info">
                            <table class="table table-striped table-condensed">
                                  <thead>
                                  <tr>
                                      <th>Format</th>
                                      <th>Earnings</th>                                          
                                  </tr>
                              </thead>   
                              <tbody>                          
                            <?php
                                while ($row = mysql_fetch_assoc($queryFormat)) {
                                    echo '<tr>',
                                        '<td>',$row['Format'],'</td>',
                                        '<td>$',$row['sum'],'</td>',
                                        '</td>',                                       
                                    '</tr>';
                                }
                            ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

<!-- add books finished modal -->
<div class="modal fade bs-modal-lg" id="booksout" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Resources Exhausted</h4>
      </div>
      <div class="modal-body"> 
        <table class="table table-striped table-condensed">
          <thead>
          <tr>
              <th>ISBN</th>
              <th>Book Title</th>
              <th>Copies Left</th>                                          
          </tr>
      </thead>   
      <tbody>
    <?php
        while ($row = mysql_fetch_array($queryZero)) {
            echo '<tr><td>',$row['ISBN'],'</td>',
                    '<td>',$row['Title'],'</td>',
                    '<td>',$row['NumberOfCopies'],'</td>',                                      
                 '</tr>';
        }
    ?>
    </tbody>
    </table>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>

<!-- add new copies modal -->
<div class="modal fade bs-modal-lg" id="newCopies" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Copies of Existing Resource</h4>
      </div>
      <div class="modal-body"> 
        <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" method="POST" action="addexisting.php" enctype="multipart/form-data">
                <fieldset>

                  <!-- Form Name -->
                  <legend>Book Details</legend>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">ISBN</label>
                    <div class="col-sm-10">
                      <input type="text" name="isbn" id="first_name" class="form-control input-lg" placeholder="ISBN" tabindex="1">
                    </div>
                  </div>
                    <div class="form-group">
                    <!-- <label class="col-sm-2 control-label" for="textinput">Quantity</label> -->
                          '<div class="input-group col-sm-4 col-sm-offset-5">',
                              <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quantity">
                                    <span class="glyphicon glyphicon-minus"></span>
                                  </button>
                              </span>
                              <input type="text" name="quantity" class="form-control input-number" value="2" min="1" max="10">
                              <span class="input-group-btn">
                                  <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quantity">
                                      <span class="glyphicon glyphicon-plus"></span>
                                  </button>
                              </span>
                          </div>
                    </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="pull-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                  </div>
                  
                </fieldset>
              </form>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>

<!-- add new copies modal -->
<div class="modal fade bs-modal-lg" id="book" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Enter year</h4>
      </div>
      <div class="modal-body"> 
        <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" method="POST" action="topbooks.php" enctype="multipart/form-data">
                <fieldset>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Year</label>
                    <div class="col-sm-10">
                      <input type="text" name="year" id="first_name" class="form-control input-lg" placeholder="Year" tabindex="1">
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Number</label>
                    <div class="col-sm-10">
                      <input type="number" name="limit" id="first_name" class="form-control input-lg" placeholder="Number of books" tabindex="1">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="pull-right">
                        <button type="submit" class="btn btn-primary">Next</button>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </form>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </center>  
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-modal-lg" id="authors" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Enter year</h4>
      </div>
      <div class="modal-body"> 
        <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" method="POST" action="topauthors.php" enctype="multipart/form-data">
                <fieldset>
                    <div class="form-group">
                    <label class="col-sm-2 control-label" for="textinput">Number</label>
                    <div class="col-sm-10">
                      <input type="number" name="limit" id="first_name" class="form-control input-lg" placeholder="Number of books" tabindex="1">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="pull-right">
                        <button type="submit" class="btn btn-primary">Next</button>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </form>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
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
