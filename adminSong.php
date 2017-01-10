<?php
	
	$script="songFunctions.js";
	$title="Admin song";
	$accordion = TRUE;
	$jquery = TRUE;
//	$admin = "secretpage";
	
	include("incl/header.php");
    include("src/songFunctions.php");
	
?>
<div id="content">

    <h1>Admin Song</h1>
    <hr />

    <!-- Hårdkodad HTML5 för Admin Song -->

    <fieldset>
      
        <?php printSongForm($db); ?>

    </fieldset>

    <div id="accordion">
        
        <?php listSongs($db); ?>
        
    </div>

</div>

<?php include("incl/footer.php"); ?>


