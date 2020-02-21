<!DOCTYPE html>
<html>
<head>
	<title>
		Select Custom Labels
		<?php 
		session_name('test');
		session_start(); ?>
	</title>
</head>
<body>
	<form method='post' id="ele" name="f1">
		Enter the number of labels you need:<br>
		<input type="number" name="number">
		<input type="submit" name="Submit" value="Submit">
		<br>
		<br>
		<br id="last">
	</form>
	<?php 
	if(isset($_POST['Submit']))
	{
		$value=$_POST['number'];
		print $value;
		$_SESSION['total']=$value;
	} ?>
	<form method='post' id="final" name="f2" action="index.php">
		Type Your Labels:<br>
		<input type="hidden" name="total" value="<?php echo $value ?>"> <!-- Posts the value to index.php -->
		
	</form>
	<script type="text/javascript">
		var val = <?php echo $value ?>;
		/*JS function to dynamically generate textboxes according to the number received from post*/
		function add(){
			for(var i=0;i<val;i++)
			{	
				var element = document.createElement("input");
				var br = document.createElement("br");
				element.setAttribute("name","textfield"+(i+1));
				element.setAttribute("type","text");
				var elementAbove = document.getElementById("final");
				elementAbove.appendChild(element);
				elementAbove.appendChild(br);
			}
			var submit = document.createElement("input");
			submit.setAttribute("name","formsubmit");
			submit.setAttribute("type","submit");
			submit.setAttribute("value","Submit and Go Home");
			elementAbove.appendChild(submit);		}
		add();
	</script>

</body>
</html>