<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera en artister */
	
	/**
	*	Funktionen printArtistForm() skriver ut formul�ret (frmNewUpdateArtist) i vilket det g�r att skriva in en ny 
	*	artist eller uppdatera en befintlig artist.
	*
	*	Funktionen tar inte emot n�gon data och returnerar heller ingen data.
	*/
    function printArtistForm() {
        echo ('<form action="adminArtist.php" method="post" name="frmNewUpdateArtist" id="frmNewUpdateArtist" enctype="multipart/form-data">');
        echo ('<input type="hidden" id="hidId" name="hidId" />');
        echo ('<input type="hidden" id="hidPictureFileName" name="hidPictureFileName" />');
        echo ('<label>Artist<br /><input type="text" id="txtArtist" name="txtArtist" title="Artist"/></label><br />');
        echo ('<label>Picture<br /><input type="file" id="filePictureFileName" name="filePictureFileName" title="Picture" /></label><br />');
        echo ('<input type="submit" id="btnSave" name="btnSave" value="Save" />');
        echo ('<input type="button" id="btnReset" name="btnReset" value="Reset" />');
        echo ('</form>');
    }
    
	/**
	*	Funktionen listArtists s�ker ut samtliga artister som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmArtist).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga artister i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
	function listArtists($dbConnection) {}
	
	/**
	*	Funktionen insertArtist sparar en ny artist till databasen samt anropar validateAndMoveUploadedFile() f�r att flytta den 
	*	uppladdade jpg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn (jpg-bilden)
	*/
    function insertArtist($dbConnection, $inArtist, $inNewPictureFileName) {}
	
	/**
	*	Funktionen updateArtist uppdaterar en befinlig artist i databasen. Om en ny jpg-fil har angivits tar funktionen bort den gamla och 
	*	anropar validateAndMoveUploadedFile() f�r att flytta den nya uppladdade jpg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att den gamla jpg-filen skall tas bort.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inArtistId string Prim�rnyckeln f�r artisten som skall uppdateras
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn p� den nya jpg-bilden
	*	@param string $inOldPictureFileName	Filnamn p� den gamla jpg-bilden
	*/
	function updateArtist($dbConnection, $inArtistId, $inArtist, $inNewPictureFileName, $inOldPictureFileName) {}
	
	/**
	*	Funktionen deleteArtist tar bort en befinlig artist fr�n databasen. D�rtill tar funktionen bort den jpg-fil samt samtliga ogg-filer som
	*	artisten �r knuten mot. 
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att jpg-filen eller ogg-filen/filerna skall tas bort.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inArtistId string Prim�rnyckeln f�r artisten som skall tas bort
	*	@param string $inPictureFileName Filnamn p� jpg-bilden
	*/
    function deleteArtist($dbConnection, $inArtistId, $inPictureFileName) {}
    
	