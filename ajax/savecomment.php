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

header("Content-Type: application/json");

// indata från AJAX
$dataId = $_POST['dataId'];
$textareaValue = $_POST['textareaValue'];
// function date http://php.net/manual/en/function.date.php
$date = date('Y-m-d H:i:s');

include('../src/databaseFunctions.php');

// Databasuppkoppling
try {
    $db = myDBConnect();
} catch (Exception $e) {
    // Skriv ut error på sidan senare.
    $error = 'Error connecting to DB: ' . $e->getMessage();
}

// Sätt in ny kommentar i databasen
$stmt = $db->prepare('INSERT INTO tblcomment (text, songid, insertdate) VALUES (?, ?, ?);');
$stmt->bindParam(1, $textareaValue);
$stmt->bindParam(2, $dataId);
$stmt->bindParam(3, $date);
$stmt->execute();

// Välj alla kommentarer kopplade till låt-IDt
$stmt = $db->prepare('SELECT * FROM tblcomment WHERE id=?;');
$stmt->bindParam(1, $dataId);
$stmt->execute();

// Hämta ut värden och koppla till variabler
while ($record = $stmt->fetch()) {
    $date = $record['insertdate'];
}


// Skriv ut värden till JSON
$jsonData = array("date" => $date, "comment" => $textareaValue);
echo(json_encode($jsonData));

?>