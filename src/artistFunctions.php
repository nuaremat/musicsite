<?php
	/* Funktioner (inklusive parametrar) som behövs för att administrera en artister */
	
	/**
	*	Funktionen printArtistForm() skriver ut formuläret (frmNewUpdateArtist) i vilket det går att skriva in en ny 
	*	artist eller uppdatera en befintlig artist.
	*
	*	Funktionen tar inte emot någon data och returnerar heller ingen data.
	*/
    function printArtistForm() {
        // Form start tag
        echo ('<form action="adminArtist.php" method="post" name="frmNewUpdateArtist" id="frmNewUpdateArtist" enctype="multipart/form-data">');
        // Hidden Artist ID
        echo ('<input type="hidden" id="hidId" name="hidId" />');
        // Hidden picture filename
        echo ('<input type="hidden" id="hidPictureFileName" name="hidPictureFileName" />');
        // Text input
        echo ('<label>Artist<br /><input type="text" id="txtArtist" name="txtArtist" title="Artist"/></label><br />');
        // File input
        echo ('<label>Picture<br /><input type="file" id="filePictureFileName" name="filePictureFileName" title="Picture" /></label><br />');
        // Save submit
        echo ('<input type="submit" id="btnSave" name="btnSave" value="Save" />');
        // Reset button
        echo ('<input type="button" id="btnReset" name="btnReset" value="Reset" />');
        // Form end tag
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
        
        try{
            // Kod för att lista kommentarer ur databasen här
            $artists = $dbConnection->prepare('SELECT * FROM tblartist;');
            $artists->execute();

            // Kollar om det finns några rader i tabellen
            if ($artists->rowCount() == 0) {
                echo ('Det finns inga artister i databasen!');
            } else {
                // Loopar igenom registret och skriver ut artisterna i en accordion
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
                    echo ('<input type="hidden" name="hidPictureFileName" value="' . $picture . '" />');
                    // hidden artist name
                    echo ('<input type="hidden" name="hidArtist" value="' . $name . '" />');
                    echo ('</form></div>');
                }
            }
        }catch(Exception $e){
            echo 'Kunde inte visa artister: ' . $e->getMessage();
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
        
        try{
            // Validerar filen och lägger den i rätt underkatalog
            validateAndMoveUploadedFile('jpg');
            // Om det inte kastas fel (dvs filen är nu korrekt) så läggs den till databasen
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('INSERT INTO tblartist(name, picture) VALUES(?, ?);');
            $stmt->bindParam(1, $inArtist);
            $stmt->bindParam(2, $inNewPictureFileName["name"]);
            $stmt->execute();
        }catch(Exception $e){
            echo 'Gick ej att ladda upp artist: ' . $e->getMessage();
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
	function updateArtist($dbConnection, $inArtistId, $inArtist, $inNewPictureFileName, $inOldPictureFileName) {
        
        try {
            // Om det är en ny bildfil
            if ($inNewPictureFileName !== $inOldPictureFileName && $inNewPictureFileName !== "") {
                 // Validerar filen och lägger den i rätt underkatalog
                validateAndMoveUploadedFile('jpg');
                 // Hämtar den absoluta platsen till gamla filen
                // Källa: http://php.net/realpath
                $inPicturePath = realpath('upload_jpg/' . $inOldPictureFileName);
                if (file_exists($inPicturePath)) {
                    // Ta bort gamla filen om den finns
                    unlink($inPicturePath);
                }
            } else { // Ingen uppdaterad bild, så smidigare kod fås genom att helt enkelt uppdatera med samma namn
                $inNewPictureFileName = $inOldPictureFileName;
            }
            // Allting uppdateras oavsett ändringar eller ej 
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('UPDATE tblartist SET picture = ?, name = ?, changedate = ? WHERE id = ?;');
            $stmt->bindParam(1, $inNewPictureFileName);
            $stmt->bindParam(2, $inArtist);
            $stmt->bindParam(3, (date('Y-m-d H:i:s')));
            $stmt->bindParam(4, $inArtistId);
            $stmt->execute();

        } catch (Exception $e) {
            echo 'Gick inte att uppdatera artist: ' . $e->getMessage();
        }
    }
	
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
        
        try{
            // Hittar alla sånger som är länkade till artisten
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('SELECT * FROM tblsong WHERE artistid = ?;');
            $stmt->bindParam(1, $inArtistId);
            $stmt->execute();
            // Varje iteration kollar den en ny sång som är länkad till artisten och verifierar att den finns
            while ($record = $stmt->fetch()) {
                // Hämtar den absoluta platsen till filen
                // Källa: http://php.net/realpath
                $deleteSong = realpath('upload_ogg/' . $record['sound']);
                if(file_exists($deleteSong)) {
                    // Ta bort filen
                    unlink($deleteSong);
                }
            }
            // Ta bort låtarna från databasen
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('DELETE FROM tblsong WHERE artistid = ?;');
            $stmt->bindParam(1, $inArtistId);
            $stmt->execute();
            // Ta bort artisten från databasen
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('DELETE FROM tblartist WHERE id = ?;');
            $stmt->bindParam(1, $inArtistId);
            $stmt->execute();
            
            /* Ta bort bildfilen */
            // Hämtar den absoluta platsen till filen
            // Källa: http://php.net/realpath
            $inPicturePath = realpath('upload_jpg/' . $inPictureFileName);
            
            // Kolla om filen finns
            if(file_exists($inPicturePath)) {
                // Ta bort filen
                unlink($inPicturePath);
            }
        } catch(Exception $e){
            echo 'Kunde inte ta bort artist: ' . $e->getMessage();
        }
    }
    
	