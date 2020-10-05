<?php
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");
  
  //kui klikiti nuppu, siis kontrollime ja salvestame
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $firstname= "";
  $lastname = "";
  $gender = "";
  $birthdate = "";
  $birthday = "";
  $birthmonth = "";
  $birthyear = "";
  $email = "";
    
  $firstnameerror = "";
  $lastnameerror = "";
  $gendererror = "";
  $birthdateerror = "";
  $birthdayerror = "";
  $birthmontherror = "";
  $birthyearerror = "";
  $emailerror = "";
  $passworderror = "";
  $confirmpassworderror = "";
    
  $notice = "";
  
  if(isset($_POST["submituserdata"])){
	  
	  if (!empty($_POST["firstnameinput"])){
		$firstname = test_input($_POST["firstnameinput"]);
	  } else {
		  $firstnameerror = "Palun sisesta eesnimi!";
	  }
	  
	  if (!empty($_POST["lastnameinput"])){
		$lastname = test_input($_POST["lastnameinput"]);
	  } else {
		  $lastnameerror = "Palun sisesta perekonnanimi!";
	  }
	  
	  if(isset($_POST["genderinput"])){
		$gender = intval($_POST["genderinput"]);
		//$gender = $_POST["genderinput"];
	  } else {
		  $gendererror = "Palun märgi sugu!";
	  }
	  
	  if(!empty($_POST["birthdayinput"])){
		  $birthday = intval($_POST["birthdayinput"]);
	  }else{
			$birthdayerror = "Palun vali sünnikuupäev!";
	  }
	  
	  if(!empty($_POST["birthmonthinput"])){
		  $birthmonth = intval($_POST["birthmonthinput"]);
	  }else{
			$birthmontherror = "Palun vali sünnikuu!";	
	  }			
	  
	  if(!empty($_POST["birthyearinput"])){
		  $birthyear = intval($_POST["birthyearinput"]);
	  }else{
			$birthyearerror = "Palun vali sünniaasta!";	
	  }			
	  
	  //Kontrollime kas sisestati reaalne kuupäev
	  if(!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
		  if(checkdate($birthmonth, $birthday, $birthyear)){
			  $tempdate = new DateTime($birthyear ."-" . $birthmonth ."-". $birthday);
			  $birthdate = $tempdate->format("Y-m-d");
		  } else {
			  $birthdateerror = "Kuupäev on vigane!";
		  }
	  }
	  
	  if (!empty($_POST["emailinput"])){
		$email = test_input($_POST["emailinput"]);
	  } else {
		  $emailerror = "Palun sisesta e-postiaadress!";
	  }
	  
	  if (empty($_POST["passwordinput"])){
		$passworderror = "Palun sisesta salasõna!";
	  } else {
		  if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["passwordinput"]) ." märki).";
		  }
	  }
	  
	  if (empty($_POST["confirmpasswordinput"])){
		$confirmpassworderror = "Palun sisestage salasõna kaks korda!";  
	  } else {
		  if($_POST["confirmpasswordinput"] != $_POST["passwordinput"]){
			  $confirmpassworderror = "Kontroll salasõna erineb originaalsest!";
		  }
	  }
	  
	  if(empty($firstnameerror) and empty($lastnameerror) and empty($gendererror )and empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror) and empty($birthdateerror) and empty($emailerror) and empty($passworderror) and empty($confirmpassworderror)){
		$notice = signup($firstname, $lastname, $email, $gender, $birthdate, $_POST["passwordinput"]);
		//$notice = "Kõik korras!";
		if($notice == "ok"){
			$firstname= "";
			$lastname = "";
			$gender = "";
			$birthdate = "";
			$birthday = "";
			$birthmonth = "";
			$birthyear = "";
			$notice = "Kasutaja loomine õnnestus!";
		}else{
			$notice = "Kahjuks tekkis tehniline viga: " .$result;
		}
		
		$firstname= "";
	    $lastname = "";
		$gender = "";
		$email = "";
	  }	  
  }
  

  $username = "Tanel Volkov";

  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1>Uue kasutajakonto loomine</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
    
  <ul>
    <li><a href="home.php">Avalehele</a></li>
  </ul>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <label for="firstnameinput">Eesnimi:</label>
	  <br>
	  <input name="firstnameinput" id="firstnameinput" type="text" value="<?php echo $firstname; ?>"><span><?php echo $firstnameerror; ?></span>
	  <br>
	  <br>
      <label for="lastnameinput">Perekonnanimi:</label><br>
	  <input name="lastnameinput" id="lastnameinput" type="text" value="<?php echo $lastname; ?>"><span><?php echo $lastnameerror; ?></span>
	  <br>
	  <br>
	  <input type="radio" name="genderinput" id="genderfemaleinput" value="2" <?php if($gender == "2"){		echo " checked";} ?>><label for="genderfemaleinput">Naine</label>
	  <input type="radio" name="genderinput" id="gendermaleinput" value="1" <?php if($gender == "1"){		echo " checked";} ?>><label for="gendermaleinput">Mees</label>
	  <span><?php echo "&nbsp; &nbsp; &nbsp;" .$gendererror; ?></span>
	  <br>
	  <br>
	  
	  
	  	  <label for="birthdayinput">Sünnipäev: </label>
		  <?php
			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
			echo '<option value="" selected disabled>päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthday){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
	  <label for="birthmonthinput">Sünnikuu: </label>
	  <?php
	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label for="birthyearinput">Sünniaasta: </label>
	  <?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <br>
	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
	  
	  <br>
	  <br>
	  
	  <label for="emailinput">E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
	  <br>
	  <br>
	  <label for="passwordinput">Salasõna (min 8 tähemärki):</label>
	  <br>
	  <input name="passwordinput" id="passwordinput" type="password"><span><?php echo $passworderror; ?></span>
	  <br>
	  <br>
	  <label for="confirmpasswordinput">Korrake salasõna:</label>
	  <br>
	  <input name="confirmpasswordinput" id="confirmpasswordinput" type="password"><span><?php echo $confirmpassworderror; ?></span>
	  <br>
	  <br>
	  <input name="submituserdata" type="submit" value="Loo kasutaja"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
	</form>
  
</body>
</html>