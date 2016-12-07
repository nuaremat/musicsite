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
	
	//För test returneras dagens datum och en konstant i form av JSON: {"date" : "dagens datum", "comment" : "Detta är en kommentar"}.
	header("Content-Type: application/json");
	
	$jsonData = array("date" => date("Y-m-d"), "comment" => "Detta är en kommentar");
	echo(json_encode($jsonData));