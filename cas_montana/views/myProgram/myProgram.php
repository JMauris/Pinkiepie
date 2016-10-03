<?php include_once ROOT_DIR.'global/header.php';


?>


<html>
		<head>
			<meta charset="UTF-8">
			<title>My Programm</title>
			<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">
		</head>
		<body>
			<div style="height: 600px;">
				<h1>Overview of my programm</h1>
				<br>
				<table>
					<tr>
						<td>My registrations</td>
						<td>My favorites</td>
					</tr>
				</table>
			</div>
		</body>
	</html>
<?php
unset($_SESSION['msg']);
include_once ROOT_DIR.'global/footer.php';
?>
