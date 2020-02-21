<!DOCTYPE html>
<html>
<head>
	<title>
		Homepage
		<?php 
		session_name('test'); 
		// Start session required to use session variables.
		session_start(); ?>
	</title>
	<link rel="stylesheet" type="text/css" href="finalstyle.css">
</head>
<body>
	<h1>Choose an option</h1>
	<form method="POST" id='normal'>
		<div class="btn-group" style="width:100%">
		  <button style="width:14.28%" id='Start' name="Start" title="Used to label 1 folder(with multiple files) with a single label. Eg. Label a cats folder(with different images of cats) with a cat label, dogs folder(with different images of dogs) with a dog label, to distinguish among animals.">
		  	Start Labelling A Set Of Folders
		  </button>
		  <button id='File' name='File' style="width:14.28%" title="Used to label individual images with a single label. Eg. In a folder named Animals, label each cat image with cat label, and each dog image with dog label.">
		  	Start Labelling Individual Files
		  </button>
		  <button id='View' name="View" value="View" style="width:14.28%" title="View Records stored in the database.">
		  	View Current Records
		  </button>
		  <button id="Edit" name="Edit" value="Edit" style="width:14.28%" title="Edit Records stored in the database. ">
		  	Edit Existing Records
		  </button>
		  <button id="Delete" name="Delete" value="Delete" style="width:14.28%" title="Delete Records from the database. ">
		  	Delete Existing Records
		  </button>
		  <button id="Custom" name="Custom" value="Custom" style="width:14.28%" title="Add your labels as per your requirement. ">
		  	Add Custom Labels
		  </button>
		  <button id='Export' name='Export' value="Export" style="width:14.28%" title="Download Database records as a CSV file. ">
		  	Export Current Records as CSV
		  </button>
		</div>
		<div class="btn-group" style="width:28.59%">
			<button id='ResumeFolder' name="ResumeFolder" style="width:50%">
				Resume Labelling Set Of Folders
			</button>
			<button id='ResumeFile' name='ResumeFile' style="width:50%">
				Resume Labelling Individual Files
			</button>
		</div>

		<br>
	</form>

	<?php
	/*Change variables as per database. Refer to readme*/
	$servername = "localhost";
	$username = "shouvik";
	$password = "sarkar301";
	$dbname = "sarkar";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "select * from labels";
	$sql2 = "select * from resume";
	$resume = $conn->query($sql2);
	$labels = $conn->query($sql);
	
	/*Below code is used to obtain default label values stored in the table from the previous session*/
	if(!isset($_POST['formsubmit']) && (!isset($_SESSION['total'])))
	{
		if($labels->num_rows>0)
		{
			while($row = $labels->fetch_assoc())
			{
				$label = $row['ID'];
				$value = $row['Label'];
				$_SESSION[$label]=$value;
				$_SESSION['total']=$labels->num_rows;
			}
		}
	}
	
	if($conn->connect_error){
		die("Connection failed: ".$conn->connect_error);
	}
	/*THe Below Code is used to Extract the Current Set Labels by the user, and display them on the homepage*/
	if((isset($_POST['formsubmit'])))
	{
		echo "<h1>Your Current Labels Are: </h1><br>";
		$_SESSION['total']=$_POST['total'];
		$_SESSION['total']=$_SESSION['total']+0;
		/*Below loop displays on the homepage*/
		for($i=1;$i<=$_SESSION['total'];$i++)
		{
			$_SESSION['textfield'.$i]=$_POST['textfield'.$i];
			echo "<h2>".$_SESSION['textfield'.$i]."</h2><br>"; 
		}
		$sql3='truncate labels'; //Clearing the previous labels record
		$conn->query($sql3);
		/*The loop below stores the labels in the database for future use*/
		for($i=1;$i<=$_SESSION['total'];$i++)
		{
			$sql1="Insert into labels values('textfield".$i."','".$_SESSION['textfield'.$i]."') on duplicate key update Label = '".$_SESSION['textfield'.$i]."'";
			$conn->query($sql1); 
		}
	}
	/*Below code displays old labels*/
	else if(isset($_SESSION['textfield1']))
	{
		echo "<h1>Your Existing Labels Are: </h1><br>";
		for($i=1;$i<=$_SESSION['total'];$i++)
		{
			echo "<h2>".$_SESSION['textfield'.$i]."</h2><br>";
		}
	}

	else echo "<h1>You Have No Current Labels. </h1><br>";

	if(isset($_POST['Start'])) //Start Labelling A Set Of Folders
	{
		$_SESSION['folder']=0;
		header("Location: main.php");	
	}
	if(isset($_POST['View'])) //View All Records
	{
		header("Location: view.php");	
	}
	if(isset($_POST['Edit'])) //Edit Existing Records
	{
		header("Location: edit.php");
	}
	if(isset($_POST['Delete'])) //Delete Existing Records
	{
		header("Location: delete.php");
	}
	if(isset($_POST['Custom'])) //Add Custom Labels
	{
		header("Location: custom.php");
	}
	if(isset($_POST['Export'])) //Export Current Records to CSV
	{
		header("Location: sqltocsv.php");
	}
	if(isset($_POST['File'])) //Start Labelling Individual Files
	{
		$_SESSION['file']=0;
		header("Location: file.php");
	}
	if(isset($_POST['ResumeFolder'])) //Resume Labelling a Set of Folders
	{
		if(!isset($_SESSION['folder']))
		{
			/*Extracts session id from resume table*/
			if($resume->num_rows>0)
			{
				while($row = $resume->fetch_assoc())
				{
					if($row['type']=='folder')
					{
						$_SESSION['folder']=max(0,($row['id']-1));
					}
				}
			}
		}
		header("Location: main.php");
	}
	if(isset($_POST['ResumeFile'])) //Resume Labelling Individual Files
	{
			/*Extracts session id from resume table*/
			if($resume->num_rows>0)
			{
				while($row = $resume->fetch_assoc())
				{
					if($row['type']=='file')
					{
						$_SESSION['file']=max(0,($row['id']-1));
					}
				}
			}
		header("Location: file.php");
	}
	?>

</body>
</html>
