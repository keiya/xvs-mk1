<div id='title'>
	<h1><?php echo $datas[0]->title; ?></h1>
</div>
<div id='player'>
<?php if ($ismobile) { ?>
	<iframe id='embed' src="http://flashservice.xvideos.com/embedframe/<?php echo $datas[0]->id; ?>" width="854" height="480"></iframe>
<?php } else { ?>
	<?php echo $datas[0]->embed_tag; ?>
<?php } ?>
</div>
<div id='info'>
	<?php foreach ($datas as $data) { ?>
		<?php echo $data->tag; ?>
	<?php } ?>
</div>
<script>XVS.videoId = '<?php echo $datas[0]->id; ?>';</script>
