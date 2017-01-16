<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera en artister */
	
	/**
	*	Funktionen printArtistForm() skriver ut formul�ret (frmNewUpdateArtist) i vilket det g�r att skriva in en ny 
	*	artist eller uppdatera en befintlig artist.
	*
	*	Funktionen tar inte emot n�gon data och returnerar heller ingen data.
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
	*	Funktionen listArtists s�ker ut samtliga artister som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmArtist).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga artister i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
	function listArtists($dbConnection) {
        
        try{
            // Kod f�r att lista kommentarer ur databasen h�r
            $artists = $dbConnection->prepare('SELECT * FROM tblartist;');
            $artists->execute();

            // Kollar om det finns n�gra rader i tabellen
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
	*	Funktionen insertArtist sparar en ny artist till databasen samt anropar validateAndMoveUploadedFile() f�r att flytta den 
	*	uppladdade jpg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn (jpg-bilden)
	*/

    // lite hj�lp tagen h�rifr�n http://www.w3schools.com/php/php_file_upload.asp

    function insertArtist($dbConnection, $inArtist, $inNewPictureFileName) {
        
        try{
            // Validerar filen och l�gger den i r�tt underkatalog
            validateAndMoveUploadedFile('jpg');
            // Om det inte kastas fel (dvs filen �r nu korrekt) s� l�ggs den till databasen
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
	*	anropar validateAndMoveUploadedFile() f�r att flytta den nya uppladdade jpg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att den gamla jpg-filen skall tas bort.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inArtistId string Prim�rnyckeln f�r artisten som skall uppdateras
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn p� den nya jpg-bilden
	*	@param string $inOldPictureFileName	Filnamn p� den gamla jpg-bilden
	*/
	function updateArtist($dbConnection, $inArtistId, $inArtist, $inNewPictureFileName, $inOldPictureFileName) {
        
        try {
            // Om det �r en ny bildfil
            if ($inNewPictureFileName !== $inOldPictureFileName && $inNewPictureFileName !== "") {
                 // Validerar filen och l�gger den i r�tt underkatalog
                validateAndMoveUploadedFile('jpg');
                 // H�mtar den absoluta platsen till gamla filen
                // K�lla: http://php.net/realpath
                $inPicturePath = realpath('upload_jpg/' . $inOldPictureFileName);
                if (file_exists($inPicturePath)) {
                    // Ta bort gamla filen om den finns
                    unlink($inPicturePath);
                }
            } else { // Ingen uppdaterad bild, s� smidigare kod f�s genom att helt enkelt uppdatera med samma namn
                $inNewPictureFileName = $inOldPictureFileName;
            }
            // Allting uppdateras oavsett �ndringar eller ej 
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
	*	Funktionen deleteArtist tar bort en befinlig artist fr�n databasen. D�rtill tar funktionen bort den jpg-fil samt samtliga ogg-filer som
	*	artisten �r knuten mot. 
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att jpg-filen eller ogg-filen/filerna skall tas bort.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inArtistId string Prim�rnyckeln f�r artisten som skall tas bort
	*	@param string $inPictureFileName Filnamn p� jpg-bilden
	*/
    function deleteArtist($dbConnection, $inArtistId, $inPictureFileName) {
        
        try{
            // Hittar alla s�nger som �r l�nkade till artisten
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('SELECT * FROM tblsong WHERE artistid = ?;');
            $stmt->bindParam(1, $inArtistId);
            $stmt->execute();
            // Varje iteration kollar den en ny s�ng som �r l�nkad till artisten och verifierar att den finns
            while ($record = $stmt->fetch()) {
                // H�mtar den absoluta platsen till filen
                // K�lla: http://php.net/realpath
                $deleteSong = realpath('upload_ogg/' . $record['sound']);
                if(file_exists($deleteSong)) {
                    // Ta bort filen
                    unlink($deleteSong);
                }
            }
            // Ta bort l�tarna fr�n databasen
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('DELETE FROM tblsong WHERE artistid = ?;');
            $stmt->bindParam(1, $inArtistId);
            $stmt->execute();
            // Ta bort artisten fr�n databasen
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $stmt = $dbConnection->prepare('DELETE FROM tblartist WHERE id = ?;');
            $stmt->bindParam(1, $inArtistId);
            $stmt->execute();
            
            /* Ta bort bildfilen */
            // H�mtar den absoluta platsen till filen
            // K�lla: http://php.net/realpath
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
    
	