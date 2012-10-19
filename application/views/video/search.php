<div id='options'>
<label><input type='checkbox' class='opt chkbox' name='openAnotherWindow' checked />リンクを別画面で表示</label>
<label>動画の長さ:<input type='range' class='opt filter' name='minLength' min='60' max='1800' value='60' /><span id='timeminlength'></span></label>
</div>
<div id='search' class='clearfix'>
<?php
$i=0;
foreach ($datas as $data) {
	++$i;
	if ($i>60) {$next_page = TRUE;break;}
	else {$next_page = FALSE;}
?>
<a class='thumb_box' href="/video/<?php echo $data->id; ?>" data-sec="<?php echo $data->duration; ?>">
		<img src="<?php echo $data->thumb_uri; ?>" width='180' height='135' alt='<?php echo $data->title; ?>' />
	</a>
<?php } ?>
<?php if (isset($next_page) && $next_page === TRUE) { ?>
<noscript>
	<a id='next_block' class='thumb_box' href="/video/search_tag/<?php echo $query; ?>/<?php echo $current_page+1; ?>">NEXT</a>
</noscript>
<?php } ?>
</div>
<script type='text/x-ktempl' id='video_minlength'>
	<strong>{min_int}.</strong><em>{min_float}</em> 分以上
</script>
<script>XVS.searchQuery = <?php echo isset($query)?'\''.$query.'\'':0; ?>;XVS.currentPage = <?php echo $current_page; ?>;</script>
