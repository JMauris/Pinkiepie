<?php include_once ROOT_DIR.'global/header.php';

?>
<html>
		<head>
			<meta charset="UTF-8">
			<title>Home</title>
			<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">
		</head>
		<body>
			<div style="height: 600px;">
				<h1>Our Proposal</h1>
				<div id="proposedlist">
					<h2>List of propsed hiking places</h2>
					<div id="button">
						<a href="/<?php echo SITE_NAME; ?>/views/programm/search_path.php"><button type="button">Search</button></a>
						
					</div>
					<div id="searchForm" class="ui-input-search ui-shadow-inset ui-btn-corner-all ui-btn-shadow ui-icon-searchfield ui-body-c">
					<input placeholder="Affiner le résultat de votre recherche en tapant ici le nom d’une localité" data-type="search" class="ui-input-text ui-body-c">
					<a href="#" class="ui-input-clear ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-fullsize ui-btn-icon-notext ui-input-clear-hidden" title="clear text" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-icon="delete" data-iconpos="notext" data-theme="c" data-mini="false">
					<span class="ui-btn-inner ui-btn-corner-all">
					<span class="ui-btn-text">clear text</span>
					<span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span>
					</span>
					</a>
					</div>
				<a style="display:block" href="<?php echo URL_DIR.'contact/contact'?>">
				<div id="list">
					<ul>
                	<li>
					<strong>Valais</strong>
					<h3 class="ui-li-heading">Horlini (2451)</h3>
					<p class="ui-li-desc">
					<strong>
					D'Albinen en passant par Chermignon, superbe sortie de début de saison. 3 heures de montée sans difficulté particulière
					</strong>
					</p>
                	</li>
            	</ul>
            	</div>
            	</a>
				</div>
			</div>
		</body>
	</html>




<?php
unset($_SESSION['msg']);
include_once ROOT_DIR.'global/footer.php';
?>
