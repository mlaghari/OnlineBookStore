<?php 
    include("session.php");
    $h = "here";
    $query = mysql_query("SELECT * from authorbooks");
    $check = $_POST['sort'];
    // echo $check;
    if ($check == "year") {
        if (!empty($_POST['author']) || !empty($_POST['publisher']) || !empty($_POST['genre'])) {
            // echo $_POST['author'];
            // echo $_POST['publisher'];
            // echo $_POST['genre'];
            if (!empty($_POST['author']) && !empty($_POST['publisher']) && !empty($_POST['genre'])) {
                // echo $h;
                $author = $_POST['author'];
                $publisher = $_POST['publisher'];
                $genre = $_POST['genre'];
                echo $author;
                echo $publisher;
                echo $genre;
                $query =  mysql_query("select * from books as b where Genre = '$genre' and Publisher = '$publisher' 
                                and b.ISBN 
                                IN (select ISBN from authorbooks as ab 
                                 where ab.AuthorID IN (select AuthorID 
                                 from authors as a where a.Name = '$author'))");
            } else if (!empty($_POST['author']) && !empty($_POST['publisher'])) {
                // echo $h;
                $author = $_POST['author'];
                $publisher = $_POST['publisher'];
                $query =  mysql_query("select * from books as b where Publisher = '$publisher' and b.ISBN 
                                IN (select ISBN from authorbooks as ab 
                                 where ab.AuthorID IN (select AuthorID 
                                 from authors as a where a.Name = '$author'))");
            } else if (!empty($_POST['author']) && !empty($_POST['genre'])) {
                // echo $h;
                $author = $_POST['author'];
                $genre = $_POST['genre'];
                $query =  mysql_query("select * from books as b where Genre = '$genre' and b.ISBN 
                            IN (select ISBN from authorbooks as ab 
                            where ab.AuthorID IN (select AuthorID 
                            from authors as a where a.Name = '$author'))");
            } else if (!empty($_POST['publisher']) && !empty($_POST['genre'])) {
                // echo $h;
                $publisher = $_POST['publisher'];
                $genre = $_POST['genre'];
                $query =  mysql_query("select * from books where Genre = '$genre' and Publisher = '$publisher'");

            } else if (!empty($_POST['publisher'])) {
                // echo $h;/
                $publisher = $_POST['publisher'];
                $query =  mysql_query("select * from books where Publisher = '$publisher'");

            } else if (!empty($_POST['genre'])) {
                // echo $h;
                $genre = $_POST['genre'];
                $query =  mysql_query("select * from books where Genre = '$genre'");

            } else if (!empty($_POST['author'])) {
                // echo $h;
                $author = $_POST['author'];
                $query =  mysql_query("select * from books where ISBN IN (select ISBN from authorbooks as ab 
                            where ab.AuthorID = (select AuthorID from authors where Name = '$author'))");            

            }
        }
    } else if ($check == "rate") {
        if (!empty($_POST['author']) || !empty($_POST['publisher']) || !empty($_POST['genre'])) {
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $genre = $_POST['genre'];
            if (!empty($_POST['author']) && !empty($_POST['publisher']) && !empty($_POST['genre'])) {
                $query =  mysql_query("select * from books natural join 
(select b.ISBN,avg(Rating) as Rating from feedback as f, books as b 
where f.ISBN = b.ISBN group by b.ISBN) as A where ISBN IN (select ISBN from authorbooks as ab 
where ab.AuthorID = (select AuthorID from authors where Name = '$author')) and Publisher = '$publisher' and Genre = '$genre'");
            } else if (!empty($_POST['author']) && !empty($_POST['publisher'])) {
                // echo $h;
                $author = $_POST['author'];
                $publisher = $_POST['publisher'];
                $query =  mysql_query("select * from books natural join 
(select b.ISBN,avg(Rating) as Rating from feedback as f, books as b 
where f.ISBN = b.ISBN group by b.ISBN) as A where ISBN IN (select ISBN from authorbooks as ab 
where ab.AuthorID = (select AuthorID from authors where Name = '$author')) and Publisher = '$publisher'
order by Rating desc");
            } else if (!empty($_POST['author']) && !empty($_POST['genre'])) {
                // echo $h;
                $author = $_POST['author'];
                $genre = $_POST['genre'];
                $query =  mysql_query("select * from books natural join 
(select b.ISBN,avg(Rating) as Rating from feedback as f, books as b 
where f.ISBN = b.ISBN group by b.ISBN) as A where ISBN IN (select ISBN from authorbooks as ab 
where ab.AuthorID = (select AuthorID from authors where Name = '$author')) and Genre = '$genre'
order by Rating desc");
            } else if (!empty($_POST['publisher']) && !empty($_POST['genre'])) {
                // echo $h;
                $publisher = $_POST['publisher'];
                $genre = $_POST['genre'];
                $query =  mysql_query("select * from books natural join 
(select b.ISBN,avg(Rating) as Rating from feedback as f, books as b 
where f.ISBN = b.ISBN group by b.ISBN) as A where Genre = '$genre' and Publisher = '$publisher'
order by Rating desc");

            } else if (!empty($_POST['publisher'])) {
                // echo "baaa";
                $publisher = $_POST['publisher'];
                $query =  mysql_query("select * from books natural join 
                            (select b.ISBN,avg(Rating) as Rating from feedback as f, books as b 
                            where f.ISBN = b.ISBN group by b.ISBN) as A where Publisher = '$publisher'
                            order by Rating desc");

            } else if (!empty($_POST['genre'])) {
                // echo $h;
                $genre = $_POST['genre'];
                $query =  mysql_query("select * from books natural join 
                (select b.ISBN,avg(Rating) as Rating from feedback as f, books as b 
                where f.ISBN = b.ISBN group by b.ISBN) as A where Genre = '$genre'
                order by Rating desc");

            } else if (!empty($_POST['author'])) {
                // echo $h;
                $author = $_POST['author'];
                $query =  mysql_query("select * from books natural join 
                        (select b.ISBN,avg(Rating) as Rating from feedback as f, books as b 
                        where f.ISBN = b.ISBN group by b.ISBN) as A where ISBN IN (select ISBN from authorbooks as ab 
                        where ab.AuthorID = (select AuthorID from authors where Name = '$author'))
                        order by Rating desc");
            }
        }
    }
    // echo $num;
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
<a href="#" class="btn btn-warning btn-lg" role="button" data-toggle="modal" data-target="#myModal-sorted">Sorted Feedback</a>

        <a href="#" class="btn btn-primary btn-lg pull-right" role="button" data-toggle="modal" data-target="#myModal-useful">Feedback Usefulness</a>
    <div class="modal fade bs-modal-sm" id="myModal-useful" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Usefulness</h4>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade active in" id="signin">
        <form class="form-horizontal" method="POST" action="rateFeedBack.php" enctype="multipart/form-data">
        <fieldset>
        <div class="control-group">
          <div class="controls">
            FeedBack ID: <input required="" type="text" class="form-control" name="feedid" placeholder="FeedBackID">
          </div>
        </div>
        <br><br>
        <div class="control-group">
          <div class="controls">
            <input type="radio" name="sort" value="Useful" id="text"> Useful<br/>
            <input type="radio" name="sort" value="Useless" id="text"> Useless
          </div>
        </div>
        <br>

        <!-- Button -->
          <label class="control-label" for="signin"></label>
          <div class="controls">
          <center><button id="signin" name="signin" class="btn btn-success">Rate</button></center>
            
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
    <div class="modal fade bs-modal-sm" id="myModal-sorted" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Sorted FeedBacks</h4>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade active in" id="signin">
        <form class="form-horizontal" method="POST" action="mfeedbacks.php" enctype="multipart/form-data">
        <fieldset>
        <div class="control-group">
          <div class="controls">
            <input required="" type="text" class="form-control" name="isbn" placeholder="ISBN">
          </div>
        </div>
        <br><br>
        <div class="control-group">
              <div class="input-group col-sm-6 col-md-offset-3">
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quantity">
                        <span class="glyphicon glyphicon-minus"></span>
                      </button>
                  </span>
                  <input type="text" name="quantity" class="form-control input-number" value="1" min="0" max="100">
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quantity">
                          <span class="glyphicon glyphicon-plus"></span>
                      </button>
                  </span>
              </div>
            <p></p>
        </div>
        <br>

        <!-- Button -->
          <label class="control-label" for="signin"></label>
          <div class="controls">
          <center><button id="signin" name="signin" class="btn btn-success">Search</button></center>
            
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
<br><br><br>
        <hr class="prettyline">

        <!-- Call to Action Well -->
        <div class="row" id="pa2">
            <div class="col-lg-12">
                <div class="well text-center">
                    Search Results!
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">
            <?php
                while ($row = mysql_fetch_assoc($query)) {
                    $is = $row['ISBN'];
                    $queryFeedbacks = mysql_query("select * from feedback where ISBN = '$is'");
                    if (mysql_num_rows($queryFeedbacks) > 0) {
                        echo '<div class="modal fade bs-modal-lg" id="myModal-',$row['ISBN'],'-feed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">',
                            '<div class="modal-dialog modal-lg">',
                                '<div class="modal-content">',
                                    '<div class="modal-header">',
                                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="text-primary fa fa-times"></i></button>',
                                        '<h4 class="modal-title" id="myModalLabel"><i class="text-muted fa fa-shopping-cart"></i><strong>',$row['Title'],'</strong></h4>',
                                    '</div>',
                                '<div class="modal-body">',
                                    '<div class="row">',
                                        '<div class="col-md-12">',
                                            '<div class="container">',
                                                '<div class="row col-md-9 custyle">',
                                                '<table class="table table-striped custab">',
                                                '<thead>',
                                                    '<tr>',
                                                        '<th>FeedBackID</th>',
                                                        '<th>By User</th>',
                                                        '<th>Rating</th>',
                                                        '<th>Comments</th>',
                                                    '</tr>',
                                                '</thead>';
                                while ($r = mysql_fetch_assoc($queryFeedbacks)) {
                                       echo     '<tr>',
                                            '<td>',$r['FeedBackID'],'</td>',
                                            '<td>',$r['UserID'],'</td>',
                                            '<td>',$r['Rating'],'</td>',
                                            '<td>',$r['Comments'],'</td>',
                                        '</tr>';
                                }
                                echo  '</table>',
                                      '</div>',
                                        '</div>',
                                    '</div>',
                                '</div>',
                            '</div>',
                            '<div class="modal-footer">',
                                '<center>',
                                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                                '</center>',
                            '</div>',
                        '</div>',
                    '</div>',
                    '</div>';
                    }
                    echo '<div class="col-md-4 column productbox">',
                            '<img src="img/ik.jpg" class="img-responsive">', //book HTML5
                            '<div class="producttitle">',$row['Title'],'</div>',
                            '<div class="productprice"><div class="pull-right">',
                                '<a href="#" class="btn btn-primary btn-sm" role="button" data-toggle="modal" data-target="#myModal-',$row['ISBN'],'">Details</a>&nbsp;',
                                '<a href="#" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target="#myModal-',$row['ISBN'],'-feed">FeedBacks</a>&nbsp;',
                                '<a href="#" class="btn btn-warning btn-sm" role="button" data-toggle="modal" data-target="#myModal-',$row['ISBN'],'-rate">Rate</a>&nbsp;',
                                '<a href="#" class="btn btn-danger btn-sm" role="button" data-toggle="modal" data-target="#myModal-',$row['ISBN'],'-buy">Buy</a>',
                            '</div><div class="pricetext">',$row['ISBN'],'</div></div>',
                        '</div>',
                        '<div class="modal fade bs-modal-lg" id="myModal-',$row['ISBN'],'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">',
			              	'<div class="modal-dialog modal-lg">',
			                	'<div class="modal-content">',
			                  		'<div class="modal-header">',
			                    		'<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="text-primary fa fa-times"></i></button>',
			                    		'<h4 class="modal-title" id="myModalLabel"><i class="text-muted fa fa-shopping-cart"></i><strong>',$row['Title'],'</strong></h4>',
			                  		'</div>',
			                  	'<div class="modal-body">',
			                    '<table class="col-md-8 ">',
			                         '<tbody>',
			                             '<tr><td class="h6"><strong>ISBN</strong></td><td></td><td class="h5">',$row['ISBN'],'</td></tr>',
			                             '<tr><td class="h6"><strong>Title</strong></td><td> </td><td class="h5">',$row['Title'],'</td></tr>',
			                             '<tr><td class="h6"><strong>Year of Publication</strong></td><td> </td><td class="h5">',$row['YearOfPublication'],'</td></tr>',
			                             '<tr><td class="h6"><strong>Genre</strong></td><td> </td><td class="h5">',$row['Genre'],'</td></tr>',
			                             '<tr><td class="h6"><strong>Format</strong></td><td> </td><td class="h5">',$row['Format'],'</td></tr>  ',
			                             '<tr><td class="h6"><strong>Publisher</strong></td><td> </td><td class="h5">',$row['Publisher'],'</td></tr>',
			                         '</tbody>',
			                    '</table>',
				                    '<div class="clearfix"></div>',
				                   		'<p class="open_info hide">',$row['Title'],'.</p>',
			                  	'</div>',
			                  	'<div class="modal-footer">',
			                    	'<div class="text-right pull-right col-md-3">Price: <br/><span class="h3 text-muted"><strong>$',$row['Price'],'</strong></span></span></div> ',
			                    	'<div class="text-right pull-right col-md-3">Copies Left: <br/><span class="h3 text-muted"><strong>',$row['NumberOfCopies'],'</strong></span></div>',
			                	'</div>',
			              	'</div>',
			            '</div>',
			            '</div>',
                        '<div class="modal fade bs-modal-lg" id="myModal-',$row['ISBN'],'-rate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">',
                            '<div class="modal-dialog modal-lg">',
                                '<div class="modal-content">',
                                    '<div class="modal-header">',
                                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="text-primary fa fa-times"></i></button>',
                                        '<h4 class="modal-title" id="myModalLabel"><i class="text-muted fa fa-shopping-cart"></i><strong>',$row['Title'],'</strong></h4>',
                                    '</div>',
                                '<div class="modal-body">',
                                    '<div class="row">',
                                        '<div class="col-md-12">',
                                          '<form class="form-horizontal" method="POST" action="rateBook.php" enctype="multipart/form-data">',
                                            '<fieldset>',
                                              '<legend>ISBN: <input type="text" value="',$row['ISBN'],'" name="book"></legend>',
                                              '<div class="form-group">',
                                                '<label class="col-sm-2 control-label" for="textinput">Comment</label>',
                                                '<div class="col-sm-10">',
                                                  '<input type="text" name="comment" id="first_name" class="form-control input-lg" placeholder="Optional" tabindex="1">',
                                                '</div>',
                                              '</div>',
                                                '<div class="form-group">',
                                                      '<div class="input-group col-sm-2 col-sm-offset-5">',
                                                          '<span class="input-group-btn">',
                                                              '<button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quantity">',
                                                                '<span class="glyphicon glyphicon-minus"></span>',
                                                              '</button>',
                                                          '</span>',
                                                          '<input type="text" name="quantity" class="form-control input-number" value="1" min="0" max="10">',
                                                          '<span class="input-group-btn">',
                                                              '<button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quantity">',
                                                                  '<span class="glyphicon glyphicon-plus"></span>',
                                                              '</button>',
                                                          '</span>',
                                                      '</div>',
                                                    '<p></p>',
                                                '</div>',

                                              '<div class="form-group">',
                                                '<div class="col-sm-offset-2 col-sm-10">',
                                                  '<div class="pull-right">',
                                                    '<button type="submit" class="btn btn-primary">Save</button>',
                                                  '</div>',
                                                '</div>',
                                              '</div>',
                                            '</fieldset>',
                                          '</form>',
                                        '</div>',
                                    '</div>',
                                '</div>',
                                '<div class="modal-footer">',
                                    '<center>',
                                        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                                    '</center>',
                                '</div>',
                            '</div>',
                        '</div>',
                        '</div>',
                        '<div class="modal fade bs-modal-lg" id="myModal-',$row['ISBN'],'-buy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">',
                            '<div class="modal-dialog modal-lg">', 
                                    '<div class="container">',
                                        '<div class="row">',
                                            '<div class="well col-md-5 col-md-offset-2">',
                                                '<div class="row" form-group>',
                                                '<form class="form-horizontal" method="POST" action="orderNow.php" enctype="multipart/form-data">',                                               
                                                    '<div class="col-xs-6 col-sm-6 col-md-6 form-group">',
                                                    '<p>',
                                                    '<em>Book ISBN: <input type="text" value="',$row['ISBN'],'" name="book"></em>',
                                                    '</p>',
                                                    '</div>',
                                                    '<div class="col-xs-6 col-sm-6 col-md-6 text-right">',
                                                        '<p>',
                                                            '<em>Date: ',date("Y-m-d"),'</em>',
                                                        '</p>',
                                                    '</div>',
                                                '</div>',
                                                '<div class="row">',
                                                    '<div class="text-center">',
                                                        '<h1>Receipt</h1>',
                                                    '</div>',
                                                    '</span>',
                                                    '<table class="table table-hover">',
                                                        '<thead>',
                                                            '<tr>',
                                                                '<th>Product</th>',
                                                                '<th class="text-center">Price</th>',
                                                            '</tr>',
                                                        '</thead>',
                                                        '<tbody>',
                                                            '<tr>',
                                                                '<td class="col-md-12"><em>',$row['Title'],'</em></h4></td>',
                                                                '<td class="col-md-1 text-center">$',$row['Price'],'</td>',
                                                            '</tr>',
                                                            '<tr>',
                                                                '<td class="text-right"><h4><strong>Total: </strong></h4></td>',
                                                                '<td class="text-center text-danger"><h4><strong>$',$row['Price'],'</strong></h4></td>',
                                                            '</tr>',
                                                        '</tbody>',
                                                    '</table>',
                                                    '<center>',
                                                    '<button type="submit" class="btn btn-success btn-lg form-control">',
                                                        'Order Now<span class="glyphicon glyphicon-chevron-right"></span>',
                                                    '</button>',
                                                    '</form>',
                                                    '</center>',
                                                    '<br>',
                                                    '<center>',
                                                    '<button type="button" class="btn btn-default" data-dismiss="modal">',
                                                        'Close',
                                                    '</button>',
                                                    '</center>',
                                                    '</td>',
                                                '</div>',
                                            '</div>',
                                        '</div>',
                                     '</div>',
                                 '</div>',
                         '</div>';
                }
                mysql_free_result($query);
            ?>
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
