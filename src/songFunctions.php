<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera en s�ng */
	
	/**
	*	Funktionen printSongForm() skriver ut formul�ret (frmNewUpdateSong) i vilket det g�r att skriva in en ny 
	*	s�ng eller uppdatera en befintlig s�ng. Funktionen s�ker ut samtliga artister i databasen och listar dessa som
	*	valbara poster i selArtistId. Funktionen returnnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*/
    function printSongForm($inDBConnection) {}
	
	/**
	*	Funktionen listSongs s�ker ut samtliga s�nger som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmSong).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga s�nger i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*/
    function listSongs($inDBConnection) {}
	
	/**
	*	Funktionen insertSong sparar en ny s�ng till databasen samt anropar validateAndMoveUploadedFile() f�r att flytta den 
	*	uppladdade ogg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*	@param string $inArtistId Prim�rnyckeln f�r artisten som knyts mot s�ngen
	*	@param string $inCount Antalet "gilla" (count)
	*	@param string $inTitle S�ngtitel
	*	@param string $inNewSongFileName Filnamn (ogg-ljudet)
	*/
	function insertSong($inDBConnection, $inArtistId, $inCount, $inTitle, $inNewSongFileName) {}
	
	/**
	*	Funktionen updateSong uppdaterar en befinlig s�ng i databasen. Om en ny ogg-fil har angivits tar funktionen bort den gamla och 
	*	anropar validateAndMoveUploadedFile() f�r att flytta den nya uppladdade ogg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att den gamla ogg-filen skall tas bort.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*	@param $inSongId string Prim�rnyckeln f�r s�ngen som skall uppdateras
	*	@param string $inArtistId Fr�mmandenyckeln f�r artisten som knyts mot s�ngen
	*	@param string $inCount Antalet "gilla" (count)
	*	@param string $inNewSongFileName Filnamn p� det nya ogg-ljudet
	*	@param string $inOldSongFileName Filnamn p� det gamla ogg-ljudet
	*/
    function updateSong($inDBConnection, $inSongId, $inArtistId, $inCount, $inTitle, $inNewSongFileName, $inOldSongFileName) {}
	
	/**
	*	Funktionen deleteSong tar bort en befinlig song fr�n databasen. D�rtill tar funktionen bort den ogg-fil som s�ngen �r knuten mot. 
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att ogg-filen skall tas bort.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*	@param $inSongId string Prim�rnyckeln f�r s�ngen som skall tas bort
	*	@param string $inSongFileName Filnamn p� ogg-ljudet
	*/
    function deleteSong($inDBConnection, $inSongId, $inSongFileName) {}
    
	
