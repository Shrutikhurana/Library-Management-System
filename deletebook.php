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
$servername="localhost";
$user="root";
$password="";
$_SESSION["visited_deletebook"]=1;
$_SESSION["dbookiderr"]="";
//required fields
if (empty($_POST["bookid"]))
 {
     $_SESSION["dbookiderr"] = "bookid is required";
     header("Location:http://localhost/deletebook1.php");
     exit;
   }

$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}

//valid bookid

echo "<center>";
echo " <th><h1><u><br><br><br>BOOK DETAILS</th></u></h1>";
$sql="select * from book where bookid=".$_POST["bookid"];
$result=$conn->query($sql);   
if ($result->num_rows > 0)
 {
	echo "<table border='1' ><tr><th>BOOKID</th><th>TITLE</th><th>GROUPID</th><th>AVAILABLE</th><th>MAX </th><th>PRICE</th><th>COLMNNO </th><th>ROWNO</th><th>RACKNO</th></tr>";  	 
   	  while($row = $result->fetch_assoc())
	 {
    		  echo "<tr ><td>".$row["bookid"]."</td><td>".$row["title"]."</td><td>".$row["groupid"]."</td><td>".$row["available"]."</td><td>".$row["maxbook"]."</td><td>".$row["price"]."</td><td>".$row["colmnno"]."</td><td>".$row["rowno"]."</td><td>".$row["rackno"]."</td></tr>";
 	 } 
   echo "<br><br></table>";
}
else
{
    $_SESSION["dbookiderr"] = "no such bookid exists";
     header("Location:http://localhost/deletebook1.php");
     exit; 
}

//book should not be issued

$sql="select * from borrowedby where bookid=".$_POST["bookid"];
$result=$conn->query($sql);
if ($result->num_rows > 0)
{
	$_SESSION["dbookiderr"]="BOOK IS ISSUED...CANT BE DELETED"; 
	header("Location:http://localhost/deletebook1.php");
     	exit; 
}

//updating value of max 
$sql1="select groupid from book where bookid=".$_POST["bookid"];
$result=$conn->query($sql1);
if ($result->num_rows > 0)
 {  	 
   	  while($row = $result->fetch_assoc())
	 {
		$groupid=$row["groupid"];
	 }
}
$sql2="update book set maxbook=maxbook-1 where groupid='".$groupid."'";
if ($conn->query($sql2) === TRUE) 
{
    echo "Record updated successfully";
} 
else
 {
    echo "Error updating record: " . $conn->error;
 }


//updating value of available
$sql="select * from borrowedby where bookid=".$_POST["bookid"];
$result=$conn->query($sql);
if ($result->num_rows == 0)
 {
	$sql1="update book set available=available-1 where groupid='".$groupid."'";
	 if( $conn->query($sql1)==true)
	{
		//echo "available updated";
	}
	else
	 {
                   	echo "Error updating record: " . $conn->error;
	 }
}
/*else
{
	$sql="select sname from student,borrowedby where  borrowedby.memid=student.memid and bookid=".$_POST["bookid"];	
	$result=$conn->query($sql);
	if ($result->num_rows > 0)
	 {  	 
   		  while($row = $result->fetch_assoc())
		 {
			echo "<center><h2>this is issued by ".$row["sname"]."</h2></center>";
		}
	}
}*/

//updating author tables
$sql1="select authid from written where bookid=".$_POST["bookid"];
$result=$conn->query($sql1);
while($row = $result->fetch_assoc()) 
{
	$authid=$row["authid"];    
	$sql2="select * from written where authid =".$authid;
	$result1=$conn->query($sql2);
	if ($result1->num_rows ==1)
	{    
		$sql= "delete from  written where authid=".$authid ;
		if($conn->query( $sql)==true)
		{
			//echo "deleted from written";
		}

		$sql="delete from author where authid=".$authid;
		if($conn->query($sql)==true)
		{
			//echo "success in author table";
		}
		else
		 {
                  	 	echo "Error updating author: " . $conn->error;
	 	}
	}
}
//updating publisher table
$sql1="select pubid from published where bookid=".$_POST["bookid"];
$sql2="select * from published where pubid=(".$sql1.")";
$result=$conn->query($sql2);
if ($result->num_rows == 1)
{
	 while($row = $result->fetch_assoc()) 
	{    	
		$sql= "delete from  published where bookid=".$_POST["bookid"] ;
		$pubid=$row["pubid"];
		if($conn->query($sql)==true)
		{
			$sql="delete from publisher where pubid=".$pubid;
			if($conn->query( $sql)==true)
			{
				//echo "deleted from published";
			}
		}
		else
	 	{
                   		echo "Error updating publisher: " . $conn->error;
	 	}
	}
}

$sql= "delete from  written where bookid=".$_POST["bookid"] ;
if($conn->query( $sql)==true)
{
//	echo "deleted from written";
}
$sql= "delete from  published where bookid=".$_POST["bookid"] ;
if($conn->query( $sql)==true)
{
//	echo "deleted from published";
}
$sql= "delete from  borrowedby where bookid=".$_POST["bookid"] ;
if($conn->query( $sql)==true)
{
	//echo "delete from borrowedby";
}
$sql= "delete from  book where bookid=".$_POST["bookid"] ;
echo $sql;
if($conn->query( $sql)==true)
{
	echo "deleted from book";
}
else
{
                 	echo "Error updating book: " . $conn->error;
}
echo "</center>";
?>