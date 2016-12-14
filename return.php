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
$_SESSION["visited_return"]=1;
$_SESSION["rtitleerr"]="";
$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}
$sql="select fine from borrowedby where bookid=".$_POST["bookid"];
$result=$conn->query($sql);
if($result->num_rows >0)
{
	 while($row = $result->fetch_assoc())
	 {	
		echo "<h3><center>FINE DETAILS</center></h3>";
		$fine=$row["fine"];
		echo "<center><br><br><br><th><b><u>FINE IS ".$fine."</th></b></u></center>";	
	}	
}
else
{
$_SESSION["rtitleerr"]="enter a valid bookid";
 header("Location:http://localhost/return1.php");
     exit; 
}
//update limit
$sql1="select memid from borrowedby where bookid=".$_POST["bookid"];
$sql2="update student set limit_book=limit_book+1 where memid=(".$sql1.")";
if($conn->query($sql2)==true)
{
	echo "limit updated";
}
$result=$conn->query($sql1);
  while($row = $result->fetch_assoc())
{
	$memid=$row["memid"];
}
//delete from borrowedby
$sql="delete from borrowedby where bookid=".$_POST["bookid"];
if($conn->query($sql)==true)
{
	echo "deleted from borrowed";
}
//update available
$sql1="select groupid from book where bookid=".$_POST["bookid"];
$result=$conn->query($sql1);
if ($result->num_rows > 0)
 {	
 	 // output data of each row
  	  while($row = $result->fetch_assoc())
	{
		$groupid=$row['groupid'];
	}
}

$sql2="update book set available=available+1 where groupid='".$groupid."'";

if($conn->query($sql2)==true)
{
//	echo "available updated";
}
//display of student account
echo "<center><b><u><h1>STUDENT ACCOUNT</h1></u></b></center>";
$sql="select * from borrowedby,student,book where  book.bookid=borrowedby.bookid and student.memid=borrowedby.memid and student.memid=".$memid;
$result=$conn->query($sql);
echo "<br><br><br>";

if ( $result->num_rows  > 0)
{
	echo "<h2><center><table border=1><tr><th>NAME</th><th>TITLE</th><th>ISSUE_DATE</th><th>RETURN_DATE</th><th>FINE</th></tr></h2>";

 	while($row = $result->fetch_assoc())
 	 {
		echo "<tr><td>".$row["sname"]."</td><td>".$row["title"]."</td><td>".$row["issuedate"]."</td><td>".$row["returndate"]."</td><td>".$row["fine"]."</td></tr>";
	  }
echo "</table></center>";	

}
else
{
$sql="select sname from student where memid=".$memid;
$result=$conn->query($sql);
 while($row = $result->fetch_assoc())
{
	$sname=$row["sname"];
}
echo "<center>no books in the account of  ".$sname." </center>";
}

?>