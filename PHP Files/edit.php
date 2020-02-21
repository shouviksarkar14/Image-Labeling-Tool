<!DOCTYPE html>
<html>
<head>
	<title>
		Edit Current Labels
	</title>
	<link rel="stylesheet" type="text/css" href="finalstyle.css">
</head>
<body>
	<?php
	$servername = "localhost";
	$username = "shouvik";
	$password = "sarkar301";
	$dbname = "sarkar";
	$tablename = "brain";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn->connect_error){
		die("Connection failed: ".$conn->connect_error);
	}
	$sql = "SELECT * from".$tablename;
	
	$result = $conn->query($sql);
	/*Prints the table from database*/
	if($result->num_rows>0){
		echo "<table>
  	<tr>
    	<th>ID</th>
    	<th>Response</th>
  	</tr>";
		while($row = $result->fetch_assoc()){
			echo "
  	<tr>
    	<td>".$row['ID']."</td>
    	<td>".$row['Response']."</td>
 	 </tr>
	";
		}
	echo "</table>";	
	}
	else{
		echo " <h2>No results found.</h2>";
		}
	$conn->close();
	/*Prints the home button*/
	echo "<form action='index.php'>
				<button class='nbutton' id='home' type='submit'>
					Go Home
				</button><br>
			</form>";
	?>
	<form method="post">
		Enter the ID which you wish to edit:<br>
		<input type="text" name="editid"><br>
		Select the new response:<br>
		<input type="text" name="Edit"><br>
		<input type="submit" name="edmit" value="Edit">
	</form>

	<?php
	$conn = new mysqli($servername, $username, $password, $dbname); 
	/*Detects button click and updates values*/
	if(isset($_POST['edmit']))
	{
		$response = $_POST['Edit'];
		$id = $_POST['editid'];
	}
	$sql1 = "update ".$tablename." set response='".$response."' where id='".$id."'";
	$response = $conn->query($sql1);
	?>

</body>
</html>