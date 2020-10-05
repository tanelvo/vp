<?php
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");

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

$email="";
$emailerror="";
$passworderror="";
$notice="";
$formerror = null;
$emailerror = null;
$pwderror = null;

  if(isset($_POST["usersubmit"])) {
	  if(empty($_POST["emailinput"])) {
        $emailerror = "Kasutajatunnus on sisestamata!";
      }
    else {
      $email = filter_var(test_input($_POST["emailinput"]), FILTER_VALIDATE_EMAIL);
    }
	  
	  if(empty($_POST["passwordinput"])) {
        $pwderror = "Salasõna on sisestamata!";
      }
      if(!empty($_POST["passwordinput"]) and strlen($_POST["passwordinput"]) < 8) {
        $pwderror = "Liiga lühike salasõna! (" . strlen($_POST["passwordinput"]) . " märki 8 asemel)";
      }

    if(empty($emailerror) and empty($pwderror)) {
      $result = signin($email, $_POST["passwordinput"]);
      // if($result == "OK") {
      //   $notice = "Sisse logimine õnnestus!";
      //   $email = "";
      // }
      // else {
        $formerror = $result;
      // }
  
    }
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
 
 
 <h1>Sisse logimine</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="emailinput">Kasutajatunnus (email): </label><br>
	<input type="email" name="emailinput" id="emailinput" placeholder="Email" value="<?php echo $email; ?>"><span><?php echo $emailerror . "<br />"; ?></span>
	<label for="passwordinput">Salasõna: </label><br>
	<input type="password" name="passwordinput" id="passwordinput" placeholder="*****"><span><?php echo $pwderror . "<br />"; ?></span>
	<span><?php echo $formerror . "<br />"; ?></span>
	<input type="submit" name="usersubmit" value="Logi sisse">
</form>
  <ul>
	<li><a href="addnewuser.php">Konto loomine</a></li>
 </ul>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna ülikooli</a> Digitehnoloogiate instituudis.</p>
  
<p> Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow-1].", ". $dayofmonth.". ". $monthnameset[$monthnow-1]." ". $year .", kell ".$time .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. </p>

<p> Semestri lõpuni on <?php echo $fromsemesterenddays*-1 ?> päeva.</p>


<p> Semester on <?php if($fromsemesterenddays < 0){
	echo($semesteropen = "käimas. ");}
	else {echo("läbi. ");}	
	echo number_format($semesterprocent, 1);?>% semestrist on läbitud. </p>

<img src="<?php echo $dir."/".$random_img ?>">

</form>
</body>
</html>