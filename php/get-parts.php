<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['volume'])){$volume = $_GET['volume'];}else{$volume = '';}

if(!(isValidVolume($volume)))
{
	exit(1);
}

$query = "select distinct issue,month from article where volume='$volume' order by issue";
$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

echo '<div id="issueHolder" class="issueHolder"><div class="issue">';

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$dpart = preg_replace("/^0/", "", $row['issue']);
		$dpart = preg_replace("/\-0/", "-", $dpart);
		echo '<div class="aIssue"><a href="toc.php?vol=' . $volume . '&amp;issue=' . $row['issue'] . '">இதழ் ' . $dpart . '</a></div>';
	}
}

echo '</div></div>';

if($result){$result->free();}
$db->close();

?>
