<?php
$username = "Tanel Volkov";
$fulltimenow = date ("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg" ;
if($hournow < 6){
	$partofday = "uneaeg";
}
if($hournow >= 7 and $hournow < 8) {
	$partofday = "Hommikuste protseduuride aeg";
}
if($hournow >= 8 and $hournow < 16) {
	$partofday = "Õppimise aeg";
}
if($hournow >= 16 and $hournow < 21) {
	$partofday = "Töövahetus";
}
if($hournow >= 21 and $hournow < 0) {
	$partofday = "Vaba aeg";
}

//jälgime semestri kulgu
$semesterstart = new DateTime("2020-8-31");
$semesterend = new DateTime("2020-12-13");
$semesterduration = $semesterstart->diff($semesterend);
$today = new DateTime("now");
$fromsemesterstart = $semesterstart->diff($today); //Saime aja erinevuse objektiivina, seda niisama näidata ei saa
$fromsemesterstartdays = $fromsemesterstart->format("%r%a");
$fromsemesterend = $semesterend->diff($today);
$fromsemesterenddays = $fromsemesterend->format("%r%a");

$semesterprocent = 100*$fromsemesterstartdays/103

?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Teet Margna Blogi</title>

</head>
<body>
<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 
 <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna ülikooli</a> Digitehnoloogiate instituudis.</p>
  
<p> Lehe avamise aeg: <?php echo $fulltimenow .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. </p>

<p> Semestri lõpuni on <?php echo $fromsemesterenddays*-1 ?> päeva.</p>

<p> Semester on <?php if($fromsemesterenddays < 0){
	echo($semesteropen = "käimas. ");}
	else {echo("läbi. ");}	
	echo number_format($semesterprocent, 1);?>% semestrist on läbitud. </p>
	
<p><?php echo "Parajasti on " .$partofday. "."; ?> </p>
</body>
</html>