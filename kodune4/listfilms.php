<?php
$username = "Tanel Volkov";
$fulltimenow = date ("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg";

//loeme andmebaasi login info muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
require("fnc_film.php");

//loeme andmebaasist


require("header.php");
?>
<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
<p> </p>
 <ul>
	<li><a href="home.php">Kodulehele</a></li>
	<li><a href="addfilms.php">Filmiinfo lisamine</a></li>
 </ul>
 
<hr> <?php echo readfilms(); ?>
</body>
</html>