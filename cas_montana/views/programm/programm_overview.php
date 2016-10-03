<?php ?>

	<html>
		<head>
			<meta charset="UTF-8">
			
			<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  			<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  			
			<title>Programm overview</title>
			
			<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">
			
			<script>
			   $(function() {
			     $("#datepicker, #datepicker2, #datepicker3").datepicker();
			   });
			</script>
			
			<style type="text/css">
				#left {
					text-align: center;
				    float:left;
				    width:400px;
				    height: 300px;
				    background-color : transparent;
				}
								
				#right {
					text-align: center;
				    float:right;
				    width:400px;
				    height: 300px;
				    background-color : transparent;
				}
				
				#top {
					width: 900px;
					display: block;
					text-align: center;
					background-color : transparent;
				}
				
				#near{
					width:30px;
					height:30px;
				}
				
				#search{
					width: 30px;
					height: 30px;
				}
				
				table{
					margin: 0 auto;
				}
			</style>
		</head>
		<body>
			<div style="height: 600px;">
				<h1>Hikinglists</h1>
				<br>
				<div id="top">
					<button><img id="search" src="http://localhost/cas_montana/public/img/search.png" onclick="window.location = 'search_path.php';">search</button>
				</div>
				
				<div id="left">
				  <h2>Single hikes</h2>
				  <table>
					<tr>
					  <td>Choose a day:</td>
					  <td><input type="text" id="datepicker" name="from"></td>
					</tr>	
					<tr>
						<td>Route for the selected day:</td>
						<td>...</td>
					</tr>			   
				  </table>
				</div>
				  
				<div id="right">
				  <h2>multi-day hikes</h2> 
				  <table>
				  	<tr>
				  		<td>Choose date</td>
				  	</tr>
				  	<tr>
					    <td><b>From:</b></td>
					    <td><input type="text" id="datepicker2" name="from"></td>
					</tr>
					<tr>
						<td><b>To:</b></td>
						<td><input type="text" id="datepicker3" name="to"></td>
					</tr>
					<tr>
						<td>Route for the selected stay:</td>
						<td>....</td>
					</tr>
				  </table>
				</div>		  				
			</div>
		</body>
	</html>
		
