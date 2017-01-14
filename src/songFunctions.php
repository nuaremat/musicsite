<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera en s�ng */
	
	/**
	*	Funktionen printSongForm() skriver ut formul�ret (frmNewUpdateSong) i vilket det g�r att skriva in en ny 
	*	s�ng eller uppdatera en befintlig s�ng. Funktionen s�ker ut samtliga artister i databasen och listar dessa som
	*	valbara poster i selArtistId. Funktionen returnnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*/
    function printSongForm($inDBConnection) {

    	// H�mtar alla artister
    	$artists = $inDBConnection->query('SELECT * FROM tblartist;');

    	// L�gger in allt som ska skrivas i en str�ng som konkatineras kontinuerligt
    	$skriv = '<form action="adminSong.php" method="post" id="frmNewUpdateSong" name="frmNewUpdateSong" enctype="multipart/form-data">';
    	$skriv .= '<input type="hidden" id="hidId" name="hidId" />' . '<input type="hidden" id="hidSoundFileName" name="hidSoundFileName" />';
    	$skriv .= '<label>' . 'Artist' . '<br />' . '<select id="selArtistId" name="selArtistId" title="Artist" autofocus="autofocus">';
    	$skriv .= '<option value="0">Choose Artist</option>';

        if ($artists->rowCount() == 0) {
            // Om det inte finns artister, lista inte n�gra
        } else {
            while ($record = $artists->fetch()) {
                $id = $record['id'];
                $name = $record['name'];
                $skriv .= '<option value="' . $id . '">' . $name . '</option>';
            }
        }
        
        // Forts�tter konkatenera resten av formul�ret efter alla artister �r inlagda i options
        $skriv .= '</select>' . '</label>' . '<br />' . '<label>' . 'Song' . '<br />';
        $skriv .= '<input type="text" id="txtTitle" name="txtTitle" title="Title"/>';
        $skriv .= '</label>' . '<br />' . '<label>' . 'Sound' . '<br />';
        $skriv .= '<input type="file" id="fileSoundFileName" name="fileSoundFileName" title="File" />';
        $skriv .= '</label>' . '<br />' . '<label>' . 'Count' . '<br />';
        $skriv .= '<input type="text" id="txtCount" name="txtCount" title="Count" />';
        $skriv .= '</label>' . '<br />' . '<input type="submit" id="btnSave" name="btnSave" value="Save" />';
        $skriv .= '<input type="button" id="btnReset" name="btnReset" value="Reset" />' . '</form>';

        // Skriver ut hela str�ngen med en echo
        echo($skriv);
    }

	
	/**
	*	Funktionen listSongs s�ker ut samtliga s�nger som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmSong).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga s�nger i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*/
    function listSongs($inDBConnection) {

        try{
        	// H�mtar alla s�nger
        	$tunes = $inDBConnection->query('SELECT * FROM tblsong;');

        	if ($tunes->rowCount()==0) {
        		echo('Det finns inga s&aring;nger i databasen!');
        	} else {
    			while ($record = $tunes->fetch()) {
    				$id = $record['id'];
    				$title = $record['title'];
                    $sound = $record['sound'];
                    $count = $record['count'];
                    $artistid = $record['artistid'];
                    $changedate = $record['changedate'];

                    // Samma som f�r printSongForm s� konkateneras allt till en variabel(string) innan det skrivs ut
                    $skriv = '<h3>' . $title . '</h3>' . '<div>' . '<form action="adminSong.php" method="post" name="frmSong">';
                    $skriv .= 'Id: ' . $id . '<br />' . 'Title: ' . $title . '<br />' . 'Sound: ' . $sound . '<br />';
                    $skriv .= 'count: ' . $count . '<br />' . 'Changedate: ' . $changedate . '<br />';
                    $skriv .= '<input type="hidden" name="hidId" value="' . $id . '" />';
                    $skriv .= '<input type="hidden" name="hidArtistId" value="' . $artistid . '" />';
                    $skriv .= '<input type="hidden" name="hidTitle" value="' . $title . '" />';
                    $skriv .= '<input type="hidden" name="hidSoundFileName" value="' . $sound . '" />';
                    $skriv .= '<input type="hidden" name="hidCount" value="' . $count . '" />';
                    $skriv .= '<audio controls="controls">' . '<source src="upload_ogg/' . $sound . '" />';
                    $skriv .= 'Your browser does not support the audio tag!' . '</audio>' . '<br />';
                    $skriv .= '<input type="button" name="btnEdit" value="Edit" />';
                    $skriv .= '<input type="submit" name="btnDelete" value="Delete" />' . '</form>' . '</div>';

    				// Skriver ut den aktuella l�tens formul�r, f�r att nollst�lla $skriv n�sta iteration
    				echo($skriv);
    			}
        	}
        }catch(Exception $e){
            echo 'Gick ej att lista songs: ' . $e->getMessage();
        }
    }
	
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
	function insertSong($inDBConnection, $inArtistId, $inCount, $inTitle, $inNewSongFileName) {

        try{
            // Validerar filen och l�gger den i r�tt underkatalog
    		validateAndMoveUploadedFile('ogg');
            // Om det inte kastas fel (dvs filen �r nu korrekt) s� l�ggs den till databasen
            $stmt = $inDBConnection->prepare('INSERT INTO tblsong(title, sound, count, artistid) VALUES(?, ?, ?, ?);');
            $stmt->bindParam(1, $inTitle);
            $stmt->bindParam(2, $inNewSongFileName["name"]);
            $stmt->bindParam(3, $inCount);
            $stmt->bindParam(4, $inArtistId);
            $stmt->execute();
        }catch(Exception $e){
            // Kastat fel med felmeddelande tas emot och skrivs ut
            echo 'Gick ej att ladda up l&aring;t: ' . $e->getMessage();
        }
	}
	
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
    function updateSong($inDBConnection, $inSongId, $inArtistId, $inCount, $inTitle, $inNewSongFileName, $inOldSongFileName) {

        try{
            // Validerar filen och l�gger den i r�tt underkatalog
            validateAndMoveUploadedFile('ogg');
            // Om det inte kastas fel (dvs filen �r nu korrekt) s� uppdateras databasen med ny fil
            $stmt = $inDBConnection->prepare('UPDATE tblsong SET sound = ? WHERE id = ?;');
            $stmt->bindParam(1, $inNewSongFileName);
            $stmt->bindParam(2, $inSongId);
            $stmt->execute();

            // H�mtar den absoluta platsen till gamla filen
            // K�lla: http://php.net/realpath
            $inSongPath = realpath('upload_ogg/' . $inOldSongFileName);
            if(file_exists($inSongPath)) {
                // Ta bort gamla filen om den finns
                unlink($inSongPath);
            }
        }catch(Exception $e){
            echo 'Gick ej att uppdatera l&aring;t: ' . $e->getMessage();
        }
    }
	
	/**
	*	Funktionen deleteSong tar bort en befinlig song fr�n databasen. D�rtill tar funktionen bort den ogg-fil som s�ngen �r knuten mot. 
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att ogg-filen skall tas bort.
	*
	*	@param resurce $inDBConnection Databaskoppling
	*	@param $inSongId string Prim�rnyckeln f�r s�ngen som skall tas bort
	*	@param string $inSongFileName Filnamn p� ogg-ljudet
	*/
    function deleteSong($inDBConnection, $inSongId, $inSongFileName) {
       
        try{
            // Tar bort filen fr�n databasen
            $stmt = $inDBConnection->prepare('DELETE FROM tblsong WHERE id = ?;');
            $stmt->bindParam(1, $inSongId);
            $stmt->execute();

            // H�mtar den absoluta platsen till filen
            // K�lla: http://php.net/realpath
            $inSongPath = realpath('upload_ogg/' . $inSongFileName);
            if(file_exists($inSongPath)) {
                // Ta bort filen om den finns
                unlink($inSongPath);
            } 
        }catch(Exception $e){
            echo 'Gick ej att ta bort song: ' . $e.getMessage();
        }
    }
    
	
