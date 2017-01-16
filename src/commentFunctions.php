<?php
	/* Funktioner (inklusive parametrar) som behövs för att administrera kommentarer */
	
	/**
	*	Funktionen listComments söker ut samtliga kommentarer som finns lagrade i databasen och skriver ut dessa som egna formulär (frmComment).
	*	Finns inga poster lagrade skriver funktionen istället ut "Det finns inga kommentarer i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
    function listComments($inDBConnection) {
        
        try {
            // Kod för att lista kommentarer ur databasen här
            $comments = $inDBConnection->prepare('SELECT text, tblcomment.id, songid, title FROM tblcomment, tblsong WHERE tblcomment.songid = tblsong.id GROUP BY tblcomment.id');
            $comments->execute();

            // Kollar om det finns några rader i tabellen
            if ($comments->rowCount() == 0) {
                echo ('Det finns inga kommentarer i databasen!');
            } else {
                // Loopar igenom registret och skriver ut artisterna i en accordion
                while ($record = $comments->fetch()) {
                    $commentid = $record['id'];
                    $songid = $record['songid'];
                    $title = $record['title'];
                    $text = $record['text'];

                    echo ('<h3> L&aring;t: ' . $title . ', CommentID: ' . $commentid . '</h3>');
                    echo ('<div><form action="adminComment.php" method="post" name="frmComment">');
                    echo ('id: ' . $commentid . '<br />');
                    echo ('songid: ' . $songid . '<br />');
                    echo ('text: ' . $text . '<br />');
                    // hidden id
                    echo ('<input type="hidden" name="hidId" value="' . $commentid . '" />');
                    // hidden text
                    echo ('<input type="hidden" name="hidText" value="' . $text . '" />');
                    // delete button
                    echo ('<input type="submit" name="btnDelete" value="Delete" />');
                    echo ('</form></div>');
                }
            }
        } catch(Exception $e) {
            echo 'Gick ej att lista kommentarer: ' . $e->getMessage();
        }
    }
    
	/**
	*	Funktionen deleteComment tar bort en befinlig kommentar från databasen. 
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inCommentId string Primärnyckeln för kommentaren som skall tas bort
	*/
	function deleteComment($inDBConnection, $inCommentId) {
        
        try {
            // Kod för att ta bort klickad kommentar
            // prepare skyddar mot SQL injection
            // http://php.net/manual/en/pdo.prepare.php
            $comments = $inDBConnection->prepare('DELETE FROM tblcomment WHERE id=?;');
            $comments->bindParam(1, $inCommentId);
            $comments->execute();
        } catch(Exception $e) {
            echo 'Kan inte ta bort kommentar: ' . $e.getMessage();
        }
        
    }