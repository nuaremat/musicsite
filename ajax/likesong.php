<?php

	/*
		Öka tblsong.count med ett och spara i databasen.
	*/
	
	/**
	*	I likesong.php skall en koppling mot databasen upprättas och därefter skall antalet "gilla" (count) ökas med
	*	ett för inkommande primärnyckel för song. Därefter skall antalet "gilla" (count) på nytt sökas ut från databasen
	*	och returneras som JSON data.
	*   Kom ihåg att tvätta data, frigöra minnet från utsökningen, stänga ner databaskopplingen samt använda undantagshantering.
	*	
	*/
	try {
		header("Content-Type: application/json");
		include('../src/databaseFunctions.php');
		// indata från AJAX
		$dataId = $_POST['dataId'];
		// Databasuppkoppling
		$db = myDBConnect();

		$stmt = $db->prepare('UPDATE tblsong SET count = count + 1 WHERE id = ?;');
		$stmt->bindParam(1, $dataId);
		$stmt->execute();

		$stmt = $db->prepare('SELECT * FROM tblsong WHERE id = ?;');
		$stmt->bindParam(1, $dataId);
		$stmt->execute();
		$count = $stmt->fetch();
		// Frigör minne
		$stmt = NULL;
		// Stäng ner databaskopplingen
		$db = NULL;

		$jsonData = array("gilla" => $count['count']);
		echo(json_encode($jsonData));
	} catch (Exception $e) {
	    // Tar emot felet, men rapporterar inget
	    $error = 'Error connecting to DB: ' . $e->getMessage();
	}
?>