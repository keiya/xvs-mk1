<div id='eyecatch'></div>
<div id='videos'>
<h1>新着</h1>
<div class='topbox clearfix'>
<?php foreach ($datas['new'] as $data) { ?>
	<a class='thumb_box' href="/video/<?php echo $data->id; ?>">
		<img src="<?php echo $data->thumb_uri; ?>" width='180' height='135' alt='<?php echo $data->title; ?>' />
	</a>
<?php } ?>
<a href='/video' class='rarrow'></a>
</div>
<h1>人気</h1>
<div class='topbox clearfix'>
<?php foreach ($datas['high'] as $data) { ?>
	<a class='thumb_box' href="/video/<?php echo $data->id; ?>">
		<img src="<?php echo $data->thumb_uri; ?>" width='180' height='135' alt='<?php echo $data->title; ?>' />
	</a>
<?php } ?>
<a href='/video/rank' class='rarrow'></a>
</div>

</div>
