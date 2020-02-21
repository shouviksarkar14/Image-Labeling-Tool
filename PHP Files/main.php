<!DOCTYPE html>
<html>
<head>
	<!--<meta charset="utf-8" http-equiv="refresh" content="1">-->
	<title>
		Data Labeling Tool
		<?php 
		session_name('test');
		session_start();
		$folder='images'; /*Change folder accordingly*/
		 ?>
	</title>
	<link rel="stylesheet" type="text/css" href="finalstyle.css">
</head>
<body>

	<h1>
		Internal Bleeding In The Skull
	</h1>
	
	<?php 
	
	$directories = glob($folder."/*",GLOB_ONLYDIR); //Selects all directories present in our folder
	/*Stores all directories in an array*/
	for($i=0;$i<count($directories);$i++)
	{
		$directory = $directories[$i];
	}
	/*Finds all files present in the current directory*/
	$files=glob($directories[$_SESSION['folder']].'/*.*');
	for ($i=0; $i<count($files); $i++) {
    		$image = $files[$i];
			echo '<img src="'.$image .'" alt="Random image" />'."<br /><br />";
		}
	?>
	<form method="POST" id='mainform'>
		
	</form>
	<form method="POST">
		<button class="nbutton" name="home" id="home">Go Home</button>
	</form>
	<script type="text/javascript">
		
		<?php
		/*Converts a PHP array to a JS array for client side handling*/
		$js_array = json_encode($_SESSION);
		echo "var javascript_array = ". $js_array . ";\n";
		?>
		var val = <?php echo $_SESSION['total'];?>;
		console.log(val);
		/*Dynamic generation of buttons*/
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
	/*Change variables accordingly*/
	$servername = "localhost";
	$username = "shouvik";
	$password = "sarkar301";
	$dbname = "sarkar";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if($conn->connect_error){
		die("Connection failed: ".$conn->connect_error);
	}
	/*Stores the button response to the database*/
	for($i=1;$i<=$_SESSION['total'];$i++)
	{
		if(isset($_POST['button'.$i]))
		{
			$sql = "Insert into brain values('".basename($directories[($_SESSION['folder']-1)])."','".$_SESSION['textfield'.$i]."') on duplicate key update response = '".$_SESSION['textfield'.$i]."'";
			unset($_POST['button'.$i]);
		}	
	}
	/*Stores session data in database if home is selected*/
	if (isset($_POST['home'])) {
		$sql1 = "Insert into resume values('folder','".$_SESSION['folder']."') on duplicate key update id = '".$_SESSION['folder']."'";
		$conn->query($sql1);
		unset($_SESSION['folder']);
		unset($_POST['home']);
		session_destroy();
		header("Location: index.php");
	}	
	$conn->query($sql);
	$_SESSION['folder']++;
	
	/*Finishes labelling and sets session variable to 0 on resume table to start from the beginning on the resume command*/
	if(isset($_SESSION['folder']) && is_numeric($_SESSION['folder']))
	{
		if($_SESSION['folder']>=(count($directories))+1)
		{
			$sql1="insert into resume values('folder','0') on duplicate key update id = '0'";
			$conn->query($sql1);
			unset($_SESSION['folder']);
			header("Location: done.php");
			exit();
		}
	}
	$conn->close();
	?>
</body>
</html>
