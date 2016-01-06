<?php
include("session.php");
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
        

        <!-- Call to Action Well -->
        <div class="row" id="pa2">
            <div class="col-lg-12">
                <div class="well text-center">
                    Welcome, <i><?php echo $login_session; ?></i>!
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <hr class="prettyline">
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-6">
                <h2>Search for a book</h2>
                <a button class="btn btn-default" href="#signup" data-toggle="modal" data-target=".bs-modal-sm">Search</a>

            </div>
            <div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <br>
                    <div class="bs-example bs-example-tabs">
                        <ul id="myTab" class="nav nav-tabs">
                          <li class="active"><a href="#signin" data-toggle="tab">Simple Search</a></li>
                          <li class=""><a href="#signup" data-toggle="tab">Advanced Search</a></li>
                        </ul>
                    </div>
                  <div class="modal-body">
                    <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="signin">
                        <form class="form-horizontal" method="POST" action="findbook_simple.php" enctype="multipart/form-data">
                        <fieldset>
                        <div class="control-group">
                          <!-- <label class="control-label" for="userid">Book Name</label> -->
                          <div class="controls">
                            Book Name: <input required="" type="text" class="form-control" name="bookname" placeholder="Name">
                          </div>
                        </div>

                        <!-- Button -->
                        <div class="form-horizontal" method="POST" action="findbook_simple.php" enctype="multipart/form-data">
                          <label class="control-label" for="signin"></label>
                          <div class="controls">
                            <button id="signin" name="signin" class="btn btn-success">Search</button>
                          </div>
                        </div>
                        </fieldset>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="signup">
                        <form class="form-horizontal" method="POST" action="findbook_advanced.php">
                        <fieldset>
                        <!-- Sign Up Form -->
                        <!-- Text input-->
                        <div class="control-group">
                          <label class="control-label" for="author">Author</label>
                          <div class="controls">
                            <input id="text" name="author" class="form-control" type="text" placeholder="Author" class="input-large" >
                          </div>
                        </div>
                        
                        <!-- Text input-->
                        <div class="control-group">
                          <label class="control-label" for="publisher">Publisher</label>
                          <div class="controls">
                            <input id="text" name="publisher" class="form-control" type="text" placeholder="Publisher" class="input-large" >
                          </div>
                        </div>
                        
                        <!-- Password input-->
                        <div class="control-group">
                          <label class="control-label" for="genre">Genre</label>
                          <div class="controls">
                            <input id="text" name="genre" class="form-control" type="text" placeholder="Genre" class="input-large" >
                          </div>
                        </div>
                        <br>

                        <div class="control-group">
                          <label class="control-label" for="sort">Sort By</label>
                          <div class="controls">
                            <!-- <input id="text" name="sort" class="form-control" type="text" placeholder="Genre" class="input-large"> -->
                            <input type="radio" name="sort" value="year" id="text"> Publication Year<br/>
                            <input type="radio" name="sort" value="rate" id="text"> Rating
                          </div>
                        </div>
                        <br>
                        
                        <!-- Button -->
                        <div class="control-group">
                          <label class="control-label" for="confirmsignup"></label>
                          <div class="controls">
                            <button id="confirmsignup" name="confirmsignup" class="btn btn-success">Search</button>
                          </div>
                        </div>
                        </fieldset>
                        </form>
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
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h2>Most rated books</h2>
                <a class="btn btn-default" href="topusers.php">Books rating</a>
            </div>
            <!-- /.col-md-4 -->
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
