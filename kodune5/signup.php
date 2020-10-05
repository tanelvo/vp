<?php
$firstname="";

$inputerror = "";
if(isset($_POST["signupsubmit"])) {
	if(empty($_POST["firstname"]) or empty($_POST["lastname"]) or empty($_POST["genderinput"]) or empty($_POST["emailinput"]) or empty($_POST["passwordinput"]) or empty($_POST["passwordsecondaryinput"])){
		$inputerror .= "Osa Vajalikku infot on sisetamata!";
	}
	if(strlen($_POST["passwordinput"]) < 8){
		$inputerror .= "Salasõna on väiksem kui 8 tähte!";
	}
	
}

require("header.php")
?>

  <ul>
  <li><a href="home.php">Kodulehele</a></li>
  </ul>

<form method="POST">
	<label for="firstname">Eesnimi: </label> 
	<br>
	<input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi" value="<?php if(isset($_POST['firstnameinput'])){echo $_POST['firstnameinput'];} ?>">
	<br><br>
	<label for="lastname">Perenimi: </label> 
	<br>
	<input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perenimi" value="<?php if(isset($_POST['lastnameinput'])){echo $_POST['lastnameinput'];} ?>">
	<br><br>
	<label for="genderinput">Sugu: </label> 
	<br>
	<input type="radio" name="genderinput" id="gendermale" value="1"><label for="gendermale">Mees</label>
	<input type="radio" name="genderinput" id="genderfemale" value="2"><label for="genderfemale">Naine</label>
	<br><br>
	<label for="emailinput">E-post: </label> 
	<br>
	<input type="email" name="emailinput" id="emailinput" placeholder="nimi@mail.ee" value="<?php if(isset($_POST['emailinput'])){echo $_POST['emailinput'];} ?>">
	<br><br>
	<label for="passwordinput">Salasõna: </label> 
	<br>
	<input type="password" name="passwordinput" id="passwordinput">
	<br><br>
	<label for="passwordsecondaryinput">Salasõna kontroll: </label> 
	<br>
	<input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput">
	<br><br>
	<input type="submit" name="signupsubmit" value="Loo konto">
</form>
<p><?php echo $inputerror; ?> </p>

</body>
</html>