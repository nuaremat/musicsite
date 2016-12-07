<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera kommentarer */
	
	/**
	*	Funktionen listComments s�ker ut samtliga kommentarer som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmComment).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga kommentarer i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
    function listComments($inDBConnection){}
    
	/**
	*	Funktionen deleteComment tar bort en befinlig kommentar fr�n databasen. 
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inCommentId string Prim�rnyckeln f�r kommentaren som skall tas bort
	*/
	function deleteComment($inDBConnection, $inCommentId) {}