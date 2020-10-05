<?php
$username = "Tanel Volkov";
$time = date ("H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg" ;
$dayofmonth = date ("d");
$year = date ("Y");


$weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
//küsime nädalapäeva
$weekdaynow = date("N");
//echo $weekdaynow;
$monthnow = date("m");

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
$semesterprocent = 100*$fromsemesterstartdays/103;

$dir = '../vp_pics/';
$imgs_arr = array();
if (file_exists($dir) && is_dir($dir) ) {
    // Run code if the directory exists
 }

$dir_arr = scandir($dir);
$arr_files = array_diff($dir_arr, array('.','..') );
foreach ($arr_files as $file) {
  //Get the file path
  $file_path = $dir."/".$file;
  // Get extension
  $ext = pathinfo($file_path, PATHINFO_EXTENSION);
  if ($ext=="jpg" || $ext=="png" || $ext=="JPG" || $ext=="PNG") {
    array_push($imgs_arr, $file);
  }
  
}
$count_img_index = count($imgs_arr) - 1;
$random_img = $imgs_arr[rand( 0, $count_img_index )];

require("header.php");
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
<p> </p>
 
 <ul>
	<li><a href="page2.php">Uus mõte</a></li>
	<li><a href="page3.php">Varasemad mõtted</a></li>
	<li><a href="listfilms.php">Filmiinfo näitamine</a></li>
 </ul>
 
 <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna ülikooli</a> Digitehnoloogiate instituudis.</p>
  
<p> Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow-1].", ". $dayofmonth.". ". $monthnameset[$monthnow-1]." ". $year .", kell ".$time .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. </p>

<p> Semestri lõpuni on <?php echo $fromsemesterenddays*-1 ?> päeva.</p>


<p> Semester on <?php if($fromsemesterenddays < 0){
	echo($semesteropen = "käimas. ");}
	else {echo("läbi. ");}	
	echo number_format($semesterprocent, 1);?>% semestrist on läbitud. </p>
	
<p><?php echo "Parajasti on " .$partofday. "."; ?> </p>

<img src="<?php echo $dir."/".$random_img ?>">

</form>
</body>
</html>