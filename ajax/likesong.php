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

header("Content-Type: application/json");

include('../src/databaseFunctions.php');

// indata från AJAX
$dataId = $_POST['dataId'];

// Databasuppkoppling
try {
    $db = myDBConnect();
} catch (Exception $e) {
    // Skriv ut error på sidan senare.
    $error = 'Error connecting to DB: ' . $e->getMessage();
}

$stmt = $db->prepare('UPDATE tblsong SET count = count + 1 WHERE id=?;');
$stmt->bindParam(1, $dataId);
$stmt->execute();

$stmt = $db->prepare('SELECT * FROM tblsong WHERE id=?;');
$stmt->bindParam(1, $dataId);
$stmt->execute();

while ($record = $stmt->fetch()) {
    $count = $record['count'];
}

$jsonData = array("gilla" => $count);
echo(json_encode($jsonData));

?>