<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera kommentarer */
	
	/**
	*	Funktionen listComments s�ker ut samtliga kommentarer som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmComment).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga kommentarer i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
    function listComments($inDBConnection){
        
        // Kod f�r att lista kommentarer ur databasen h�r
        $comments = $inDBConnection->query('SELECT * FROM tblcomment;');

        // Kollar om det finns n�gra rader i tabellen
        if ($comments->rowCount() == 0) {
            echo ('Det finns inga kommentarer i databasen!');
        } else {
            while ($record = $comments->fetch()) {
                $id = $record['id'];
                $songid = $record['songid'];
                $text = $record['text'];
                $insertdate = $record['insertdate'];

                echo ('<h3>' . $id . '</h3>');
                echo ('<div><form action="adminComment.php" method="post" name="frmComment">');
                echo ('id: ' . $id . '<br />');
                echo ('songid: ' . $songid . '<br />');
                echo ('text: ' . $text . '<br />');
                // hidden id
                echo ('<input type="hidden" name="hidId" value="' . $id . '" />');
                // hidden text
                echo ('<input type="hidden" name="hidText" value="' . $text . '" />');
                // delete button
                echo ('<input type="submit" name="btnDelete" value="Delete" />');
                echo ('</form></div>');
            }
        }
        
    }
    
	/**
	*	Funktionen deleteComment tar bort en befinlig kommentar fr�n databasen. 
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param $inCommentId string Prim�rnyckeln f�r kommentaren som skall tas bort
	*/
	function deleteComment($inDBConnection, $inCommentId) {
        
        // Kod f�r att ta bort klickad kommentar
        $comments = $inDBConnection->prepare('DELETE FROM tblcomment WHERE id=' . $inCommentId . ';');
        $comments->execute();
        
    }