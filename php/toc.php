<?php include("include_header.php");?>
<main class="cd-main-content">
		<div class="cd-scrolling-bg cd-color-2">
			<div class="cd-container">
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['vol'])){$volume = $_GET['vol'];}else{$volume = '';}
if(isset($_GET['issue'])){$issue = $_GET['issue'];}else{$issue = '';}

$dissue = preg_replace("/^0/", "", $issue);
$dissue = preg_replace("/\-0/", "-", $dissue);

$yearMonth = getYearMonth($volume, $issue);
$info = getinfo($volume, $issue);
$head = '';

if($yearMonth['month'] != '')
{
	$head = $head . getMonth($yearMonth['month']);
}
if($yearMonth['year'] != '')
{
	$head = $head . ' <span style="font-size: 0.9em;">' . $yearMonth['year'] . '</span>';
}
if($info['info'] != '')
{
	$head = $head . ', ' . $info['info'] . '';
}

$head = preg_replace("/^,/", "", $head);
$head = preg_replace("/^ /", "", $head);
if($head != '')
{
	echo '<h1 class="clr1 gapBelowSmall">மலர் ' . intval($volume) . ', இதழ் ' . $dissue . ' <span style="font-size: 0.85em">(' . $head . ')</span></h1>';
}else
{
	echo '<h1 class="clr1 gapBelowSmall">மலர் ' . intval($volume) . ', இதழ் ' . $dissue . '</h1>';

}


if(!(isValidVolume($volume) && isValidissue($issue)))
{
	echo '<span class="aFeature clr2">Invalid URL</span>';
	echo '</div> <!-- cd-container -->';
	echo '</div> <!-- cd-scrolling-bg -->';
	echo '</main> <!-- cd-main-content -->';
	include("include_footer.php");

    exit(1);
}

$query = 'select * from article where volume=\'' . $volume . '\' and issue=\'' . $issue . '\'';

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$query3 = 'select feat_name from feature where featid=\'' . $row['featid'] . '\'';
		$result3 = $db->query($query3); 
		$row3 = $result3->fetch_assoc();
		$titleid = $row['titleid'];
		$dissue = preg_replace("/^0/", "", $row['issue']);
		$dissue = preg_replace("/\-0/", "-", $dissue);
		
		if($result3){$result3->free();}

		echo '<div class="article">';
		echo ($row3['feat_name'] != '') ? '<div class="gapBelowSmall"><span class="aFeature clr2"><a href="feat.php?feature=' . urlencode($row3['feat_name']) . '&amp;featid=' . $row['featid'] . '">' . $row3['feat_name'] . '</a></span></div>' : '';
		echo '	<span class="aTitle"><a target="_blank" href="../Volumes/djvu/' . $row['volume'] . '/' . $row['issue'] . '/index.djvu?djvuopts&amp;page=' . $row['page'] . '.djvu&amp;zoom=page">' . $row['title'] . '</a></span><br />';
		if($row['authid'] != 0) {

			echo '<span class="aAuthor">&nbsp;&nbsp;&mdash;';
			$authids = preg_split('/;/',$row['authid']);
			$authornames = preg_split('/;/',$row['authorname']);
			$a=0;
			foreach ($authids as $aid)
			{
				echo '<a href="auth.php?authid=' . $aid . '&amp;author=' . urlencode($authornames[$a]) . '">' . $authornames[$a] . '</a> ';
				$a++;
			}
			
			echo '</span><br/>';
		}
		echo '<span class="downloadspan"><a target="_blank" href="downloadPdf.php?titleid='.$titleid.'">Download Pdf</a></span>';
		echo '</div>';
	}
}

if($result){$result->free();}
$db->close();

?>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
