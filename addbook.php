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
$_SESSION["visited"]=1;
$servername = "localhost";
$user = "root";
$password = "";
$_SESSION["abpuberr"]=$_SESSION["abautherr"]=$_SESSION["abpriceerr"]=$_SESSION["abmaxerr"]=$_SESSION["abgrouperr"]=$_SESSION["abtitleerr"]=$_SESSION["abrackerr"]=$_SESSION["abrowerr"]=$_SESSION["abcerr"]="";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error) {
	 die("Connection failed: " . mysqli_connect_error());
}
//check required field
if (empty($_POST["title"]))
 {
     $_SESSION["abtitleerr"] = "title is required";
     header("Location:http://localhost/addbook2.php");
     exit;
   } 
if (empty($_POST["groupid"]))
 {
     $_SESSION["abgrouperr"] = "groupid is required";
     header("Location:http://localhost/addbook2.php");
     exit;
   } 
if (empty($_POST["max"]))
 {
     $_SESSION["abmaxerr"] = "max book is required";
     header("Location:http://localhost/addbook2.php");
     exit;
   }
if (empty($_POST["price"]))
 {
     $_SESSION["abpriceerr"] = "price is required";
     header("Location:http://localhost/addbook2.php");
     exit;
   } 
if (empty($_POST["author_name"]))
 {
     $_SESSION["abautherr"] = "author is required";
     header("Location:http://localhost/addbook2.php");
     exit;
   }
if (empty($_POST["publisher_name"]))
 {
     $_SESSION["abpuberr"] = "publisher is required";
     header("Location:http://localhost/addbook2.php");
     exit;
   } 


if (empty($_POST["price"]))
 {
     $_SESSION["abpriceerr"] = "price is required";
     header("Location:http://localhost/addbook2.php");
     exit;
   }
if (empty($_POST["rackno"]))
 {
$_POST["rackno"]=0;
   }
if (empty($_POST["rowno"]))
 {
$_POST["rowno"]=0;
   }
if (empty($_POST["cno"]))
 {
$_POST["cno"]=0;
   }
if(empty($_POST["address"]))
{
$_POST["address"]="";
}


//valid groupid 
$sql="select groupid from book";
$result=$conn->query($sql);
if ($result->num_rows > 0)
 {
	while($row=$result->fetch_assoc())
	{
		if($_POST["groupid"]==$row["groupid"])
		{
			$_SESSION["abgrouperr"]="groupid already in use";
			  header("Location:http://localhost/addbook2.php");
  			   exit;
		}	
	}
  }
//check int value of max,price,rackno,cno,rowno
if(preg_match ("/[^0-9]/", $_POST["max"]))
{
	$_SESSION["abmaxerr"]="only numeric value allowed";
	  header("Location:http://localhost/addbook2.php");
 	 exit;
}
if(preg_match ("/[^0-9]/", $_POST["price"]))
{
	$_SESSION["abpriceerr"]="only numeric value allowed";
	  header("Location:http://localhost/addbook2.php");
 	   exit;	
}
if(preg_match ("/[^0-9]/", $_POST["cno"]))
{
	$_SESSION["abcerr"]="only numeric value allowed";
	  header("Location:http://localhost/addbook2.php");
  	exit;
}
if(preg_match ("/[^0-9]/", $_POST["rowno"]))
{
	$_SESSION["abrowerr"]="only numeric value allowed";
	  header("Location:http://localhost/addbook2.php");
  	exit;
}
if(preg_match ("/[^0-9]/", $_POST["rackno"]))
{
	$_SESSION["abrackerr"]="only numeric value allowed";
	  header("Location:http://localhost/addbook2.php");
  	exit;
}
//check author exists
$_POST["author_name"]=preg_replace("/\s+/", " ", $_POST["author_name"]);
$sql= "select  authid from author where autname='".$_POST["author_name"]."'" ;
$result=$conn->query( $sql);
echo "<center>";
$flag=0;
if ($result->num_rows > 0)
 {
	while($row=$result->fetch_assoc())
	{
		$authid=$row["authid"];	
	}
  }
else
{
	$sql="insert into author (autname) values('".$_POST["author_name"]."')";
	if($conn->query($sql)==true)
	{	
		$authid=$conn->insert_id;
	}
 	else
 	{
    		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
echo " <th><br><br><br>AUTHOR-DETAILS</th>";   	
echo "<table border='1' ><tr><th>AUTHORID</th><th>AUTHORNAME</th></tr>";  	 
echo "<tr ><td>".$authid."</td><td>".$_POST["author_name"]."</td></tr>";
echo"</table>";
$_POST["publisher_name"]=preg_replace("/\s+/", " ", $_POST["publisher_name"]);
$sql= "select  pubid from publisher where name='".$_POST["publisher_name"]."'" ;
$result=$conn->query( $sql);
//echo " <th><br><br><br>ACOUNT DETAILS</th>";   	
if ($result->num_rows > 0)
 {
	while($row=$result->fetch_assoc())
	{
		$pubid=$row["pubid"];
	}
    }
 else
{
	$sql="insert into publisher (name,address) values('".$_POST["publisher_name"]."','".$_POST["publisher_address"]."')";
	if ($conn->query($sql) === TRUE)
	 {
		$pubid=$conn->insert_id;
	}
 	else
 	{
		 echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
echo " <th><br><br><br>PUBLISHER-DETAILS</th>";   	
echo "<table border='1' ><tr><th>PUBLISHERID</th><th>PUBLISHER_NAME</th></tr>";  	 
echo "<tr ><td>".$pubid."</td><td>".$_POST["publisher_name"]."</td></tr>";
echo"</table>";

//insertion into book
$count=$_POST["max"];
echo "<center>";
echo " <th><br><br><br>BOOK DETAILS</th>";   	

$_POST["title"]=preg_replace("/\s+/", " ", $_POST["title"]);
echo "<table border='1' ><tr><th>BOOKID</th><th>TITLE</th><th>GROUPID</th><th>AVAILABLE</th><th>MAX </th><th>PRICE</th><th>COLMNNO </th><th>ROWNO</th><th>RACKNO</th></tr>";  	 
while($count>0)
{
	$sql="insert into book(title,groupid,available,maxbook,price,colmnno,rowno,rackno) values('".$_POST["title"]."','".$_POST["groupid"]."',".$_POST["max"].",".$_POST["max"].",".$_POST["price"].",".$_POST["cno"].",".$_POST["rowno"].",".$_POST["rackno"].")";
	if($conn->query($sql)==true)
	{
		$bookid=$conn->insert_id;
		 echo "<tr ><td>".$bookid."</td><td>".$_POST["title"]."</td><td>".$_POST["groupid"]."</td><td>".$_POST["max"]."</td><td>".$_POST["max"]."</td><td>".$_POST["price"]."</td><td>".$_POST["cno"]."</td><td>".$_POST["rowno"]."</td><td>".$_POST["rackno"]."</td></tr>";
	}
	else
	{
		 echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$sql="insert into written values(".$bookid.",".$authid.")";
	if($conn->query($sql)==true)
	{
		//echo "new record created in  written table";
	}
	else
	{
		 echo "Error: " . $sql . "<br>" . $conn->error;	
	}
	$sql="insert into published values(".$bookid.",".$pubid.")";
	if($conn->query($sql)==true)
	{
		//echo "new record created in  published table";
	}
	else
	{
		 echo "Error: " . $sql . "<br>" . $conn->error;	
	}
	
	$count=$count-1;
} 
echo "</table><br><br><br><br>";
//display 
?>