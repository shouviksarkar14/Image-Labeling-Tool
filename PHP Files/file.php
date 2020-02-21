<!DOCTYPE html>
<html>
<head>
	<!--<meta charset="utf-8" http-equiv="refresh" content="1">-->
	<link rel="stylesheet" type="text/css" href="finalstyle.css">
	<title>
		Data Labeling Tool
		<?php 
		session_name('test');
		session_start();
		 ?>
	</title>
</head>
<body>

	<h1>
		Internal Bleeding In The Skull
	</h1>
	
	<?php
	/*The below lines of code, till line 37 are to make sure only image files are displayed*/
	$availableImageFormats = [
	"png",
	"jpg",
	"jpeg",
	"gif"];
	$searchDir = 'images'; #Change this value to change the parent folder
	$imageExtensions = "{";
	foreach ($availableImageFormats as $extension) {
	    $extensionChars = str_split($extension);
	    $rgxPartial = null;
	    foreach ($extensionChars as $char) {
	        $rgxPartial .= "[".strtoupper($char).strtolower($char)."]";
	    }
	    $rgxPartial .= ",";
	    $imageExtensions .= $rgxPartial;
	};
	/*The below lines of code are to display an image present in the folder*/
	$imageExtensions .= "}";
	$files=glob($searchDir."/*.".$imageExtensions, GLOB_BRACE); 
	$image=$files[$_SESSION['file']];
	echo '<img src="'.$image .'" alt="Random image" />'."<br /><br />";
	?>
	<form method="POST" id='mainform'>
		
	</form>
	<form method="POST">
		<button class="nbutton" name="home" id="home">Go Home</button>
	</form>

	<script type="text/javascript">
		<?php
		$js_array = json_encode($_SESSION);
		echo "var javascript_array = ". $js_array . ";\n";

		?>
		var val = <?php echo $_SESSION['total'];?>;
		/*Random generation of buttons from session variables*/
		function add(){
			for(var i=1;i<=val;i++)
			{	
				var element = document.createElement("button");
				var br = document.createElement("span");
				element.setAttribute("name","button"+i);
				element.setAttribute("id","button"+i);

				element.innerHTML=javascript_array['textfield'+i];
				var elementAbove = document.getElementById("mainform");
				elementAbove.appendChild(element);
				elementAbove.appendChild(br);
			}
		}

		add();
	</script>
	<?php
	/*Change user variables as per use*/
	$servername = "localhost";
	$username = "shouvik";
	$password = "sarkar301";
	$dbname = "sarkar";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn->connect_error){
		die("Connection failed: ".$conn->connect_error);
	}
	/*Sending response to the database*/
	for($i=1;$i<=$_SESSION['total'];$i++)
	{
		if(isset($_POST['button'.$i]))
		{
			$sql = "Insert into brain values('".basename($files[($_SESSION['file']-1)])."','".$_SESSION['textfield'.$i]."') on duplicate key update response = '".$_SESSION['textfield'.$i]."'";
			unset($_POST['button'.$i]);
		}	
	}
	/*Sending resume data to database before going home*/
	if (isset($_POST['home'])) {
		$sql1 = "Insert into resume values('file','".$_SESSION['file']."') on duplicate key update id = '".$_SESSION['file']."'";
		$conn->query($sql1);
		unset($_SESSION['file']);
		header("Location: index.php");
	}
	$conn->query($sql);
	$_SESSION['file']++;
	
	/*Finishes the labelling, and inserts 0 to the label table to start from the beginning on clicking resume*/
	if(isset($_SESSION['file']) && is_numeric($_SESSION['file']))
	{
		if($_SESSION['file']>=(count($files))+1)
		{
			$sql1="insert into resume values('file','0') on duplicate key update id = '0'";
			$conn->query($sql1);
			unset($_SESSION['file']);
			header("Location: done.php");
			exit();
		}
	}
	$conn->close();
	?>
</body>
</html>
