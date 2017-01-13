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

include('src/databaseFunctions.php');

//try {
//    $db = myDBConnect();
//} catch (Exception $e) {
//    // Skriv ut error på sidan senare.
//    $error = 'Error connecting to DB: ' . $e->getMessage();
//}

//$stmt = $db->prepare('UPDATE tblsong SET count = count+1 WHERE id=?;');
//$stmt->bindParam(1, $_GET[id]);
//$stmt->execute();

$stmt = $db->query('SELECT * FROM tblsong;');
//
//while ($record = $stmt->fetch()) {
//    $count = $record['count'];
//}
	
// För test returnerars konstanten 100 i form av JSON: {"gilla" : "100"}.

header("Content-Type: application/json");

$count = '110';

$jsonData = array("gilla" => $count);
echo(json_encode($jsonData));

?>