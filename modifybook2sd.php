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
$_SESSION["visited_modifybook2"]=1;
$_SESSION["err"]=$_SESSION["puberr1"]=$_SESSION["autherr1"]=$_SESSION["priceerr"]=$_SESSION["maxerr"]=$_SESSION["grouperr"]=$_SESSION["titleerr1"]=$_SESSION["rackerr"]=$_SESSION["rowerr"]=$_SESSION["cerr"]="";
$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}
//check the required fields
if (empty($_POST["title"]))
 {
     $_SESSION["titleerr1"] = "title is required";
     header("Location:http://localhost/modifybook1.php");
     exit;
   } 
if (empty($_POST["max"]))
 {
     $_SESSION["maxerr"] = "max book is required";
     header("Location:http://localhost/modifybook1.php");
     exit;
   }
if (empty($_POST["price"]))
 {
     $_SESSION["priceerr"] = "price is required";
     header("Location:http://localhost/modifybook1.php");
     exit;
   } 
if (empty($_POST["autname"]))
 {
     $_SESSION["autherr1"] = "author is required";
     header("Location:http://localhost/modifybook1.php");
     exit;
   }
if (empty($_POST["pubname"]))
 {
     $_SESSION["puberr1"] = "publisher is required";
     header("Location:http://localhost/modifybook1.php");
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
//check integral value
if(preg_match ("/[^0-9]/", $_POST["max"]))
{
	$_SESSION["maxerr"]="only numeric value allowed";
	  header("Location:http://localhost/modifybook1.php");
 	 exit;
}
if(preg_match ("/[^0-9]/", $_POST["price"]))
{
	$_SESSION["priceerr"]="only numeric value allowed";
	  header("Location:http://localhost/modifybook1.php");
 	   exit;
	
}
if(preg_match ("/[^0-9]/", $_POST["cno"]))
{
	$_SESSION["cerr"]="only numeric value allowed";
	  header("Location:http://localhost/modifybook1.php");
  	exit;
}
if(preg_match ("/[^0-9]/", $_POST["rowno"]))
{
	$_SESSION["rowerr"]="only numeric value allowed";
	  header("Location:http://localhost/modifybook1.php");
  	exit;
}
if(preg_match ("/[^0-9]/", $_POST["rackno"]))
{
	$_SESSION["rackerr"]="only numeric value allowed";
	  header("Location:http://localhost/modifybook1.php");
  	exit;
}
//checking the value of max
if($_SESSION["oldmax"]-$_POST["max"]>0)
{
	$_SESSION["maxerr"]="cant decrease copies...if u want ..
				then delete them";
	  header("Location:http://localhost/modifybook1.php");
  	exit;

}

$count=$_POST["max"]-$_SESSION["oldmax"];
$sql="select groupid from book where bookid=".$_SESSION["bookid"];
$result=$conn->query($sql);
if($result->num_rows > 0)
{
	while($row=$result->fetch_assoc())
	{
		$groupid=$row["groupid"];
	}
}
$x=$_SESSION["oldavailable"]+$count;
//update book
$sql= "update book SET title='".$_POST["title"]."',price=".$_POST["price"].",rowno=".$_POST["rowno"].",rackno=".$_POST["rackno"].",colmnno=".$_POST["cno"].",maxbook=".$_POST["max"].",available=".$x." where groupid='".$groupid."'" ;
echo $_POST["title"] ,   $_POST["price"] ,     $_POST["rackno"] ,       $_POST["rowno"]   ,   $_POST["cno"]    ;
if($conn->query($sql)==true)
{
	//echo "book table updated";
}
//insert when count>o
$loop=$count;
$sql1="select authid from written where bookid=".$_SESSION["bookid"];
$result=$conn->query($sql1);
if($result->num_rows > 0)
{
	while($row=$result->fetch_assoc())
	{	
		$autid=$row["authid"];
	}
}
$sql1="select pubid from published where bookid=".$_SESSION["bookid"];
$result=$conn->query($sql1);
if($result->num_rows > 0)
{
	while($row=$result->fetch_assoc())
	{	
		$pubid=$row["pubid"];
	}
}

while($loop>0)
{
	$sql="insert into book (title,groupid,available,maxbook,price,colmnno,rowno,rackno) values ('".$_POST["title"]."','".$groupid."',".$x.",".$_POST["max"].",".$_POST["price"].",".$_POST["cno"].",".$_POST["rowno"].",".$_POST["rackno"].")";
	echo "jgg". $sql;
	if($conn->query($sql)==true)
	{
		//insert into wriiten
		$bookid=$conn->insert_id;		
		$sql="insert into written values(".$bookid.",".$autid.")";
		if($conn->query($sql)==true)
		{
			//echo "success in return";
		}
		//insert into published
		$sql="insert into published values(".$bookid.",".$pubid.")";
		if($conn->query($sql)==true)
		{
		//	echo "success in published";
		}
		$loop=$loop-1;
	}
}
//update author
$sql1="select authid from written where bookid=".$_SESSION["bookid"];
$sql2="update author set autname='".$_POST["autname"]."' where authid=(".$sql1.")";
if($conn->query($sql2)==true)
{
//	echo "author updated";
}

//update publisher
$sql1="select pubid from published where bookid=".$_SESSION["bookid"];
$sql2="update publisher set name='".$_POST["pubname"]."',address='".$_POST["address"]."' where pubid=(".$sql1.")";
if($conn->query($sql2)==true)
{
//	echo "publisher updated";
}
?>