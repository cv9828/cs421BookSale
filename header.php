<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Book List</title>

        <!-- Bootstrap Core CSS -->
        <!--<link href="assets/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->

        
	
        <!-- Custom Fonts -->
        <!--<link href="assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>-->
        <script src="https://use.fontawesome.com/13f2bf407a.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
        <!--<script src="assets/validator.js" type="text/javascript"></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/validate.js/0.11.1/validate.min.js"></script>

  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Theme CSS -->
        <link href="style.css" rel="stylesheet" type="text/css"/>
        <link href="app.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <script src="sidebar.js"></script>

    </head>

    <body id="page-top" class="index">
        <div id="skipnav"><a href="#maincontent">Skip to main content</a></div>
        <!-- Navigation -->



<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.php">Book List</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="page-scroll">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="page-scroll">
                            <a href="listbook.php">List books</a>
                        </li>
                        <li class="page-scroll">
                            <a href="listbook.php?filter=buy">Requests for books</a>
                        </li>
                        <li class="page-scroll">
                            <a href="listbook.php?filter=sell">Books for sale</a>
                        </li>

                        <?php if (isset($_SESSION["CurrentUser"]) && !empty($_SESSION["CurrentUser"])) { ?>
                            <li class="page-scroll">
                                <a href="bid.php">Bids/Offers</a>
                            </li>
                            <li class="page-scroll">
                                <a href="messages.php"><i class="fa fa-telegram"></i>Messages</a>
                            </li>
                            <li class="page-scroll">
                                <a><i class='fa fa-dashboard'></i><input class="dash" type="submit" value ="Dashboard" onclick="nav()"></a>
                            </li>

                            <li class="page-scroll">
                                <a href="logout.php"> <i class="fa fa-sign-out"></i> LogOut</a>
                            </li>
                        <?php } else { ?>
                            <li class="page-scroll">
                                <a href="register.php" ><i class="fa fa-unlock-alt"></i>Register</a>
                            </li>
                            <li class="page-scroll">
                                <a href="login.php"> <i class="fa fa-sign-in"></i> Login</a>

                            </li>


                        <?php } ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>


        
        <div class="container main-content">
            <?php if (isset($_SESSION["CurrentUser"]) && !empty($_SESSION["CurrentUser"])) {?>
            <div id="spacer"></div>
            
            <i onclick="nav()" class="fa fa-dashboard" style="font-size: 50px;right:0;z-index: 100;position:fixed"></i>
            <div id="mySidenav" class="sidenav" style="margin-top: 80px;">
            <a href="javascript:void(0)" class="closebtn" onclick="nav()">&times;</a>
			<a href="addbookforsellorbuy.php">Add book for sell or buy</a>
            <a href="addbook.php">Add book </a>
			<a href="addauthor.php" >Add author</a>
            <a href="addcourse.php" >Add course</a>
            <a href="mylist.php">My list (BUY & SELL)</a>
            <a href="mylist.php?type=buy">My list (BUY)</a>
            <a href="mylist.php?type=sell">My list (SELL)</a>
            </div>
            <?php }?>
            