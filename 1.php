<?php
session_start();
$servername = "localhost";
$user = "root";
$password = "";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error)
 {
	 die("Connection failed: " . mysqli_connect_error());
}
$_SESSION["visited_login"]=1;
$_SESSION["usererr"]=$_SESSION["passerr"]="";
if(empty($_POST["username"]))
{
	$_SESSION["usererr"]="enter the username";
	header("Location:http://localhost/login1.php");
	exit;
}
else if(empty($_POST["password"]))
{
	$_SESSION["passerr"]="enter the password";
	header("Location:http://localhost/login1.php");
	exit;
}
//direct to student page
else if($_POST["username"] == "student" && $_POST["password"]=="jamia")
{
	$_SESSION["username"]=$_POST["username"];
	header("Location:http://localhost/member.php");
	exit;
}

//direct to librarian
$sql="select name,passwd from librarian";
$result=$conn->query($sql);
if($result->num_rows >0)
{
	 while($row = $result->fetch_assoc())
	{
		if($_POST["username"]== $row["name"] and $_POST["password"]==$row["passwd"])
		{
			$flag=1;
			$_SESSION["username"]=$_POST["username"];
			header("Location:http://localhost/library.php");
			exit;			
		}		
	}	
}
if($flag==0)
{
	$_SESSION["usererr"]="enter a valid combination of username and password";
	header("Location:http://localhost/login1.php");
	exit;	
}
?>