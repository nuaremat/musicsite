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
		$textareaValue = strip_tags($_POST['textareaValue']);
		// Function date http://php.net/manual/en/function.date.php
		$date = date('Y-m-d H:i:s');
		include('../src/databaseFunctions.php');

		if($textareaValue == ""){
			// Om textarean är tom hoppar vi ur anropet,
			// och får ett abrupt slut på json som errormeddelande
			throw new Exception('Du skrev ingen kommentar!');
		}
		// Databasuppkoppling
	    $db = myDBConnect();
	
		// Sätt in ny kommentar i databasen
		// prepare skyddar mot SQL injection
        // http://php.net/manual/en/pdo.prepare.php
		$stmt = $db->prepare('INSERT INTO tblcomment (text, songid, insertdate) VALUES (?, ?, ?);');
		$stmt->bindParam(1, $textareaValue);
		$stmt->bindParam(2, $dataId);
		$stmt->bindParam(3, $date);
		$stmt->execute();
        
		// Frigör minne
		$stmt = NULL;
		// Stäng ner databaskopplingen
		$db = NULL;
        
		// Ger fälten värdena som återfinns i respektive variablar
		$jsonData = array("date" => $date, "comment" => $textareaValue);
        // Encoda till JSON och echoa ut
		echo(json_encode($jsonData));
	}catch (Exception $e) {
	    // Tar emot felet, men rapporterar inget
	    // $.ajax har sitt egna system som går före try/catch i denna fil
	}
?>