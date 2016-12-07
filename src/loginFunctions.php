<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att hantera anv�ndare och sessioner */
	
	/**
	*	Funktionen validateUser s�ker ut antalet poster som matchar $inUserName och $inPassWord och returnerar talet (0 eller 1).
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inUserName Anv�ndarnamn
	*	@param string $inPassWord L�senord
	*
	*	@return int Antalet rader som matchar s�kkriterierna
	*/
    function validateUser($inDBConnection, $inUserName, $inPassWord) {}
    
	/**
	*	Funktionen startSession() startar upp en session och sparar i denna sparar sessionsvariablerna usernamn och online.
	*	Funktionen tar inte emot n�gon data och returnerar heller ingen data.
	*/
	function startSession() {}
    
	/**
	*	Funktionen endSession() avslutar en befintlig session.
	*	Funktionen tar inte emot n�gon data och returnerar heller ingen data.
	*/
	function endSession() {}
    
	/**
	*	Funktionen checkSesion() kontrolleras om en session �r ig�ng och om s� �r fallet genererar ett nytt sessionsid och returnerar sant. 
	*	�r ingen session ig�ng returneras falskt.
	*	Funktionen tar inte emot n�gon data. 
	*
	*	@return boolean Om en anv�ndare �r p�loggad eller inte
	*/
	function checkSession() {}
