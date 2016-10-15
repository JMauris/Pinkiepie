<?php include_once ROOT_DIR.'global/header.php';?>

<html>
	<head>
		<title>My proposal</title>
		<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">
		
		<style>
			#left {
				text-align: center;
			    float:left;
			    width:43%;
			    height: 40%;
			    background-color : transparent;
			    overflow-y : scroll;
			}

			#right {
				text-align: center;
			    float:right;
			    width:43%;
			    height: 40%;
			    background-color : transparent;
			    overflow-y : scroll;
			}
						
			p {
			    margin: 0;
			    padding: 0;
			}
			
			button {
				width: 100%;
				text-align: left;
			}
			
			#top {
				float: top;
				background-color : transparent;
				padding-bottom: 5%;
			}
			
			h3 {
				display: inline;
				padding-left: 10%;
			}
		</style>
	</head>
	<body>
		<div style="height: 100%;">
			<h1>My proposal</h1>
			
			<div id="top">
				<h3 style="padding-right: 40%;">My Favorites</h3>
				<h3>My Opinions</h3>
			</div>
			
			<div id="left">
				<a href="http://localhost/cas_montana/views/proposal/proposal_detail.php">
					<button id="0">
						<p>Name</p>
						<p>Description..........................</p>
					</button>
				</a>
				<a href="http://localhost/cas_montana/views/proposal/proposal_detail.php">
					<button id="1">
						<p>Name</p>
						<p>Description..........................</p>
					</button>
				</a>
				<a href="http://localhost/cas_montana/views/proposal/proposal_detail.php">
					<button id="0">
						<p>Name</p>
						<p>Description..........................</p>
					</button>
				</a>
				<a href="http://localhost/cas_montana/views/proposal/proposal_detail.php">
					<button id="1">
						<p>Name</p>
						<p>Description..........................</p>
					</button>
				</a>
			</div>
			
			<div id="right">
			
			</div>
			
		</div>
	</body>
</html>

<?php unset($_SESSION['msg']); include_once ROOT_DIR.'global/footer.php';?>
