<?php include_once ROOT_DIR.'global/header.php';
 $tourArray=$_SESSION['tour'];

?>

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
			    width:43%;
			    height: 40%;
			    background-color : transparent;
			}

			#right {
				text-align: center;
			    float:right;
			    width:43%;
			    height: 40%;
			    background-color : transparent;
			}

			#top {
				width: 80%;
				display: block;
				text-align: center;
				background-color : transparent;
			}

			#bottom {
				float: bottom;
				background-color : transparent;
				height: 150px;
				overflow-y : scroll;
			}

			#search{
				width: 15%;
				height: 15%;
			}

			table {
				margin: 0 auto;
				text-align: left;
			}

			h3 {
				padding-left: 10%;
			}

		</style>
	</head>
	<body>
		<div style="height: 110%;">
			<h1>Hikinglists</h1>
			<br>
			<div id="top">
				<button><img id="search" src="http://localhost/cas_montana/public/img/search.png" onclick="window.location = 'search_path.php';">search route</button>
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
			  <button id="submit1" onclick="window.location = '';">only hike</button>
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
			  <button id="submit2" onclick="window.location = '';">only multi-hike</button>
			</div>

			<h3>Your Programm:</h3>
			<div id="bottom">
				<table class="table table-bordered">

					 <tr>
              <th> Type </th>
						 <th> Titre </th>
						 <th> Information </th>
						 <th> Depart</th>
						 <th> Date debut </th>


					 </tr>
					 <?php foreach( $tourArray as $cle => $element)

					 {?>
					 <tr>
	            <td><?php if( $tourArray[$cle]->getIdxTypeTour() == 1){
                echo "Hiking";
              }
              elseif ($tourArray[$cle]->getIdxTypeTour() == 2) {
                echo "Stay";
              }
              else {
                echo "Proposal";
              } ?> </td>
					<td><?php echo  $tourArray[$cle]->getTitre(); ?> </td>
					<td><?php echo  $tourArray[$cle]->getInformation_fr(); ?> </td>
					<td><?php echo  $tourArray[$cle]->getIdxDepartLocalite(); ?> </td>
					<td><?php echo  $tourArray[$cle]->getDateDebut(); ?> </td>



					<?php } ?>
					</tr>
			</table>
			</div>
		</div>
	</body>
</html>

<?php unset($_SESSION['msg']); include_once ROOT_DIR.'global/footer.php'; ?>
