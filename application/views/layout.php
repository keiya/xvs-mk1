<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="/static/reset.css" type="text/css" />
	<link rel="stylesheet" href="/static/style.css" type="text/css" />
</head>
<body>
<script src='/static/jquery-1.8.2.min.js'></script>
<script src='/static/loader.js'></script>
<?php echo $body; ?>
<footer>
<div id='logo'></div>
</footer>
<script>
new XVS('<?php echo $jsmethod; ?>');
</script>
</body>
</html>
