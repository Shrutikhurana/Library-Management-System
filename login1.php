<?php
session_start();
if(isset($_SESSION["username"]))
{
	if($_SESSION["username"]=="student")
	{
		header("Location:http://localhost/member.php");
		exit;
	}
	else
	{
		header("Location:http://localhost/library.php");
		exit;	
	}
}
if(!isset($_SESSION["visited_login"]))
$_SESSION["usererr"]=$_SESSION["passerr"]="";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
.error {color: #FF0000;}
</style>

  </head>

  <body>

 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">LIBRARY</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="dbms.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<center>
    <div class="container">

      <form class="form-signin" role="form"  action="1.php" method="post">
        <h1 class="form-signin-heading">Please sign in</h1>

        <input type="text" width="1500" name="username"  placeholder="username">
        <span class="error"><?php echo $_SESSION["usererr"]; ?> </span>
	<br><br>
        <input type="password" width="1500" name="password" placeholder="Password">
        <span class="error"><?php echo $_SESSION["passerr"]; ?></span>
	<div class="checkbox">
          <label>
            <input type="checkbox" width="2000" value="remember-me"> Remember me
          </label>
        </div>
        <button type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->


<br>

<!--Suhani put the authentication code to differentiate between librarian and student after this line-->






<!--Write code before this line-->

<br>

 <div class="panel panel-warning">
            <div class="panel-heading">
             <center> <h3 class="panel-title">LIBRARY MANAGEMENT SYSTEM</h3></center>
            </div>
            <div class="panel-body">
             <center> LIBRARY IS THE HOSPITAL OF THE MIND </center>
            </div>
          </div>
        </div><!-- /.col-sm-4 -->
      </div>



    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</center>

  </body>
</html>
