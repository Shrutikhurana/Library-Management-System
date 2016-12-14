<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["username"]!="student")
{
                 header("Location:http://localhost/login1.php");
	exit;	
}
$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
{
	 die("Connection failed: " . mysqli_connect_error());
}
$_SESSION["smemerr"]="";
$_SESSION["visited_student"]=1;
if(empty($_POST["memberid"]))
{
	$_SESSION["smemerr"]="enter the  memberid";
	     header("Location:http://localhost/student1.php");
 	    exit;

}
$sql= "select  sname,memdate,expiry,limit_book,address from student where memid=".$_POST["memberid"] ;
$result=$conn->query( $sql);
echo "<center>";
echo " <th><br><br><br>ACOUNT DETAILS</th>";   	
if ($result->num_rows > 0)
 {
	
   	 echo "<table border='1' ><tr><th>NAME</th><th>MEMDATE</th><th>EXPIRY</th><th>LIMIT_BOOK</th><th>ADDRESS</th></tr>";
   	 // output data of each row
  	  while($row = $result->fetch_assoc()) {
       	 echo "<tr ><td>".$row["sname"]."</td><td>".$row["memdate"]."</td><td>".$row["expiry"]."</td><td>".$row["limit_book"]."</td><td>".$row["address"]."</td></tr>";
    }
    echo "<br><br></table>";
}
 else
 {
	$_SESSION["smemerr"]="enter the valid  memberid";
	     header("Location:http://localhost/student1.php");
 	    exit;

 }
$sql="select title,issuedate,returndate,fine from borrowedby,book where book.bookid=borrowedby.bookid and memid=".$_POST["memberid"];
 $result=$conn->query( $sql);
if ($result->num_rows > 0)
 {
	echo "<th><br><br><br>BOOKS ISSUED</th>";
   	 echo "<table border='1' ><tr><th>TITLE</th><th>ISSUEDATE</th><th>RETURNDATE</th><th>FINE</th></tr>";
   	 // output data of each row
  	  while($row = $result->fetch_assoc()) {
       	 echo "<tr ><td>".$row["title"]."</td><td>".$row["issuedate"]."</td><td>".$row["returndate"]."</td><td>".$row["fine"]."</td></tr>";
    }
    echo "<br><br></table>";
}
else
{
	echo "<th><br><br><br>BOOKS ISSUED</th>";
   	echo"<b><u><br><br><br>NO BOOKS ISSUED</b></u>";
}
echo "</center>";
$conn->close();
?>