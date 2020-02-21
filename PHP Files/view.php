<!DOCTYPE html>
<html>
<head>
	<title>
		View Your Current Labelings
	</title>
	<link rel="stylesheet" type="text/css" href="finalstyle.css">
</head>
<body>
	<?php
	/*Change varibales according to database*/
	$servername = "localhost";
	$username = "shouvik";
	$password = "sarkar301";
	$dbname = "sarkar";
	$tablename = "brain";

	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT * from ".$tablename;
	/*Displays table*/
	$result = $conn->query($sql);
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
	/*Shows buttons*/
	echo "<form action='index.php'>
				<button class='nbutton' id='home' type='submit'>
					Go Home
				</button>
			</form>";
	echo "<form action='sqltocsv.php'>
					<button class='ybutton' id='export' type='submit'>
						Export Current Records to CSV
					</button>
				</form>";
	?>

</body>
</html>