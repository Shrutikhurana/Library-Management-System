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
$_SESSION["visited_add"]=1;
$_SESSION["err"]=$_SESSION["anamerr"]=$_SESSION["atyperr"]=$_SESSION["aaddresserr"]="";
$n=$_POST["name"]; 
$t=$_POST["type"]; 
$a=$_POST["address"]; 

$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error) {
	 die("Connection failed: " . mysqli_connect_error());
}
//empty fields
if (empty($_POST["name"]))
 {
     $_SESSION["anamerr"] = "name is required";
     header("Location:http://localhost/addstudent1.php");
     exit;
   }
if (empty($_POST["type"]))
 {
     $_SESSION["atyperr"] = "type is required";
     header("Location:http://localhost/addstudent1.php");
     exit;
   }
if (empty($_POST["address"]))
 {
     $_SESSION["aaddresserr"] = "address is required";
     header("Location:http://localhost/addstudent1.php");
     exit;
   }

if (preg_match('/[^A-Za-z .]/', $n))
{
    $_SESSION["anamerr"]="enter a valid name";
     header("Location:http://localhost/addstudent1.php");
    exit;
}
if($_POST["type"]!="student" && $_POST["type"]!="teacher")
{
     $_SESSION["atyperr"] = "TYPE CAN EITHER BE STUDENT OR TEACHER";
     header("Location:http://localhost/addstudent1.php");
     exit;
}
//CHECK whether student with the same name and address exists
$sql="select * from student where sname='".$_POST["name"]."' and address='".$_POST["address"]."'";
$result=$conn->query($sql);
if ($result->num_rows > 0)
{
  $_SESSION["err"]="THIS STUDENT ALREADY EXISTS";
header("Location:http://localhost/addstudent1.php");
     exit;
}
$sql = "INSERT INTO student ".
       "(sname,memdate,expiry,memtype,limit_book,address) ".
       "VALUES('$n',CURDATE(),CURDATE()+INTERVAL 2 YEAR,'$t',2,'$a')";

if ($conn->query($sql) === TRUE)
 {
}
 else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$cnt=0;
$memid="SELECT memid FROM student";
// where sname='$n' and memtype='$t' and address='$a'";
$result = $conn->query($memid);

if ($result->num_rows > 0)
 {
//   	 echo "<table border='1' ><tr><th>NAME</th><th>MEMDATE</th><th>EXPIRY</th><th>MEMTYPE</th><th>LIMIT_BOOK</th><th>ADDRESS</th></tr>";
   	 // output data of each row
  	  while($row = $result->fetch_assoc()) {
  
//       	 echo "<tr ><td>".$row["memid"]."</td></tr>";
         $x=$row["memid"]; 
           
   }
//    echo "<br><br><br><br><br><br><br><br><br>
echo "</table>";
} 
else {
}

echo "</center>";

$id="SELECT id FROM librarian";
$result1 = $conn->query($id);
if ($result1->num_rows > 0)
 {
  	  while($row1 = $result1->fetch_assoc()) {
  
       	 $x1=$row1["id"]; 
$sql = "INSERT INTO control1 ".
       "(memid,id) ".
       "VALUES('$x','$x1')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully in control1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
         
 //     echo $x1;         
   }
  //  echo "<br><br><br><br><br><br><br><br><br>"
echo "</table>";
} else {
    echo "0 results";
}



$sql = "SELECT memid,sname,memdate,expiry,memtype,limit_book,address FROM student";
$result = $conn->query($sql);

echo "<center>";
if ($result->num_rows > 0)
 {
   	 echo "<table border='1' ><tr><th>MEMID</th><th>NAME</th><th>MEMDATE</th><th>EXPIRY</th><th>MEMTYPE</th><th>LIMIT_BOOK</th><th>ADDRESS</th></tr>";
   	 // output data of each row
  	  while($row = $result->fetch_assoc()) {
       	 echo "<tr ><td>".$row["memid"]."</td><td>".$row["sname"]."</td><td>".$row["memdate"]."</td><td>".$row["expiry"]."<td>".$row["memtype"]."</td></td><td>".$row["limit_book"]."</td><td>".$row["address"]."</td></tr>";
    }
    echo "<br><br><br><br></table>";
} else {
    echo "0 results";
}
echo "</center>";


$conn->close();


?>