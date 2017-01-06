<?php
	
	$script = "artistFunctions.js";
	$title = "Admin Artist";
	$accordion = TRUE;
	$jquery = TRUE;
    $slimbox = TRUE;
	//$admin = "secretpage";
	
	include("incl/header.php");

    try {
        $db = myDBConnect();
    } catch (Exception $e) {
        // Skriv ut error på sidan senare.
        $error = 'Error connecting to DB: ' . $e->getMessage();
    }
	
?>

<div id="content">

    <h1>Admin Artist</h1>
    <hr />

    <!-- Hårdkodad HTML5 för Admin Artist -->

     <fieldset>
        <legend>New/Edit Artist</legend>

        <span id="jsErrorMsg" class="errorClass"></span>

        <form action="adminArtist.php" method="post" name="frmNewUpdateArtist" id="frmNewUpdateArtist" enctype="multipart/form-data">
            <input type="hidden" id="hidId" name="hidId" />
            <input type="hidden" id="hidPictureFileName" name="hidPictureFileName" />
            <label>
                Artist
                <br />
                <input type="text" id="txtArtist" name="txtArtist" title="Artist"/>
            </label>
            <br />
            <label>
                Picture
                <br />
                <input type="file" id="filePictureFileName" name="filePictureFileName" title="Picture" />
            </label>
            <br />
            <input type="submit" id="btnSave" name="btnSave" value="Save" />
            <input type="button" id="btnReset" name="btnReset" value="Reset" />
        </form>
    </fieldset>
    
    <?php

        $stmt = mysqli_query($db, 'SELECT * FROM tblartist;');

        while ($record = mysqli_fetch_assoc($stmt)) {
            echo('Some column: ' . $record['name']);
        }
    
    ?>

    <div id="accordion"> <!-- Accordion start -->

        <h3>AC/DC</h3>
        <div>
            <form action="adminArtist.php" method="post" name="frmArtist">
                id: 76<br />
                name: AC/DC <br />
                picture: acdc.jpg <br />
                changedate: 2013-09-25 11:36:46 <br />
                <a href="upload_jpg/acdc.jpg" rel="lightbox"><img src="upload_jpg/acdc.jpg" alt="acdc.jpg." class="imgAnimation" rel="lightbox" /></a><br />
                <input type="button" name="btnEdit" value="Edit" >
                <input type="submit" name="btnDelete" value="Delete" />
                <input type="hidden" name="hidId" value="76" />
                <input type="hidden" name="hidPictureFileName" value="acdc.jpg" />
                <input type="hidden" name="hidArtist" value="AC/DC" />
            </form>

        </div>

        <h3>Laleh</h3>
        <div>
            <form action="adminArtist.php" method="post" name="frmArtist">
                id: 77<br />
                name: Laleh <br />
                picture: laleh.jpg <br />
                changedate: 2013-09-25 11:36:46 <br />
                <a href="upload_jpg/laleh.jpg" rel="lightbox"><img src="upload_jpg/laleh.jpg" alt="laleh.jpg." class="imgAnimation" /></a><br />
                <input type="button" name="btnEdit" value="Edit" >
                <input type="submit" name="btnDelete" value="Delete" />
                <input type="hidden" name="hidId" value="77" />
                <input type="hidden" name="hidPictureFileName" value="laleh.jpg" />
                <input type="hidden" name="hidArtist" value="Laleh" />
            </form>
        </div>

    </div> <!-- Accordion end -->

</div>
					
<?php include("incl/footer.php");


