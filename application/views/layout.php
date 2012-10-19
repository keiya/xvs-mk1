<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="/static/reset.css" type="text/css" />
	<link rel="stylesheet" href="/static/style.css" type="text/css" />
	<title><?php if (!empty($title)) {echo $title.' - ';} ?>Shibuya Erotic Samurai [渋谷のエロい侍]</title>
</head>
<body>
<header>
<a id='logo' href='/'></a>
<nav>
	<ul>
		<li><a href="/video">新着</a></li>
		<li><a href="/rank">人気</a></li>
	</ul>
</nav>
</header>
<script src='/static/jquery-1.8.2.min.js'></script>
<script src='/static/ktempl.js'></script>
<script src='/static/klibs.js'></script>
<script src='/static/loader.js'></script>
<?php echo $body; ?>
<hr />
<footer>
<a href='/docs/site'>当サイトについて</a> |
<a href='/docs/rule'>利用規約</a> |
<a href='/docs/algorithm'>リコメンデーション・アルゴリズム</a> |
<a href='/static/ShibuyaEroticSamurai.apk'>Androidアプリ</a>
</footer>
<script>
new XVS('<?php echo isset($jsmethod)?$jsmethod:''; ?>');
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35589580-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</script>
</body>
</html>
