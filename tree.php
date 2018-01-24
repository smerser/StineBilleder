<?php
	include('login.php');
	// REMOVE SESSIONS FILES OLDER THAN ONE HOUR
	$fileSystemIterator = new FilesystemIterator('../../stine_sessions');
	$now = time();
	foreach ($fileSystemIterator as $file) {
		if ($now - $file->getCTime() >= 60 * 60) // 1 hour
			unlink('.sessions/'.$file->getFilename());
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


	<head>
		<title>Billedfremviser</title>
		<meta charset="UTF-8">
		<meta name="author" content="Soren Merser">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1">


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="static/js/jquery/jquery.easing.js" type="text/javascript"></script>
		<script src="static/js/jquery/jqueryFileTree.js" type="text/javascript"></script>
		<link  href="static/js/jquery/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
		<link  href="static/css/tree.css" rel="stylesheet" type="text/css" media="screen" />


		<script type="text/javascript">

			$(document).ready( function() {

				$('#fileTree').fileTree({ root: '../../../../Fotos/', script: 'static/js/jquery/connectors/jqueryFileTree.php' }, function(file) {
					var w = $(window).width();
					var h = $(window).height();
					$('#img').attr('src', file.substr(12)).show();
					$('#wrapper').attr({display:'display'}).width(w).height(h).show();
					$('div#fileTree, #PPOnFly, #col').attr({display:'none'}).hide();
				});

				$('#img').click(function() {
					$('#wrapper').removeAttr('style').hide();
					$('div#fileTree, #PPOnFly, #col').attr({display:'display'}).show();
				});

			});

		</script>

	</head>


	<body>

		<?php
			$display = 'none';
			if(($is_ok = checklogin())){
				$display = 'display';
			}
		?>

		<div id="PPOnFly" style="text-align: center; padding: 20px; ">
			<img data-scalestrategy="crop" width="300" height="88" src="static/img/PPOnFly.png">
		</div>

		<div id="directory" style="display:<?php echo $display; ?>">
			<h1 id="col">Fotoarkiv</h1>
			<div id="fileTree" class="demo"></div>
		<div/></div>

		<div id="wrapper" style="display:<?php echo $display; ?>">
			<img id="img" src="" alt="">
		</div>

	</body>
<html>


