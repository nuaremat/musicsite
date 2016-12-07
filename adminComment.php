<?php
	
	$script="commentFunctions.js";
	$title="Admin comment";
	$accordion = TRUE;
	$jquery = TRUE;
	//$admin = "secretpage";
	
	include("incl/header.php");
	
?>

<div id="content">

    <h1>Admin Comment</h1>
    <hr />

    <!-- Hårdkodad HTML5 för Admin Comment -->
            
    <div id="accordion">
        <h3>Kommentar-ID: 58</h3>
        <div>
            <form action="adminComment.php" method="post" name="frmComment">

                id: 58<br />
                songid: 22<br />
                text: hahahah<br />
                insertdate: 2013-10-22 11:27:48<br />
                <input type="hidden" name="hidId" value="58" />
                <input type="hidden" name="hidText" value="hahahah" />
                <input type="submit" name="btnDelete" value="Delete" />

            </form>

        </div>
        
        <h3>Kommentar-ID: 57</h3>
        <div>

            <form action="adminComment.php" method="post" name="frmComment">

                id: 57<br />
                songid: 22<br />
                text: Bästa låten...<br />
                insertdate: 2013-09-27 08:58:55<br />
                <input type="hidden" name="hidId" value="57" />
                <input type="hidden" name="hidText" value="B�sta l�ten..." />
                <input type="submit" name="btnDelete" value="Delete" />

            </form>
        </div>
    </div>
</div>

<?php include("incl/footer.php");