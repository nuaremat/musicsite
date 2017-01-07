<?php
	
	$script = "artistFunctions.js";
	$title = "Admin Artist";
	$accordion = TRUE;
	$jquery = TRUE;
    $slimbox = TRUE;
	//$admin = "secretpage";
	
	include("incl/header.php");
    include("src/artistFunctions.php");
	
?>

<div id="content">

    <h1>Admin Artist</h1>
    <hr />

    <!-- Hårdkodad HTML5 för Admin Artist -->

     <fieldset>
        <legend>New/Edit Artist</legend>

        <span id="jsErrorMsg" class="errorClass"></span>

        <?php printArtistForm(); ?>
    </fieldset>
    
<!--
    <?php

        $stmt = mysqli_query($db, 'SELECT * FROM tblartist;');

        while ($record = mysqli_fetch_assoc($stmt)) {
            echo('Some column: ' . $record['name']);
        }
    
    ?>
-->

    <div id="accordion"> <!-- Accordion start -->

        <?php listArtists($db); ?>

    </div> <!-- Accordion end -->

</div>
					
<?php include("incl/footer.php");


