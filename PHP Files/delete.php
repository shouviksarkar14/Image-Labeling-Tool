<!DOCTYPE html>
<html>
<head>
	<title>
		Delete Existing Records
	</title>
	<link rel="stylesheet" type="text/css" href="finalstyle.css">
</head>
<body>
	<?php
	$servername = "localhost";
	$username = "shouvik";
	$password = "sarkar301";
	$dbname = "sarkar";

	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT * from brain";
	
	$result = $conn->query($sql);
	if($result->num_rows>0){
		/*Prints table from database, similar to view.php*/
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
	echo "<form action='index.php'>
				<button class='nbutton' id='home' type='submit'>
					Go Home
				</button><br>
			</form>";
	?>
	<form method="post">
		Enter the ID which you wish to delete:<br>
		<input type="text" name="editid"><br>
		<input type="submit" name="delete" value="Delete">
		<button id='all' name='all'>Delete All Records</button>
	</form>
	<?php 
	$conn = new mysqli($servername, $username, $password, $dbname);
	/*Below if conditions detect button click and delete accordingly*/ 
	if(isset($_POST['delete']))
	{
		$id = $_POST['editid'];
		$sql1 = "delete from brain where id='".$id."'";
	}
	else if(isset($_POST['all']))
	{
		$sql1 = "truncate brain";
	}
	$response = $conn->query($sql1);

	?>

</body>
</html>