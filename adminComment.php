<?php
	
	$script="commentFunctions.js";
	$title="Admin comment";
	$accordion = TRUE;
	$jquery = TRUE;
	//$admin = "secretpage";
	
	include("incl/header.php");
    include("src/commentFunctions.php");

    try {
        $db = myDBConnect();
    } catch (Exception $e) {
        // Skriv ut error på sidan senare.
        $error = 'Error connecting to DB: ' . $e->getMessage();
    }
	
?>

<div id="content">

    <h1>Admin Comment</h1>
    <hr />

    <!-- Hårdkodad HTML5 för Admin Comment -->
            
    <div id="accordion">
<!--
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
-->
        <?php listComments($db); ?>
        <?php
        
            if (isset($_POST)) {
                //var_dump($_POST['hidId']);
                deleteComment($db, $_POST['hidId']);
            }
        
        ?>
    </div>
</div>

<?php include("incl/footer.php");