<?php include("include_header.php");?>
<main class="cd-main-content">
		<div class="cd-scrolling-bg cd-color-2">
			<div class="cd-container">
				<h1 class="clr1">ஆசிரியர்கள்</h1>
				<div class="alphabet gapBelowSmall gapAboveSmall">
					<span class="letter"><a href="authors.php?letter=அ">அ</a></span>
					<span class="letter"><a href="authors.php?letter=ஆ">ஆ</a></span>
					<span class="letter"><a href="authors.php?letter=இ">இ</a></span>
					<span class="letter"><a href="authors.php?letter=ஈ">ஈ</a></span>
					<span class="letter"><a href="authors.php?letter=உ">உ</a></span>
					<span class="letter"><a href="authors.php?letter=ஊ">ஊ</a></span>
					<span class="letter"><a href="authors.php?letter=எ">எ</a></span>
					<span class="letter"><a href="authors.php?letter=ஏ">ஏ</a></span>
					<span class="letter"><a href="authors.php?letter=ஐ">ஐ</a></span>
					<span class="letter"><a href="authors.php?letter=ஒ">ஒ</a></span>
					<span class="letter"><a href="authors.php?letter=ஓ">ஓ</a></span>
					<span class="letter"><a href="authors.php?letter=ஔ">ஔ</a></span>
					<span class="letter"><a href="authors.php?letter=க">க</a></span>
					<span class="letter"><a href="authors.php?letter=ங">ங</a></span>
					<span class="letter"><a href="authors.php?letter=ச">ச</a></span>
					<span class="letter"><a href="authors.php?letter=ஜ">ஜ</a></span>
					<span class="letter"><a href="authors.php?letter=ஞ">ஞ</a></span>
					<span class="letter"><a href="authors.php?letter=ட">ட</a></span>
					<span class="letter"><a href="authors.php?letter=ண">ண</a></span>
					<span class="letter"><a href="authors.php?letter=த">த</a></span>
					<span class="letter"><a href="authors.php?letter=ந">ந</a></span>
					<span class="letter"><a href="authors.php?letter=ன">ன</a></span>
					<span class="letter"><a href="authors.php?letter=ப">ப</a></span>
					<span class="letter"><a href="authors.php?letter=ம">ம</a></span>
					<span class="letter"><a href="authors.php?letter=ய">ய</a></span>
					<span class="letter"><a href="authors.php?letter=ர">ர</a></span>
					<span class="letter"><a href="authors.php?letter=ற">ற</a></span>
					<span class="letter"><a href="authors.php?letter=ல">ல</a></span>
					<span class="letter"><a href="authors.php?letter=ள">ள</a></span>
					<span class="letter"><a href="authors.php?letter=ழ">ழ</a></span>
					<span class="letter"><a href="authors.php?letter=வ">வ</a></span>
					<span class="letter"><a href="authors.php?letter=ஶ">ஶ</a></span>
					<span class="letter"><a href="authors.php?letter=ஷ">ஷ</a></span>
					<span class="letter"><a href="authors.php?letter=ஸ">ஸ</a></span>
					<span class="letter"><a href="authors.php?letter=ஹ">ஹ</a></span>
					<span class="letter"><a href="authors.php?letter=other">#</a></span>
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
	$query = "SELECT * FROM author WHERE authorname REGEXP '^[A-Za-z]' order by authorname";
}
else
{
	$query = "select * from author where authorname like '$letter%'  union select * from author where authorname like '\"$letter%' union select * from author where authorname like '\'$letter%' order by TRIM(BOTH '\'' FROM TRIM(BOTH '\"' FROM authorname))";
}

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		echo '<div class="author">';
		echo '	<span class="aAuthor"><a href="auth.php?authid=' . $row['authid'] . '&amp;author=' . urlencode($row['authorname']) . '">' . $row['authorname'] . '</a> ';
		echo '</div>';
	}
}
else
{
	echo '<span class="sml">கடிதம் \'' . $letter . '\' என்று ஆரம்பத்தில் எந்த ஆசிரியர்கள் உள்ளன';
}
//~ Kaṭitam' A' eṉṟu ārampattil enta āciriyarkaḷ uḷḷaṉa

if($result){$result->free();}
$db->close();

?>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
