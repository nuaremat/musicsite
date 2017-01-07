<?php
	/* Funktioner (inklusive parametrar) som behövs för att administrera en artister */
	
	/**
	*	Funktionen printArtistForm() skriver ut formuläret (frmNewUpdateArtist) i vilket det går att skriva in en ny 
	*	artist eller uppdatera en befintlig artist.
	*
	*	Funktionen tar inte emot någon data och returnerar heller ingen data.
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
	*	Funktionen listArtists söker ut samtliga artister som finns lagrade i databasen och skriver ut dessa som egna formulär (frmArtist).
	*	Finns inga poster lagrade skriver funktionen istället ut "Det finns inga artister i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
	function listArtists($dbConnection) {
        // Kod för att lista kommentarer ur databasen här
        $artists = $dbConnection->query('SELECT * FROM tblartist;');

        // Kollar om det finns några rader i tabellen
        if ($artists->rowCount() == 0) {
            echo ('Det finns inga artister i databasen!');
        } else {
            while ($record = $artists->fetch()) {
                $id = $record['id'];
                $name = $record['name'];
                $picture = $record['picture'];
                $changedate = $record['changedate'];

                echo ('<h3>' . $name . '</h3>');
                echo ('<div><form action="adminArtist.php" method="post" name="frmArtist">');
                echo ('id: ' . $id . '<br />');
                echo ('name: ' . $name . '<br />');
                echo ('picture: ' . $picture . '<br />');
                echo ('changedate: ' . $changedate . '<br />');
                echo ('<a href="upload_jpg/' . $picture . '" rel="lightbox"><img src="upload_jpg/' . $picture . '" alt="' . $picture . '" class="imgAnimation" rel="lightbox" /></a><br />');
                echo ('<input type="button" name="btnEdit" value="Edit" >');
                echo ('<input type="submit" name="btnDelete" value="Delete" />');
                // hidden id
                echo ('<input type="hidden" name="hidId" value="' . $id . '" />');
                // hidden picture filename
                echo ('<input type="hidden" name="hidPictureFileName" value="' . $picture . '.jpg" />');
                // hidden artist name
                echo ('<input type="hidden" name="hidArtist" value="' . $name . '" />');
                echo ('</form></div>');
            }
        }
    }
	
	/**
	*	Funktionen insertArtist sparar en ny artist till databasen samt anropar validateAndMoveUploadedFile() för att flytta den 
	*	uppladdade jpg-filen till rätt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn (jpg-bilden)
	*/

    // lite hjälp tagen härifrån http://www.w3schools.com/php/php_file_upload.asp

    function insertArtist($dbConnection, $inArtist, $inNewPictureFileName) {
        
        $stmt = $dbConnection->prepare('INSERT INTO tblartist(name, picture) VALUES(?, ?);');
        $stmt->bindParam(1, $inArtist);
        $stmt->bindParam(2, $inNewPictureFileName["name"]);
        $stmt->execute();
        
        $targetDir = "upload_jpg/";
        $targetFile = $targetDir . basename($inNewPictureFileName["name"]);
        
        if (move_uploaded_file($inNewPictureFileName['tmp_name'], $targetFile)) {
            echo "Filen är uppladdad!";
        } else {
            echo "Det gick inte att ladda upp filen!";
        }
    }
	
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
    function deleteArtist($dbConnection, $inArtistId, $inPictureFileName) {
        $stmt = $dbConnection->prepare('DELETE FROM tblartist WHERE id=?');
        $stmt->bindParam(1, $inArtistId);
        $stmt->execute();
    }
    
	