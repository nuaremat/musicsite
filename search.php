<?php

	$script = "searchFunctions.js"; 
	$title = "Search";
	$slimbox = TRUE;
	$jquery = TRUE;
	
    include('src/databaseFunctions.php');
    
    // Databasuppkoppling
    try {
        $db = myDBConnect();
    } catch (Exception $e) {
        // variabel som används för att skriva ut errormeddelande på sidan
        $error = 'Error connecting to DB: ' . $e->getMessage();
    }
    
	include("incl/header.php");
    include("src/searchFunctions.php");
?>
<div id="content">

    <h1>Search Artist and/or Song!</h1>
    <hr />
    <?php printSearchForm(); ?>
    <fieldset><legend>Searchresult Song</legend>
    <?php
        if(isset($error)) {
            echo $error;
        }
    ?>	
    <?php 
        if (isset($_POST['btnSearch'])){
            listSongs($db, $_POST['txtSearch']);
            listArtists($db, $_POST['txtSearch']); 
        }
    ?>
    </fieldset>
</div>

<?php include("incl/footer.php");