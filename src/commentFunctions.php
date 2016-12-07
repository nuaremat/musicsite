<?php
	/* Funktioner (inklusive parametrar) som behövs för att administrera kommentarer */
	
	/**
	*	Funktionen listComments söker ut samtliga kommentarer som finns lagrade i databasen och skriver ut dessa som egna formulär (frmComment).
	*	Finns inga poster lagrade skriver funktionen istället ut "Det finns inga kommentarer i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
    function listComments($inDBConnection){}
    
	/**
	*	Funktionen deleteComment tar bort en befinlig kommentar från databasen. 
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inCommentId string Primärnyckeln för kommentaren som skall tas bort
	*/
	function deleteComment($inDBConnection, $inCommentId) {}