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
$_SESSION["visited_deletestudent"]=1;
$_SESSION["dsmemerr"]="";
$memid=$_POST["memid"];
//to get the data of the student record to be deleted
$servername="localhost";
$user="root";
$password="";
$flag=0;
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error) {
	 die("Connection failed: " . mysqli_connect_error());
}
if(empty($_POST["memid"]))
{	
	$_SESSION["dsmemerr"]="MEMBERID IS REQUIRED";
	  header("Location:http://localhost/deletestudent1.php");
 	   exit;
}
//valid student id
$sql="select * from student where memid=".$_POST["memid"];
$result=$conn->query($sql);
if ($result->num_rows==0)
{
$_SESSION["dsmemerr"]="INVALID MEMBERID";
  header("Location:http://localhost/deletestudent1.php");
 	   exit;	
}

//to check if there is any book due on the student
$sql="select limit_book from student where memid=".$_POST["memid"];
$result=$conn->query($sql);   
if ($result->num_rows > 0)
 {
   	  while($row = $result->fetch_assoc())
	 {
                      if($row["limit_book"]!=2)              
                      {
		$_SESSION["dsmemerr"]="STUDENT HAS ISSUED BOOK...CANT DELETE";
           		  header("Location:http://localhost/deletestudent1.php");
                                    exit;	  
	    }
                  }
} 

echo "<center>";
echo " <th><br><br><br>STUDENT DETAILS</th>";
$sql="select * from student where memid=".$_POST["memid"];
$result=$conn->query($sql);   

echo "<center>";
if ($result->num_rows > 0)
 {
   	 echo "<table border='1' ><tr><th>MEMID</th><th>NAME</th><th>MEMDATE</th><th>EXPIRY</th><th>MEMTYPE</th><th>LIMIT_BOOK</th><th>ADDRESS</th></tr>";
   	 // output data of each row
  	  while($row = $result->fetch_assoc()) {
       	 echo "<tr ><td>".$row["memid"]."</td><td>".$row["sname"]."</td><td>".$row["memdate"]."</td><td>".$row["expiry"]."<td>".$row["memtype"]."</td></td><td>".$row["limit_book"]."</td><td>".$row["address"]."</td></tr>";
    }
    echo "<br><br><br><br></table>";
} 
echo "</center>";
//delete from student
$sql = "delete FROM student where memid='$memid'";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
//    echo "Record successfully deleted from student";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
         
//delete from control1
$sql = "delete FROM control1 where memid='$memid'";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
 //   echo "Record successfully deleted from control1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
  

//delete from borrowedby
/*$sql = "delete FROM borrowedby where memid='$memid'";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
//    echo "Record successfully deleted from borrowedby";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}*/



end:
$conn->close();



?>