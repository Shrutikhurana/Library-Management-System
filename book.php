<?php
session_start();
$_SESSION["visited_book"]=1;
$_SESSION["err"]="";
$user="root";
$servername="localhost";
$password="";
$conn = new mysqli($servername, $user, $password,"project");
if ($conn->connect_error) {
	 die("Connection failed: " . mysqli_connect_error());
}

//check empty fields
if(empty($_POST["authorname"]) && empty($_POST["publishername"]) && empty($_POST["bname"]))
{
	$_SESSION["err"]="enter the  field first";
	header("Location:http://localhost/book1.php");
	exit;
}

if(empty($_POST["bname"]))
$_POST["bname"]="";
if(empty($_POST["authorname"]))
$_POST["authorname"]="";
if(empty($_POST["publishername"]))
$_POST["publishername"]="";
$_POST["bname"]=preg_replace("/\s+/", " ", $_POST["bname"]);
$_POST["publishername"]=preg_replace("/\s+/", " ", $_POST["publishername"]);
$_POST["authorname"]=preg_replace("/\s+/", " ", $_POST["authorname"]);
$sql= "select  title,autname,name,available,colmnno,rowno,rackno from book,author,publisher,written,published where book.bookid=published.bookid and published.pubid=publisher.pubid and book.bookid=written.bookid and written.authid=author.authid and title like'%".$_POST['bname']."%' and autname like '%".$_POST['authorname']."%' and name like'%".$_POST['publishername']."%' group by title" ;
//echo $sql;

$result=$conn->query( $sql);
echo "<center>";
echo " <th><br><br><br>BOOK DETAILS</th>";
if ($result->num_rows > 0)
{
	 echo "<table border='1' ><tr><th>TITLE</th><th>AUTHOR</th><th>PUBLISHER</th><th>AVAILABLE</th><th>COLUMN_NO</th><th>ROW_NO</th><th>RACK_NO</th></tr>";
   	 // output data of each row
  	  while($row = $result->fetch_assoc())
	 {
       	 	echo "<tr ><td>".$row["title"]."</td><td>".$row["autname"]."</td><td>".$row["name"]."</td><td>".$row["available"]."</td><td>".$row["colmnno"]."</td><td>".$row["rowno"]."</td><td>".$row["rackno"]."</td></tr>";
  	 } 	
	echo "<br><br></table>";
}
else
echo "NO SUCH BOOK WITH SUCH SPECIFICATIONS FOUND";
?>