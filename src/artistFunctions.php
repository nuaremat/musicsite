<?php
	/* Funktioner (inklusive parametrar) som behövs för att administrera en artister */
	
	/**
	*	Funktionen printArtistForm() skriver ut formuläret (frmNewUpdateArtist) i vilket det går att skriva in en ny 
	*	artist eller uppdatera en befintlig artist.
	*
	*	Funktionen tar inte emot någon data och returnerar heller ingen data.
	*/
    function printArtistForm() {}
    
	/**
	*	Funktionen listArtists söker ut samtliga artister som finns lagrade i databasen och skriver ut dessa som egna formulär (frmArtist).
	*	Finns inga poster lagrade skriver funktionen istället ut "Det finns inga artister i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
	function listArtists($dbConnection) {}
	
	/**
	*	Funktionen insertArtist sparar en ny artist till databasen samt anropar validateAndMoveUploadedFile() för att flytta den 
	*	uppladdade jpg-filen till rätt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn (jpg-bilden)
	*/
    function insertArtist($dbConnection, $inArtist, $inNewPictureFileName) {}
	
	/**
	*	Funktionen updateArtist uppdaterar en befinlig artist i databasen. Om en ny jpg-fil har angivits tar funktionen bort den gamla och 
	*	anropar validateAndMoveUploadedFile() för att flytta den nya uppladdade jpg-filen till rätt underkatalog.
	*	Funktionen returnerar ingen data men kastar ett undantag om något gick fel i samband med att den gamla jpg-filen skall tas bort.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inArtistId string Primärnyckeln för artisten som skall uppdateras
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn på den nya jpg-bilden
	*	@param string $inOldPictureFileName	Filnamn på den gamla jpg-bilden
	*/
	function updateArtist($dbConnection, $inArtistId, $inArtist, $inNewPictureFileName, $inOldPictureFileName) {}
	
	/**
	*	Funktionen deleteArtist tar bort en befinlig artist från databasen. Därtill tar funktionen bort den jpg-fil samt samtliga ogg-filer som
	*	artisten är knuten mot. 
	*	Funktionen returnerar ingen data men kastar ett undantag om något gick fel i samband med att jpg-filen eller ogg-filen/filerna skall tas bort.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inArtistId string Primärnyckeln för artisten som skall tas bort
	*	@param string $inPictureFileName Filnamn på jpg-bilden
	*/
    function deleteArtist($dbConnection, $inArtistId, $inPictureFileName) {}
    
	