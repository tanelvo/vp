<?php
	$database = "if20_tanel_vo_3";

	function signup($firstname, $lastname, $email, $gender, $birthdate, $password){
		$notice = "";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?, ?, ?, ?, ?, ?)");
		echo $conn->error;
		//krüpteerime parooli
		$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
		$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		
		$stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);
		if($stmt->execute()){
			$notice = "ok";
		}else{
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function signin($email, $password){
		notice = "";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT passwordf FROM vpusers WHERE email = ?");
		echo $conn->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($passwordfromdb);
		if($stmt->execute()){
			//andmebaasi päring õnnestus
			if($stmt->fetch()){
				if(password_verify($password, $passwordfromdb)){
					$notice = "Olete sisse logitud!";
					
					$stmt->close();
					$conn->close();
					header("Location: home.php");
					exit();
				} else {
					$notice = "Vale salasõna!";
				}
			} else {
				$notice = "Sellist kasutajat (" .$email .")kahjuks pole!";
			}
		}else{
			$notice = "Sisselogimisel tekkis tehniline viga: " .$stmt->error;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
