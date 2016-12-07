<?php
	/* Funktioner (inklusive parametrar) som behövs för att hantera användare och sessioner */
	
	/**
	*	Funktionen validateUser söker ut antalet poster som matchar $inUserName och $inPassWord och returnerar talet (0 eller 1).
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inUserName Användarnamn
	*	@param string $inPassWord Lösenord
	*
	*	@return int Antalet rader som matchar sökkriterierna
	*/
    function validateUser($inDBConnection, $inUserName, $inPassWord) {}
    
	/**
	*	Funktionen startSession() startar upp en session och sparar i denna sparar sessionsvariablerna usernamn och online.
	*	Funktionen tar inte emot någon data och returnerar heller ingen data.
	*/
	function startSession() {}
    
	/**
	*	Funktionen endSession() avslutar en befintlig session.
	*	Funktionen tar inte emot någon data och returnerar heller ingen data.
	*/
	function endSession() {}
    
	/**
	*	Funktionen checkSesion() kontrolleras om en session är igång och om så är fallet genererar ett nytt sessionsid och returnerar sant. 
	*	Är ingen session igång returneras falskt.
	*	Funktionen tar inte emot någon data. 
	*
	*	@return boolean Om en användare är påloggad eller inte
	*/
	function checkSession() {}
