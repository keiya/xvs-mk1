<?php

require '../application/config/database.php';

$mysqli = new mysqli($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']) or die('failed to connect db');
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}


if ($historyres = $mysqli->prepare("SELECT xvideos_id,svd_ratio FROM user_history")){
}
$historyres->execute();
$historyres->bind_result($res_id,$svdr);

$video_svdr = array();
while ($historyres->fetch()) {
	$video_svdr[$res_id] += $svdr;
}
$historyres->close();
$score_sql = "REPLACE INTO xvideos_scores (xvideos_id,score) VALUES ";
foreach ($video_svdr as $video_id => $svdr) {
	$score_sql .= '('.$video_id.','.$svdr.'),';
}
$score_sql = substr($score_sql,0,-1);
if ($mysqli->query($score_sql)===TRUE) {
}
