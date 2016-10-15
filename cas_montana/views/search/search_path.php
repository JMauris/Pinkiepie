<?php ?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>search path</title>
		<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">
		<style type="text/css">
			select{
				width: 150px;
			}
				
			#filter{
				width: 400px;
			}

			table {
				margin: 0 auto;
			}
		</style>
	</head>
	<body>
		<div style="height: 600px;">
			<h1>Search</h1>
			<br>
				<table>
					<tr>
						<td>Region:</td>
						<td>
							<select name="region">
								<option value="all">Alle</option>
								<option value="1">Center</option>
								<option value="2">Upper</option>
								<option value="3">Lower</option>
								<option value="4">Outside</option>
								<option value="5">Wallis</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Difficulty:</td>
						<td>
							<select name="difficulty">
								<option value="all">Alle</option>
								<option value="1">*</option>
								<option value="2">**</option>
								<option value="3">***</option>
								<option value="4">****</option>
								<option value="5">*****</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Sort of hike:</td>
						<td>
							<select name="difficulty">
								<option value="all">Alle</option>
								<option value="1">Snowshoeing</option>
								<option value="2">Skitour</option>
								<option value="3">Hiking</option>
								<option value="4">Via Ferrata</option>
								<option value="5">Bike - MTB</option>
								<option value="6">Others</option>
								<option value="7">Winterhiking in the snow</option>
								<option value="8">Alpine hiking</option>
								<option value="9">multiple-day hiking</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Hikings:</td>
						<td>
							<input id="filter" placeholder="Filter the results of your research here, tip in the name of the City" data-type="search">
						</td>
					</tr>
					<tr>
						<td>
							<button>Search</button>
						</td>
					</tr>
				</table>					
		</div>
	</body>
</html>