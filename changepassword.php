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
$_SESSION["success"]=$_SESSION["opasserr"]=$_SESSION["npasserr"]=$_SESSION["rpasserr"]="";
$_SESSION["visited_password"]=1;
//change password
$sql="select passwd from librarian where name='".$_SESSION["username"]."'";
$servername="localhost";
$user="root";
$password="";
$conn = new mysqli($servername, $user, $password,"project");
$result=$conn->query($sql);
if(empty($_POST["old_passwd"]))
{
	$_SESSION["opasserr"]="OLD PASSWORD IS REQUIRED";
	header("Location:http://localhost/changepassword1.php");
     	exit; 
}
if( empty($_POST["new_passwd"]))
{
	$_SESSION["npasserr"]="ENTER THE NEW PASSWORD";
	header("Location:http://localhost/changepassword1.php");
              	exit; 
}

if (empty($_POST["re_passwd"]))
{               
	$_SESSION["rpasserr"]="RETYPE THE NEW PASSWORD";
	header("Location:http://localhost/changepassword1.php");
     	exit; 
}
while($row=$result->fetch_assoc())
{
	if($row["passwd"]==$_POST["old_passwd"])
	{	
		if($_POST["re_passwd"]!=$_POST["new_passwd"])
		{
			$_SESSION["rpasserr"]="PASSWORD MISMATCH";
			header("Location:http://localhost/changepassword1.php");
		     	exit; 
		}
		if(strlen($_POST["new_passwd"])>5)
		{
			$sql="update librarian set passwd='".$_POST["new_passwd"]."' where name='".$_SESSION["username"]."'";
			$conn->query($sql);
		}
		else
		{
			//new passwd  error
			$_SESSION["npasserr"]="MINIMUM LENGTH OF PASSWORD SHOULD BE ATLEAST 6";
			header("Location:http://localhost/changepassword1.php");
		     	exit; 
		}
	}
	else
	{
		$_SESSION["opasserr"]="INCORRECT PASSWORD";
		header("Location:http://localhost/changepassword1.php");
		     	exit; 
	}
}

$_SESSION["success"]="PASSWORD CHANGED SUCCESSFULLY";
header("Location:http://localhost/changepassword1.php");
		     	exit; 
?>