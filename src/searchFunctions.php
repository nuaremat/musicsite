<?php
	/* Funktioner (inklusive parametrar) som behövs för att hantera söksidan */
	
	/**
	*	Funktionen printSearchForm() skriver ut formuläret (frmsearch) i vilket det går att skriva in en artist och/eller låt att söka på.
	*	Funktionen tar inte emot någon data och returnerar heller någon data.
	*
	*/
    function printSearchForm() {}
    
	/**
	*	Funktionen listArtists söker ut samtliga artister som matchar sökkriteriet och skriver ut dessa som de visas i laboration 1.
	*	Matchas inga inga poster mot sökkriteriet skriver funktionen ut "Inga artister matchar din sökning!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inSearchString Söksträngen 
	*/
	function listArtists($inDBConnection, $inSearchString) {}
    
	/**
	*	Funktionen listSongs söker ut samtliga sånger som matchar sökkriteriet och skriver ut dessa som de visas i laboration 1.
	*	För varje matching anropas också funktionerna listComments() och printCommentForm().
	*	Matchas inga inga poster mot sökkriteriet skriver funktionen ut "Inga sånger matchar din sökning!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inSearchString Söksträngen 
	*/
	function listSongs($inDBConnection, $inSearchString) {}
    
    /**
	*	Funktionen listComments söker ut samtliga kommentarer som matchar inkommande $inSongId och skriver ut dessa som de visas i laboration 1.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inSongId Primärnyckeln för den sång som det skall listas kommentarer för. 
	*/
	function listComments($inDBConnection, $inSongId){}
	
	/**
	*	Funktionen printCommentForm() skriver ut formuläret (frmcomment) i vilket det går att skriva in en kommentar för en låt.
	*	Funktionen returnerar ingen data.
	*
	*	@param string $songId Primärnyckeln för den låt som kommentarsfältet skall knytas mot
	*	@param string $inSongFileName låtnamnet för den låt som kommentarsfältet skall knytas mot
	*/
	function printCommentForm($songId, $inSongFileName) {}
    
	
