<?php
//loeme andmebaasi login info muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
$database = "if20_tanel_vo_3";
if(isset($_POST["submitnonsens"])) {
	if(!empty($_POST["nonsens"])){
		//andmebaasi lisamine
		//loome andmebaasi ühenduse
		$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		//valmistame ette SQL käsu
		$stmt = $conn->prepare("INSERT INTO nonsense (nonsenseidea) VALUES(?)");
		echo $conn->error;
		//s - string, i -integral, d-decimal
		$stmt->bind_param("s", $_POST["nonsens"]);
		$stmt->execute();
		//käsk ja ühendus kinni
		$stmt->close();
		$conn->close();
	}
}

//loeme andmebaasist
$nonsenshtml= "";
$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
$stmt = $conn->prepare("SELECT nonsenseidea FROM nonsense");
echo$conn->error;
//seome tulemuse mingi muutujaga
$stmt->bind_result($nonsensfromdb);
$stmt->execute();
//võtan, kuni on
while($stmt->fetch()) {
	//<p> suvaline mõte </p>
	$nonsenshtml .= "<p>" .$nonsensfromdb ."</p>";
}
$stmt->close();
$conn->close();


$username = "Tanel Volkov";
$fulltimenow = date ("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg" ;

//vaatame, mida vormist severile saadetakse
var_dump($_POST);

$weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
//küsime nädalapäeva
$weekdaynow = date("N");
//echo $weekdaynow;

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

//loen kataloogist piltide nimekirja;
//$allfiles = scandir("../vp_pics/");
$allfiles = array_slice(scandir("../vp_pics/"), 2);
//var_dump($allfiles); //echo nii tol viisil ei tööta;
//var_dump($allpicfiles);
$allpicfiles = [];
$picfiletypes = ["image/jpeg", "image/png"];
//käin kogu massiivi läbi ja kontrollin iga üksikut elementi, kas on sobiv fail ehk pilt
foreach ($allfiles as $file){
	$fileinfo = getImagesize("../vp_pics/" .$file);
	if(in_array($fileinfo["mime"], $picfiletypes) == true){
		array_push($allpicfiles, $file);
	}
}

//paneme kõik pildid järjest ekraanile
//uurime, mitu pilti on ehk mitu faili on nimekrijas - massiivis
$piccount = count($allpicfiles);
//$i = $i + $i;
//$i ++;
$imghtml = "";
for($i = 0; $i < $piccount; $i ++) {
	$imghtml .= '<img src="../vp_pics/' . $allpicfiles[$i] .'" ';
	$imghtml .= 'alt="Tallinna Ülikool">';
}

require("header.php");
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 
 <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö kaigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna ülikooli</a> Digitehnoloogiate instituudis.</p>
  
<p> Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow-1].", "  .$fulltimenow .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. </p>

<p> Semestri lõpuni on <?php echo $fromsemesterenddays*-1 ?> päeva.</p>

<p> Semester on <?php if($fromsemesterenddays < 0){
	echo($semesteropen = "käimas. ");}
	else {echo("läbi. ");}	
	echo number_format($semesterprocent, 1);?>% semestrist on läbitud. </p>
	
<p><?php echo "Parajasti on " .$partofday. "."; ?> </p>
<hr>
<?php echo $imghtml; ?>
<hr>
<form method="POST">
  <lable> Sisesta oma tänane mõttetu mõte!</label>
  <input type ="text" name="nonsens" placeholder="Mõttekoht">
  <input type="submit" value="Saada ära!" name="submitnonsens">
</form>
<hr> <?php echo $nonsenshtml; ?>
</body>
</html>