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

require("header.php");
?>

<p> </p>
<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">

 <ul>
	<li><a href="home.php">Kodulehele</a></li>
	<li><a href="page3.php">Varasemad mõtted</a></li>
 </ul>

</ul>
<form method="POST">
  <label> Sisesta oma tänane mõttetu mõte:</label>
  <input type ="text" name="nonsens" placeholder="Mõttekoht">
  <input type="submit" value="Saada ära!" name="submitnonsens">
  
</form>
</body>
</html>