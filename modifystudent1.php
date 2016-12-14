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
if(!isset($_SESSION["visited_modifystudent2"]))
{
$_SESSION["msnamerr"]=$_SESSION["msexperr"]=$_SESSION["msmemdaterr"]=$_SESSION["mslimiterr"]=$_SESSION["msmemtyperr"]=$_SESSION["msaddresserr"]="";
}
$_SESSION["msmemerr"]="";
$_SESSION["visited_modifystudent1"]=1;
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
            <li><a href="dbms.html">Back</a></li>            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<br><br><br>
<?php

//ckeck memid
if(!isset($_SESSION["visited_modifystudent2"]))
{
	if(empty($_POST["memid"]))
	{
		$_SESSION["msmemerr"]="MEMBER ID IS REQUIRED";
		header("Location:http://localhost/modifystudent.php");
    	 	exit;
	}
	$_SESSION["memid"]=$_POST["memid"]; 
}
$memid=$_SESSION["memid"];
$servername = "localhost";
	$user = "root";
	$password = "";
	$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT memid,sname,memdate,expiry,memtype,limit_book,address FROM student where memid=".$_SESSION["memid"];
$result = $conn->query($sql);
if ($conn->query($sql) == TRUE)
{
}
 if ($result->num_rows > 0)
 {
  	  while($row = $result->fetch_assoc()) 
	{       
                             $sname=$row["sname"];
                             $memdate=$row["memdate"];
                             $expiry=$row["expiry"];
                             $memtype=$row["memtype"];
                             $limit_book=$row["limit_book"];
                             $address=$row["address"];
	           $_SESSION["old_limit"]=$limit_book;
                  }   
 }
else
{
$_SESSION["msmemerr"]="INCORRECT MEMBER ID";
     header("Location:http://localhost/modifystudent.php");
     exit;
}
?>
<form action="modifystudent2.php" method="post">


 <div class="panel panel-warning">
            <div class="panel-heading">
             <center> <h3 class="panel-title">Please enter only those details of the student that are to be modified</h3></center>
            </div>
 </div>
<center>
<p class="text-danger">Enter the student name</p>
<input type="text" name="sname" placeholder="Student name" value="<?php echo $sname ?>">
<span class="error"><?php echo $_SESSION["msnamerr"]; ?></span>
<br><br>

<p class="text-danger">Enter the membership date</p>
<input type="date" name="memdate"  value="<?php echo $memdate ?>">
<span class="error"><?php echo $_SESSION["msmemdaterr"]; ?></span>
<br><br>
<p class="text-danger">Enter the Expiry Date</p>
<input type="date" name="expiry"  value="<?php echo $expiry ?>">
<span class="error"><?php echo $_SESSION["msexperr"]; ?></span>
<br><br>
<p class="text-danger">Enter the Membership Type</p>
<input type="text" name="memtype" placeholder="Memberships Type" value="<?php echo $memtype ?>">
<span class="error" ><?php echo $_SESSION["msmemtyperr"]; ?></span>
<br><br>
<p class="text-danger">Enter the Book Limit</p>
<input type="text" name="limit_book" placeholder="Book Limit" value="<?php echo $limit_book ?>">
<span class="error"><?php echo $_SESSION["mslimiterr"]; ?></span>
<br><br>
<p class="text-danger">Enter the student address</p>
<input type="text" name="address" placeholder="Address" value="<?php echo $address ?>">
<span class="error"><?php echo $_SESSION["msaddresserr"]; ?></span>
</center>
<br><br><br>

<center>
<button type="submit" class="btn btn-warning btn-lg">Modify Student</button>
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