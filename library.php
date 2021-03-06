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
if(isset($_SESSION["visited"]))
unset($_SESSION["visited"]);
if(isset($_SESSION["visited_modifybook1"]))
unset($_SESSION["visited_modifybook1"]);
if(isset($_SESSION["visited_deletebook"]))
unset($_SESSION["visited_deletebook"]);
if(isset($_SESSION["visited_return"]))
unset($_SESSION["visited_return"]);
if(isset($_SESSION["visited_borrow"]))
unset($_SESSION["visited_borrow"]);
if(isset($_SESSION["visited_modifybook2"]))
unset($_SESSION["visited_modifybook2"]);
if(isset($_SESSION["visited_add"]))
unset($_SESSION["visited_add"]);
if(isset($_SESSION["visited_deletestudent"]))
unset($_SESSION["visited_deletestudent"]);
if(isset($_SESSION["visited_modifystudent2"]))
unset($_SESSION["visited_modifystudent2"]);
if(isset($_SESSION["visited_modifystudent1"]))
unset($_SESSION["visited_modifystudent1"]);
if(isset($_SESSION["visited_password"]))
unset($_SESSION["visited_password"]);

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
  </head>


  <body>

<!--CODE AFTER THIS-->

 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
        </div>
        <div id="navbar" class="collapse navbar-collapse">

          <ul class="nav navbar-nav">

            <li class="active"><a href="dbms.html">Home</a></li>
            <li><a href="book.html">Refresh</a></li>
            <li><a href="addstudent1.php">StudentAdd</a></li>
            <li><a href="modifystudent.php">StudentModify</a></li>
            <li><a href="deletestudent1.php">StudentDelete</a></li>
            <li><a href="addbook2.php">BookAdd</a></li>
            <li><a href="modifybook.php">BookModify</a></li>
            <li><a href="deletebook1.php">BookDelete</a></li>
            <li><a href="borrow1.php">IssueBook</a></li>
            <li><a href="return1.php">ReturnBook</a></li>
            <li><a href="information1.html">Information</a></li>

           </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>
<br>
<div class="page-header">
 <!--       <h1>Carousel</h1>  -->
      </div>
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          <li data-target="#carousel-example-generic" data-slide-to="3"></li>
          <li data-target="#carousel-example-generic" data-slide-to="4"></li>              
       </ol>
  
       <div class="carousel-inner" role="listbox">
          <div class="item active">
            <center><img src="i1.jpg" width=1100 height=300 data-src="holder.js/1140x500/auto/#777:#555/text:First slide" alt="First slide"></center>                
         </div>
          <div class="item">
            <center><img src="i2.jpg" width=1100 height=300 data-src="holder.js/1140x500/auto/#666:#444/text:Second slide" alt="Second slide"></center>
          </div>
          <div class="item">
            <center><img src="i3.jpg" width=1100 height=300 data-src="holder.js/1140x500/auto/#555:#333/text:Third slide" alt="Third slide"></center>
          </div>
          <div class="item">
            <center><img src="i4.jpg" width=1100 height=300 data-src="holder.js/1140x500/auto/#444:#222/text:Third slide" alt="Third slide"></center>
          </div>
          <div class="item">
            <center><img src="i5.jpg" width=1100 height=300 data-src="holder.js/1140x500/auto/#333:#111/text:Third slide" alt="Third slide"></center>
          </div>
          

      </div>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
</center>
      </div>


    </div> <!-- /container -->
<br><br>
<center>
<a href="changepassword1.php">
<button type="submit" class="btn btn-warning btn-lg">CHANGE PASSWORD</button></a>
<a href="logout.php">
<button type="submit" class="btn btn-warning btn-lg">LOG OUT</button>
</center>
</a>
<br><br>
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