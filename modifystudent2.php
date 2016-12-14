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
  $memid=$_SESSION["memid"];
  $sname=$_POST["sname"];
  $memdate=$_POST["memdate"];
  $expiry=$_POST["expiry"];
  $memtype=$_POST["memtype"];
  $limit_book=$_POST["limit_book"];
  $address=$_POST["address"];
$_SESSION["msnamerr"]=$_SESSION["msexperr"]=$_SESSION["msmemdaterr"]=$_SESSION["mslimiterr"]=$_SESSION["msmemtyperr"]=$_SESSION["msaddresserr"]="";                         
$_SESSION["visited_modifystudent2"]=1;
$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}

//check required fields

if(empty($_POST["sname"]))
{
	$_SESSION["msnamerr"]="NAME IS REQUIRED";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}
if(empty($_POST["memdate"]))
{
	$_SESSION["msmemdaterr"]="MEMBERSHIP DATE IS REQUIRED";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}
if(empty($_POST["expiry"]))
{
	$_SESSION["msexperr"]="EXPIRY DATE IS REQUIRED";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}
if(empty($_POST["memtype"]))
{
	$_SESSION["msmemtyperr"]="MEMBERSHIP TYPE  IS REQUIRED";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}
if(empty($_POST["address"]))
{
	$_SESSION["msaddresserr"]="ADDRESS  IS REQUIRED";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}

//MEMBERSHIP AND EXPIRY CHECK

$sql="select * from student  where memid=".$_SESSION["memid"]." and datediff(curdate(),'".$expiry."')<0";
$result=$conn->query($sql);
if($result->num_rows>0)
{
}
else
{
	$_SESSION["msexperr"]="MEMBERSHIp IS EXPIRED ";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}
//check limit_book
if($limit_book-$_SESSION["old_limit"] <0)
{
	$_SESSION["mslimiterr"]="LIMIT OF BOOKS CANT BE DECREASED";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}
//check type
if($memtype!="student" && $memtype!="teacher")
{
	$_SESSION["msmemtyperr"]="MEMBERSHIP TYPE  CAN EITHER BE STUDENT OR TEACHER";
	header("Location:http://localhost/modifystudent1.php");
	exit;
}
// CHECK NAME
if (preg_match('/[^A-Za-z .]/', $sname))
{
    $_SESSION["msnamerr"]="NAME CANT HAVE SPECIAL CHARACTER";
     header("Location:http://localhost/modifystudent1.php");
    exit;
}
$sql = "UPDATE student SET sname='$sname' ,memdate='$memdate',expiry='$expiry',memtype='$memtype',limit_book='$limit_book',address='$address' WHERE memid='$memid'";
  if ($conn->query($sql) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$result = $conn->query($sql);


$sql = "SELECT memid,sname,memdate,expiry,memtype,limit_book,address FROM student";
$result = $conn->query($sql);

echo "<center>";
if ($result->num_rows > 0)
 {	
	echo "<th><h3><u>MEMBER DETAILS</th></h3></u>";
   	 echo "<table border='1' ><tr><th>MEMID</th><th>NAME</th><th>MEMDATE</th><th>EXPIRY</th><th>MEMTYPE</th><th>LIMIT_BOOK</th><th>ADDRESS</th></tr>";
  	  while($row = $result->fetch_assoc())
	 {
       		 echo "<tr><td>".$row["memid"]."</td><td>".$row["sname"]."</td><td>".$row["memdate"]."</td><td>".$row["expiry"]."<td>".$row["memtype"]."</td></td><td>".$row["limit_book"]."</td><td>".$row["address"]."</td></tr>";
	    }
    echo "</table>";
}
 else
 {
    echo "0 results";
}
echo "</center>";
?>