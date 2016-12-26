<?php include("include_header.php");?>
<main class="cd-main-content">
		<div class="cd-scrolling-bg cd-color-2">
			<div class="cd-container">
				<h1 class="clr1">கட்டுரைகள்</h1>
 				<div class="alphabet gapBelowSmall gapAboveSmall">
					<span class="letter"><a href="articles.php?letter=அ">அ</a></span>
					<span class="letter"><a href="articles.php?letter=ஆ">ஆ</a></span>
					<span class="letter"><a href="articles.php?letter=இ">இ</a></span>
					<span class="letter"><a href="articles.php?letter=ஈ">ஈ</a></span>
					<span class="letter"><a href="articles.php?letter=உ">உ</a></span>
					<span class="letter"><a href="articles.php?letter=ஊ">ஊ</a></span>
					<span class="letter"><a href="articles.php?letter=எ">எ</a></span>
					<span class="letter"><a href="articles.php?letter=ஏ">ஏ</a></span>
					<span class="letter"><a href="articles.php?letter=ஐ">ஐ</a></span>
					<span class="letter"><a href="articles.php?letter=ஒ">ஒ</a></span>
					<span class="letter"><a href="articles.php?letter=ஓ">ஓ</a></span>
					<span class="letter"><a href="articles.php?letter=ஔ">ஔ</a></span>
					<span class="letter"><a href="articles.php?letter=க">க</a></span>
					<span class="letter"><a href="articles.php?letter=ங">ங</a></span>
					<span class="letter"><a href="articles.php?letter=ச">ச</a></span>
					<span class="letter"><a href="articles.php?letter=ஜ">ஜ</a></span>
					<span class="letter"><a href="articles.php?letter=ஞ">ஞ</a></span>
					<span class="letter"><a href="articles.php?letter=ட">ட</a></span>
					<span class="letter"><a href="articles.php?letter=ண">ண</a></span>
					<span class="letter"><a href="articles.php?letter=த">த</a></span>
					<span class="letter"><a href="articles.php?letter=ந">ந</a></span>
					<span class="letter"><a href="articles.php?letter=ன">ன</a></span>
					<span class="letter"><a href="articles.php?letter=ப">ப</a></span>
					<span class="letter"><a href="articles.php?letter=ம">ம</a></span>
					<span class="letter"><a href="articles.php?letter=ய">ய</a></span>
					<span class="letter"><a href="articles.php?letter=ர">ர</a></span>
					<span class="letter"><a href="articles.php?letter=ற">ற</a></span>
					<span class="letter"><a href="articles.php?letter=ல">ல</a></span>
					<span class="letter"><a href="articles.php?letter=ள">ள</a></span>
					<span class="letter"><a href="articles.php?letter=ழ">ழ</a></span>
					<span class="letter"><a href="articles.php?letter=வ">வ</a></span>
					<span class="letter"><a href="articles.php?letter=ஶ">ஶ</a></span>
					<span class="letter"><a href="articles.php?letter=ஷ">ஷ</a></span>
					<span class="letter"><a href="articles.php?letter=ஸ">ஸ</a></span>
					<span class="letter"><a href="articles.php?letter=ஹ">ஹ</a></span>
					<span class="letter"><a href="articles.php?letter=other">#</a></span>
				</div>
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['letter']))
{
 	$letter=$_GET['letter'];
	
 	if(!(isValidLetter($letter)))
 	{
 		echo '<span class="aFeature clr2">Invalid URL</span>';
 		echo '</div> <!-- cd-container -->';
 		echo '</div> <!-- cd-scrolling-bg -->';
 		echo '</main> <!-- cd-main-content -->';
 		include("include_footer.php");

         exit(1);
 	}
	
 	($letter == '') ? $letter = 'அ' : $letter = $letter;
 }
 else
 {
 	$letter = 'அ';
 }
if($letter == 'other')
{
	$query = "SELECT * FROM article WHERE title REGEXP '^[A-Za-z0-9]'";
}
else
{
	$query = "select * from article where title like '$letter%'  union select * from article where title like '\"$letter%' union select * from article where title like '\'$letter%' order by TRIM(BOTH '\'' FROM TRIM(BOTH '\"' FROM title))";
}

//$query = "SELECT * FROM article ORDER BY TRIM(BEGIN '\"' FROM title)";
//$query = "SELECT * FROM article ORDER BY TRIM(BOTH '\'' FROM TRIM(BOTH '\"' FROM title))";


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
		$info = '';
		if($row['month'] != '')
		{
			$info = $info . getMonth($row['month']);
		}
		if($row['year'] != '')
		{
			$info = $info . ' <span class="font_size">' . $row['year'] . '</span>';
		}
		if($row['info'] != '')
		{
			$info = $info . ', ' . $row['info'] . '&nbsp;';
		}
		$info = preg_replace("/^,/", "", $info);
		$info = preg_replace("/^ /", "", $info);

		
		if($result3){$result3->free();}

		echo '<div class="article">';
		echo '	<div class="gapBelowSmall">';
		echo ($row3['feat_name'] != '') ? '		<span class="aFeature clr2"><a href="feat.php?feature=' . urlencode($row3['feat_name']) . '&amp;featid=' . $row['featid'] . '">' . $row3['feat_name'] . '</a></span> | ' : '';
		if($info != '')
		{
			echo '<span class="aIssue clr5"><a href="toc.php?vol=' . $row['volume'] . '&amp;issue=' . $row['issue'] . '">மலர் ' . intval($row['volume']) . ', இதழ் ' . $dissue . ' <span class="font_resize">(' . $info . ')</span></a></span>';
		}
		else
		{
			echo '<span class="aIssue clr5"><a href="toc.php?vol=' . $row['volume'] . '&amp;issue=' . $row['issue'] . '">மலர் ' . intval($row['volume']) . ', இதழ் ' . $dissue . '</a></span>';
		}
		echo '	</div>';
		echo '	<span class="aTitle"><a target="_blank" href="../Volumes/djvu/' . $row['volume'] . '/' . $row['issue'] . '/index.djvu?djvuopts&amp;page=' . $row['page'] . '.djvu&amp;zoom=page">' . $row['title'] . '</a></span><br />';
		if($row['authid'] != 0) {

			echo '	<span class="aAuthor">&nbsp;&nbsp;&mdash;';
			$authids = preg_split('/;/',$row['authid']);
			$authornames = preg_split('/;/',$row['authorname']);
			$a=0;
			foreach ($authids as $aid) {

				echo '<a href="auth.php?authid=' . $aid . '&amp;author=' . urlencode($authornames[$a]) . '">' . $authornames[$a] . '</a> ';
				$a++;
			}
			
			echo '	</span><br/>';
		}
		echo '<span class="downloadspan"><a target="_blank" href="downloadPdf.php?titleid='.$titleid.'">Download Pdf</a></span>';
		echo '</div>';
	}
}
else
{
	echo '<span class="sml">கடிதம் \'' . $letter . '\' என்று ஆரம்பத்தில் எந்த கட்டுரைகள் உள்ளன';
}
//~ Kaṭitam' A' eṉṟu ārampattil enta kaṭṭuraikaḷ uḷḷaṉa
if($result){$result->free();}
$db->close();

?>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
