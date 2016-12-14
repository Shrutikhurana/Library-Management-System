<?php
session_start();
if(!isset($_SESSION["username"]))
{
	header("Location:http://localhost/login1.php");
	exit;
}
if(isset($_SESSION["username"]) && $_SESSION["username"]=="student")
{
	header("Location:http://localhost/login1.php");
	exit;
}
if(!isset($_SESSION["visited_borrow"]))
$_SESSION["bbookerr"]=$_SESSION["bmemiderr"]="";
?>
<!DOCTYPE html>

<html lang="en">


  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="favicon.ico" rel="icon">    

    <title>LIBRARY MANAGEMENT SYSTEM</title>

    <!-- Bootstrap -->
   
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="starter-template.css" rel="stylesheet">
    <link href="theme.css" rel="stylesheet">    

    <script src="js/ie-emulation-modes-warning.js"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
<style>
.error {color: #FF0000;}
</style>

  </head>


  <body>

<!--CODE AFTER THIS-->
<!--
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
            <li class="active"><a href="dbms.html">Home</a></li>
            <li><a href="member.html">Back</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
-->
<br><br><br>


<form action="borrow.php" method="post">

<center><h3><b><u>Please enter the details for the book to be borrowed</h3></b></u></center>

<br><br>
<center><p class="text-danger">Enter the bookID</p>
<input type="text" name="bookid" placeholder="BOOK ID">
<span class="error"><?php echo $_SESSION["bbookerr"]; ?></span>
<!-- bookid, title, groupid, available, maxbook, price to be displayed using php-->

<br><br>
<p class="text-danger">Enter the member ID</p>
<input type="text" name="memid" placeholder="MEMBER ID">
<span class="error"><?php echo $_SESSION["bmemiderr"]; ?></span>

<!--memid, sname, memdate, expiry, memtype, limit_book to be displayed using php-->


<br><br><br>



<!--if borrow is possible perform the appropriate changes in the table--> 
<!-- borrow.php should display bookid, title, groupid, available, maxbook, price, memid, sname, memdate, expiry, memtype, limit_book after book issue-->

<button type="submit" class="btn btn-warning btn-lg">Borrow book</button>
</center>


</form>

<br><br><br><br>


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



<!--CODE BEFORE THIS-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>

  </body>



</html>