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
          <a class="navbar-brand">LIBRARY</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="dbms.html">Home</a></li>
            <li><a href="modifybook.php">Back</a></li>            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<?php
$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}
$_SESSION["titleerr"]=$_SESSION["autherr"]=$_SESSION["puberr"]="";
$_SESSION["visited_modifybook1"]=1;
if(!isset($_SESSION["visited_modifybook2"]))
{
$_SESSION["err"]=$_SESSION["puberr1"]=$_SESSION["autherr1"]=$_SESSION["priceerr"]=$_SESSION["maxerr"]=$_SESSION["grouperr"]=$_SESSION["titleerr1"]=$_SESSION["rackerr"]=$_SESSION["rowerr"]=$_SESSION["cerr"]="";
 
//for bookid as input
if (empty($_POST["title"]))
 {
     $_SESSION["titleerr"] = "title is required";
     header("Location:http://localhost/modifybook.php");
     exit;
   }
if (empty($_POST["autname"]))
 {
     $_SESSION["autherr"] = "author is required";
     header("Location:http://localhost/modifybook.php");
     exit;
   }
if (empty($_POST["pubname"]))
 {
     $_SESSION["puberr"] = "publisher is required";
     header("Location:http://localhost/modifybook.php");
     exit;
   }

$sql="select authid from author where autname='".$_POST["autname"]."'";
$result=$conn->query( $sql);
if ($result->num_rows > 0)
 {	
 	 // output data of each row
  	  while($row = $result->fetch_assoc())
	 {
		$authid=$row["authid"];
	}
}
else
{
     $_SESSION["autherr"] = "no such author as '".$_POST["autname"]."'  exists in database";
     header("Location:http://localhost/modifybook.php");
     exit;

} 
//$sql="select pubid from publisher where name='".$_POST["pubname"]."'";
$sql="select pubid from publisher where name='".$_POST["pubname"]."'";
$result=$conn->query( $sql);
if ($result->num_rows > 0)
 {	
 	 // output data of each row
  	  while($row = $result->fetch_assoc())
	 {
		$pubid=$row["pubid"];
	}
} 
else
{
     $_SESSION["puberr"] = "no such publisher as ".$_POST["pubname"]."exists in database";
     header("Location:http://localhost/modifybook.php");
     exit;
} 

$sql="select book.bookid from book,written,published where book.bookid=written.bookid and book.bookid=published.bookid and authid=".$authid." and pubid=".$pubid." and title='".$_POST["title"]."' group by groupid";
$result=$conn->query( $sql);
if ($result->num_rows > 0)
 {	
 	 // output data of each row
  	  while($row = $result->fetch_assoc())
	 {
		$_SESSION["bookid"]=$row["bookid"];
	}
}
else
{
     $_SESSION["titleerr"] = "no such book as ".$_POST["title"]."exists with publisher as ".$_POST["pubname"]." and author as ".$_POST["autname"]."  in database";
     header("Location:http://localhost/modifybook.php");
     exit;

} 


//$_SESSION["bookid"]=$_POST["bookid"];
}
$sql= "select * from book where bookid=".$_SESSION["bookid"] ;
$result=$conn->query( $sql);
if ($result->num_rows > 0)
 {	
 	 // output data of each row
  	  while($row = $result->fetch_assoc())
	 {
		$title=$row["title"];
		$max=$row["maxbook"];
		$_SESSION["oldmax"]=$max;
		$rackno=$row["rackno"];
		$cno=$row["colmnno"];
		$rowno=$row["rowno"];
		$price=$row["price"];
		$_SESSION["oldavailable"]=$row["available"];
	}
}
else
{
	$_SESSION["iderr"]="no such bookid exists";
	header("Location:http://localhost/modifybook.php");
	exit;
}
$sql1="select pubid from published where bookid=".$_SESSION["bookid"];
$sql2="select name,address from publisher where pubid=(".$sql1.")";
$result=$conn->query($sql2);
if ($result->num_rows > 0)
 {	
  	  while($row = $result->fetch_assoc())
	{
		$pubname=$row["name"];
		$address=$row["address"];		
	}
}
$sql1="select authid from written where bookid=".$_SESSION["bookid"];
$sql2="select autname from author where authid in(".$sql1.")";
$result=$conn->query($sql2);
if ($result->num_rows > 0)
 {	
  	  while($row = $result->fetch_assoc())
	{
		$autname=$row["autname"];		
	}
}

?>
<form method="post" action="modifybook2sd.php" >

<center>
<br><br><br>
 <div class="panel panel-warning">
            <div class="panel-heading">
             <center> <h3 class="panel-title">Please enter only those details of the book that are to be modified</h3></center>
            </div>
 </div>

<br>
<p class="text-danger">Enter the book title</p>
<input type="text" name="title" value="<?php echo "$title"; ?>" placeholder="Title">
<span class="error"><?php echo $_SESSION["titleerr1"]; ?></span>

<br><br>

<p class="text-danger">Enter the MaxBooks</p>
<input type="text" name="max" value="<?php echo "$max"; ?>"  placeholder="Maxbooks">
<span class="error"><?php echo $_SESSION["maxerr"]; ?></span>

<br><br>
<p class="text-danger">Enter the Book price</p>
<input type="text" name="price" value="<?php echo "$price"; ?>"  placeholder="Book price">
<span class="error"><?php echo $_SESSION["priceerr"]; ?></span>

<br><br>
<p class="text-danger">Enter the column number</p>
<input type="text" name="cno" value="<?php echo "$cno"; ?>"  placeholder="Column number">
<span class="error"><?php echo $_SESSION["cerr"]; ?></span>

<br><br>
<p class="text-danger">Enter the row number</p>
<input type="text" name="rowno" value="<?php echo "$rowno"; ?>"  placeholder="Row number">
<span class="error"><?php echo $_SESSION["rowerr"]; ?></span>

<br><br>
<p class="text-danger">Enter the rack number</p>
<input type="text" name="rackno" value="<?php echo "$rackno"; ?>" placeholder="Rack number">
<span class="error"><?php echo $_SESSION["rackerr"]; ?></span>

<br><br>

<p class="text-danger">Enter the author name</p>
<input type="text" name="autname" value="<?php echo"$autname"; ?>" placeholder="Author name">
<span class="error"><?php echo $_SESSION["autherr1"]; ?></span>

<br><br>
<p class="text-danger">Enter the publisher name</p>
<input type="text" name="pubname" value="<?php echo "$pubname"; ?>" placeholder="Publisher name">
<span class="error"><?php echo $_SESSION["puberr1"]; ?></span>

<br><br>
<p class="text-danger">Enter the publisher address</p>
<input type="text" name="address" value="<?php echo "$address"; ?>" placeholder="publisher address">


<br><br><br>

<button type="submit" class="btn btn-warning btn-lg">Modify book</button>
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