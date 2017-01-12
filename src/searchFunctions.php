<?php
	/* Funktioner (inklusive parametrar) som behövs för att hantera söksidan */
	
	/**
	*	Funktionen printSearchForm() skriver ut formuläret (frmsearch) i vilket det går att skriva in en artist och/eller låt att söka på.
	*	Funktionen tar inte emot någon data och returnerar heller någon data.
	*
	*/
    function printSearchForm() {

    	$skriv = '<form action="search.php" method="post" name="frmsearch">';
    	$skriv .= '<fieldset> <legend> Song and/or Artist </legend>';
    	$skriv .= '<input type="text" id="txtsearch" name="txtSearch" title="Song and/or Artist!" required="required" placeholder="Type Artist or Song and press Search!" size="35" autofocus="autofocus"/>';
    	$skriv .= '<br />' . '<input type="submit" id="btnsearch" name="btnSearch" value="Search" />';
    	$skriv .= '<input type="reset" id="btnreset" name="btnReset" value="Reset" /> </fieldset> </form>';
    	// Skriver ut formuläret med echo
		echo($skriv);       
    }
    
	/**
	*	Funktionen listArtists söker ut samtliga artister som matchar sökkriteriet och skriver ut dessa som de visas i laboration 1.
	*	Matchas inga inga poster mot sökkriteriet skriver funktionen ut "Inga artister matchar din sökning!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inSearchString Söksträngen 
	*/
	function listArtists($inDBConnection, $inSearchString) {
		try{
			// Kod för att lista artister ur databasen, 
			// finner match på delar av artistnamn sålänge alla sökta tecken är i starten 
			// Ex; "Lal" ger resultatet Laleh, men "ale" ger inget resultat på Laleh. (Medvetet programmerat)
	        $artists = $inDBConnection->query('SELECT * FROM tblartist WHERE name LIKE "' . $inSearchString . '%";');
	        // Start av artistutsökning
	        echo '<fieldset><legend>Searchresult Artist</legend>';
	        // Kollar om det finns några rader i tabellen
	        if ($artists->rowCount() == 0) {
	            echo ('Inga artister matchar din s&ouml;kning!');
	        } else {
	            while ($record = $artists->fetch()) {
	                $name = $record['name'];
	                $picture = $record['picture'];

	                $skriv = 'Name: ' . $name . '<br />';
	                $skriv .= '<a href="upload_jpg/' . $picture . '" rel="lightbox">';
	                $skriv .= '<img src="upload_jpg/' . $picture . '" alt="' . $picture . '." class="imgAnimation" rel="lightbox" /></a><br /><br />';
	                // Skriver ut denna iterations artist och påbörjar nästa om det finns fler resultat
	                echo($skriv);
	            }
	        }
	        // Slut av artistutsökning
	        echo '</fieldset><br />';
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
    
	/**
	*	Funktionen listSongs söker ut samtliga sånger som matchar sökkriteriet och skriver ut dessa som de visas i laboration 1.
	*	För varje matching anropas också funktionerna listComments() och printCommentForm().
	*	Matchas inga inga poster mot sökkriteriet skriver funktionen ut "Inga sånger matchar din sökning!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inSearchString Söksträngen 
	*/
	function listSongs($inDBConnection, $inSearchString) {

		// Kod för att lista sånger ur databasen, fungerar på samma sätt som listArtists
        $tunes = $inDBConnection->query('SELECT * FROM tblsong WHERE title LIKE "' . $inSearchString . '%";');
        // Start av låtutsökning
		echo '<fieldset><legend>Searchresult Song</legend>';
         // Kollar om det finns några rader i tabellen
        if ($tunes->rowCount() == 0) {
            echo ('Inga l&aring;tar matchar din s&ouml;kning!');
        } else {
            while ($record = $tunes->fetch()) {
                $id = $record['id'];
                $title = $record['title'];
                $sound = $record['sound'];
                $count = $record['count'];
                $artistid = $record['artistid'];
                $changedate = $record['changedate'];

                // Hade hellre använt konkatenering, men när listComments inte får returnera data och måste annvändas blir det ej ko.
				echo '<span class="toggle-button"> Show all comments</span>';
        		echo ('<div data-comments="comments" data-id="' . $id . '" class="toggle-result">');
                listComments($inDBConnection, $id);
                echo '</div>'; 
                printCommentForm($id, $sound);
                echo ('<a href="#" data-id="' . $id . '" class="like-button">Like ' . $title . '</a>');
                echo ('<p>Title: ' . $title . '<br />Song: ' . $sound . '<br />');
                echo ('Count: <span data-id="' . $id . '">' . $count . '</span><br />');
                echo ('<audio controls="controls"><source src="upload_ogg/' . $sound . '" />');
                echo ('Din webbl&auml;sare st&ouml;djer inte audio-taggen!</audio><br /></p><hr />');
            }
            
        }
        // Slut av låtutsökning
        echo '</fieldset>';
	}
    
    /**
	*	Funktionen listComments söker ut samtliga kommentarer som matchar inkommande $inSongId och skriver ut dessa som de visas i laboration 1.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inSongId Primärnyckeln för den sång som det skall listas kommentarer för. 
	*/
	function listComments($inDBConnection, $inSongId){

		$comments = $inDBConnection->query('SELECT * FROM tblcomment WHERE songid = "' . $inSongId . '"');
		if ($comments->rowCount() == 0) {
            echo ('Inga kommentarer att visa, fyll p&aring; med dina &aring;sikter!');
        } else {
            while ($record = $comments->fetch()){
            	// Skriver ut kommentarer tills alla är utskrivna
				echo ('<p> <b>' . $record['insertdate'] . ':</b> <i>' . $record['text'] . '</i> </p>');
			}
		}
	}
	
	/**
	*	Funktionen printCommentForm() skriver ut formuläret (frmcomment) i vilket det går att skriva in en kommentar för en låt.
	*	Funktionen returnerar ingen data.
	*
	*	@param string $songId Primärnyckeln för den låt som kommentarsfältet skall knytas mot
	*	@param string $inSongFileName låtnamnet för den låt som kommentarsfältet skall knytas mot
	*/
	function printCommentForm($songId, $inSongFileName) {

		$skriv = '<form action="#" method="post" name="frmcomment" data-id="' . $songId . '">';
		$skriv .= '<span class="toggle-button">Comment låt</span>';
		$skriv .= '<fieldset class="toggle-result"> <legend> Comment on ' . $inSongFileName . '</legend>';
		$skriv .= '<textarea name="txtComment" cols="40" rows="10" title="Comment" required="required" placeholder="Write your comment!"></textarea><br />';
		$skriv .= '<input type="hidden" name="hidId" value="' . $songId . '" />';
		$skriv .= '<input type="submit" name="btnSave" value="Save" />';
		$skriv .= '<input type="reset" name="btnReset" value="Reset" /> </fieldset> </form>';
		// Skriver ut formuläret
		echo($skriv);   
	}
    
	
