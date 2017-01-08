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
        
        <?php
            if (isset($_POST['btnSave'])) {
                
                insertArtist($db, $_POST['txtArtist'], $_FILES['filePictureFileName']);
                echo " " . $_POST['txtArtist'] . " tillagd!";
                
            } elseif (isset($_POST['btnDelete'])) {
                
                $hidId = $_POST['hidId'];
                $hidPictureFileName = $_POST['hidPictureFileName'];
                $hidArtist = $_POST['hidArtist'];
                $message = $hidArtist . " borttagen!";
                
                echo $message;
                
                deleteArtist($db, $hidId, $hidPictureFileName);
                
            } elseif (isset($_POST['btnEdit'])) {
                
                $hidId = $_POST['hidId'];
                $filePictureFileName = $_POST['filePictureFileName'];
                $hidPictureFileName = $_FILES['hidPictureFileName'];
                $hidArtist = $_POST['hidArtist'];
                
                updateArtist($db, $hidId, $hidArtist, $newPictureFileName, $hidPictureFileName);
            }
        ?>

        <?php printArtistForm(); ?>
    </fieldset>

    <div id="accordion"> <!-- Accordion start -->

        <?php listArtists($db); ?>

    </div> <!-- Accordion end -->

</div>
					
<?php include("incl/footer.php");


