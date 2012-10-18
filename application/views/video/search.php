<div id='options'>
<label><input type='checkbox' id='opt-openAnotherWindow' checked />リンクを別画面で表示</label>
</div>
<div id='search' class='clearfix'>
<?php
$i=0;
foreach ($datas as $data) {
	++$i;
	if ($i>60) {$next_page = TRUE;break;}
	else {$next_page = FALSE;}
?>
	<a class='thumb_box' href="/video/<?php echo $data->id; ?>">
		<img src="<?php echo $data->thumb_uri; ?>" width='180' height='135' alt='<?php echo $data->title; ?>' />
	</a>
<?php } ?>
<?php if ($next_page === TRUE) { ?>
<noscript>
	<a id='next_block' class='thumb_box' href="/video/search_tag/<?php echo $query; ?>/<?php echo $current_page+1; ?>">NEXT</a>
</noscript>
<?php } ?>
</div>
<script>XVS.searchQuery = <?php echo isset($query)?'\''.$query.'\'':0; ?>;XVS.currentPage = <?php echo $current_page; ?>;</script>
