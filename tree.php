<?php
	include('login.php');

	// CLEAR SESSIONS FILES OLDER THAN ONE HOUR --- NEEDS CHECK
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
		<title>jQuery File Tree Browser</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="static/js/jquery/jquery.easing.js" type="text/javascript"></script>
		<script src="static/js/jquery/jqueryFileTree.js" type="text/javascript"></script>
		<link  href="static/js/jquery/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
		<link  href="static/css/tree.css" rel="stylesheet" type="text/css" media="screen" />

		<script type="text/javascript">

			$(document).ready( function() {

				$('#fileTree').fileTree({ root: '../../../../Fotos/', script: 'static/js/jquery/connectors/jqueryFileTree.php' }, function(file) {
					$('#img').attr("src", file.substr(12)).show();
					$('#overlayContent').show();
					$('#overlay').show();
				});

				$('#img').click(function() {
					$('#img').attr("src", "").hide();
					$('#overlay').css('display', 'none').hide();
					$('#overlayContent').css('overflow', 'hidden').hide();
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

		<div style="text-align: center; padding: 20px; ">
			<img data-scalestrategy="crop" width="300" height="88" src="static/img/PPOnFly.png">
		</div>

		<div id="wrapper" style="display:<?php echo $display; ?>">
			<div id="overlayContent"><img id="img" src="" alt="" width="100%" ></div>
		</div>

		<div class="example" style="display:<?php echo $display; ?>">
			<h1>Fotokatalog</h1>
			<div id="fileTree" class="demo"></div>
		</div>

	</body>
<html>


