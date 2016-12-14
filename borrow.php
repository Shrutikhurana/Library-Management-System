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
$_SESSION["bbookerr"]=$_SESSION["bmemiderr"]="";
$_SESSION["visited_borrow"]=1;
$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}
if (empty($_POST["bookid"]))
 {
     $_SESSION["bbookerr"] = "enter a book to be issued";
     header("Location:http://localhost/borrow1.php");
     exit;
   }
if (empty($_POST["memid"]))
 {
     $_SESSION["bmemiderr"] = "enter a memberid";
     header("Location:http://localhost/borrow1.php");
     exit;
   }

//check memid
$sql="select limit_book from student where memid=".$_POST["memid"];
$result=$conn->query($sql);
if($result->num_rows >0)
{
	 while($row = $result->fetch_assoc())
	 {
		$limit_book=$row["limit_book"];
	}	
}
else
{
$_SESSION["bmemiderr"]="enter a valid memberid";
 header("Location:http://localhost/borrow1.php");
     exit; 
}
if($limit_book ==0)
{
$_SESSION["bmemiderr"]="can't exceed limit of 2";
 header("Location:http://localhost/borrow1.php");
     exit; 
}
//valid bookid
$sql="select * from book where bookid=".$_POST["bookid"];
$result=$conn->query($sql);
if($result->num_rows ==0)
{
$_SESSION["bbookerr"]="no such book";
 header("Location:http://localhost/borrow1.php");
     exit; 

}
// check book in the borrowedby table
$sql="select * from borrowedby where bookid=".$_POST["bookid"];
$result=$conn->query($sql);
if ( $result->num_rows  == 1)
{
 $_SESSION["bbookerr"]="book is already issued";
 header("Location:http://localhost/borrow1.php");
     exit; 	
}
//decrease limit
$sql="update student set limit_book=limit_book-1 where memid=".$_POST["memid"];
if($conn->query($sql)==true)
{
	echo "limit updated";
}
//decrease available
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

$sql2="update book set available=available-1 where groupid='".$groupid."'";
if($conn->query($sql2)==true)
{
	//echo "available updated";
}

//insert into borrowed
$sql="insert into borrowedby values (curdate(),DATE_ADD(curdate(),interval 7 day),0,".$_POST["bookid"].",".$_POST["memid"].")";
echo $sql;
if($conn->query($sql)==true)
{}//echo "successful in borrowedby";
//display of student account
echo "<center><b><u><h1>STUDENT ACCOUNT</h1></u></b></center>";
$sql="select * from borrowedby,student,book where  book.bookid=borrowedby.bookid and student.memid=borrowedby.memid and student.memid=".$_POST["memid"];
$result=$conn->query($sql);
echo "<br><br><br>";
echo "<h2><center><table border=1><tr><th>NAME</th><th>TITLE</th><th>ISSUE_DATE</th><th>RETURN_DATE</th><th>FINE</th></tr></h2>";
if ( $result->num_rows  > 0)
{
 while($row = $result->fetch_assoc())
  {
	echo "<tr><td>".$row["sname"]."</td><td>".$row["title"]."</td><td>".$row["issuedate"]."</td><td>".$row["returndate"]."</td><td>".$row["fine"]."</td></tr>";
  }
}
else
{
echo "no such member";
}
echo "</table></center>";	
?>