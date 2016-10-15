<?php include_once ROOT_DIR.'global/header.php';?>

<html>
	<head>
		<title>Proposal</title>
		<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">
		<style type="text/css">
			#show{
				overflow-y : scroll;
				background-color : transparent;
				height: 60%;
			}

			button {
				width: 100%;
				text-align: left;
			}

			h2 {
				text-align: center;
			}

			p {
			    margin: 0;
			    padding: 0;
			}

			#search, #near {
				display:inline-block;
				width: 5%;
			}

		</style>
	</head>
	<body>
		<div style="height: 100%">
			<h1>Proposal</h1>
			<h2>These are our Proposals for you:</h2>
			<div id="show">
			<a href="<?php echo URL_DIR.'proposal/proposal_detail'?>">
					<button id="0">
						<p>Name</p>
						<p>Description..........................</p>
					</button>
				</a>
				<a href="<?php echo URL_DIR.'proposal/proposal_detail'?>">
					<button id="1">
						<p>Name</p>
						<p>Description..........................</p>
					</button>
				</a>
			</div>
			<button id="search">Search</button>
			<button id="near">Near us</button>
		</div>
	</body>
</html>

<?php unset($_SESSION['msg']); include_once ROOT_DIR.'global/footer.php'; ?>
