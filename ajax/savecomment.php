<?php

	/*
	    Spara den nya kommentaren i databasen.
	*/

	/**
	*	I savecomment skall en databaskoppling upprättas och därefter skall en ny kommentar sparas till databasen för det
	*	inkommande primärnyckel för song. Därefter skall dagens datum samt inkommande kommentar
	*	returneras som JSON data.
	*
	*   Kom ihåg att tvätta data, frigöra minnet från utsökningen, stänga ner databaskopplingen samt använda undantagshantering.
	*	
	*/
	
	try {
		header("Content-Type: application/json");
		// Indata från AJAX
		$dataId = $_POST['dataId'];
		$textareaValue = $_POST['textareaValue'];
		// Function date http://php.net/manual/en/function.date.php
		$date = date('Y-m-d H:i:s');
		include('../src/databaseFunctions.php');

		if($textareaValue == ""){
			// Om textarean är tom så hoppar vi ur anropet,
			// och får ett abrupt slut på json som errormeddelande
			throw new Exception('Du skrev ingen kommentar!');
		}
		// Databasuppkoppling
	    $db = myDBConnect();
	
		// Sätt in ny kommentar i databasen
		// Prepare & execute hjälper att säkra mot injection
		// Källa: http://ch1.php.net/pdo.prepared-statements
		$stmt = $db->prepare('INSERT INTO tblcomment (text, songid, insertdate) VALUES (?, ?, ?);');
		$stmt->bindParam(1, $textareaValue);
		$stmt->bindParam(2, $dataId);
		$stmt->bindParam(3, $date);
		$stmt->execute();
		// Frigör minne
		$stmt = NULL;
		// Stäng ner databaskopplingen
		$db = NULL;
		// Skriv ut värden till JSON
		$jsonData = array("date" => $date, "comment" => $textareaValue);
		echo(json_encode($jsonData));
	}catch (Exception $e) {
	    // Tar emot felet, men rapporterar inget
	    $error = 'Error connecting to DB: ' . $e->getMessage();
	}
?>