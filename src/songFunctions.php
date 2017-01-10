<?php
	/* Funktioner (inklusive parametrar) som behövs för att administrera en sång */
	
	/**
	*	Funktionen printSongForm() skriver ut formuläret (frmNewUpdateSong) i vilket det går att skriva in en ny 
	*	sång eller uppdatera en befintlig sång. Funktionen söker ut samtliga artister i databasen och listar dessa som
	*	valbara poster i selArtistId. Funktionen returnnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*/
    function printSongForm($inDBConnection) {


    	// Hämtar alla artister
    	$artists = $inDBConnection->query('SELECT * FROM tblartist;');

    	// Lägger in allt som ska skrivas i en sträng som konkatineras kontinuerligt
    	$skriv = '<form action="adminSong.php" method="post" id="frmNewUpdateSong" name="frmNewUpdateSong" enctype="multipart/form-data">';
    	$skriv .= '<input type="hidden" id="hidId" name="hidId" />' . '<input type="hidden" id="hidSoundFileName" name="hidSoundFileName" />';
    	$skriv .= '<label>' . 'Artist' . '<br />' . '<select id="selArtistId" name="selArtistId" title="Artist" autofocus="autofocus">';
    	$skriv .= '<option value="0">Choose Artist</option>';

        if ($artists->rowCount() == 0) {
            // Om det inte finns artister, lista inte några
        } else {
            while ($record = $artists->fetch()) {
                $id = $record['id'];
                $name = $record['name'];
                $skriv .= '<option value="' . $id . '">' . $name . '</option>';
            }
        }
        
        $skriv .= '</select>' . '</label>' . '<br />' . '<label>' . 'Song' . '<br />';
        $skriv .= '<input type="text" id="txtTitle" name="txtTitle" title="Title"/>';
        $skriv .= '</label>' . '<br />' . '<label>' . 'Sound' . '<br />';
        $skriv .= '<input type="file" id="fileSoundFileName" name="fileSoundFileName" title="File" />';
        $skriv .= '</label>' . '<br />' . '<label>' . 'Count' . '<br />';
        $skriv .= '<input type="text" id="txtCount" name="txtCount" title="Count" />';
        $skriv .= '</label>' . '<br />' . '<input type="submit" id="btnSave" name="btnSave" value="Save" />';
        $skriv .= '<input type="button" id="btnReset" name="btnReset" value="Reset" />' . '</form>';

        // Skriver ut hela strängen med en echo
        echo($skriv);

    }

	
	/**
	*	Funktionen listSongs söker ut samtliga sånger som finns lagrade i databasen och skriver ut dessa som egna formulär (frmSong).
	*	Finns inga poster lagrade skriver funktionen istället ut "Det finns inga sånger i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*/
    function listSongs($inDBConnection) {}
	
	/**
	*	Funktionen insertSong sparar en ny sång till databasen samt anropar validateAndMoveUploadedFile() för att flytta den 
	*	uppladdade ogg-filen till rätt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*	@param string $inArtistId Primärnyckeln för artisten som knyts mot sången
	*	@param string $inCount Antalet "gilla" (count)
	*	@param string $inTitle Sångtitel
	*	@param string $inNewSongFileName Filnamn (ogg-ljudet)
	*/
	function insertSong($inDBConnection, $inArtistId, $inCount, $inTitle, $inNewSongFileName) {}
	
	/**
	*	Funktionen updateSong uppdaterar en befinlig sång i databasen. Om en ny ogg-fil har angivits tar funktionen bort den gamla och 
	*	anropar validateAndMoveUploadedFile() för att flytta den nya uppladdade ogg-filen till rätt underkatalog.
	*	Funktionen returnerar ingen data men kastar ett undantag om något gick fel i samband med att den gamla ogg-filen skall tas bort.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*	@param $inSongId string Primärnyckeln för sången som skall uppdateras
	*	@param string $inArtistId Främmandenyckeln för artisten som knyts mot sången
	*	@param string $inCount Antalet "gilla" (count)
	*	@param string $inNewSongFileName Filnamn på det nya ogg-ljudet
	*	@param string $inOldSongFileName Filnamn på det gamla ogg-ljudet
	*/
    function updateSong($inDBConnection, $inSongId, $inArtistId, $inCount, $inTitle, $inNewSongFileName, $inOldSongFileName) {}
	
	/**
	*	Funktionen deleteSong tar bort en befinlig song från databasen. Därtill tar funktionen bort den ogg-fil som sången är knuten mot. 
	*	Funktionen returnerar ingen data men kastar ett undantag om något gick fel i samband med att ogg-filen skall tas bort.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*	@param $inSongId string Primärnyckeln för sången som skall tas bort
	*	@param string $inSongFileName Filnamn på ogg-ljudet
	*/
    function deleteSong($inDBConnection, $inSongId, $inSongFileName) {}
    
	
