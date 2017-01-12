<?php

	$script="searchFunctions.js"; 
	$title="Search";
	$slimbox = TRUE;
	$jquery = TRUE;
	
	include("incl/header.php");
    include("src/searchFunctions.php");
?>
<div id="content">

    <h1>Search Artist and/or Song!</h1>
    <hr />

    <?php printSearchForm(); ?>

    <!-- Hårdkodad HTML5 för utsökning av song -->
    		
  <?php 
                if (isset($_POST['btnSearch'])){
                    listSongs($db, $_POST['txtSearch']);
                    listArtists($db, $_POST['txtSearch']); 
                }
            ?>

</div>

<?php include("incl/footer.php");