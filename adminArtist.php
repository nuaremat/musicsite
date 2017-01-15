<?php
	
	$script = "artistFunctions.js";
	$title = "Admin Artist";
	$accordion = TRUE;
	$jquery = TRUE;
    $slimbox = TRUE;
	$admin = "secretpage";

    include('src/databaseFunctions.php');
    include('src/loginFunctions.php');

    // Kolla om man är inloggad
    if (!checkSession()) {
        header("Location: login.php");
    }

    try {
        $db = myDBConnect();
    } catch (Exception $e) {
        // variabel som används för att skriva ut errormeddelande på sidan
        $error = 'Error connecting to DB: ' . $e->getMessage();
    }
	
	include("incl/header.php");
    include("src/artistFunctions.php");
    include("src/uploadFunctions.php");
	
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
                
                if(empty($_FILES) && empty($_POST) && isset($_SERVER["REQUEST_METHOD"]) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
                    throw new Exception("Du försöke skicka för mycket data.<br />\n'max_post_size' är idag satt till ".ini_get("post_max_size"));
                }

                $stmt = $db->prepare('SELECT * FROM tblartist WHERE id = ?;');
                $stmt->bindParam(1, $_POST['hidId']);
                $stmt->execute();
                
                if($stmt->rowCount() == 0) {
                    // Kör insertArtist om artist ID inte finns
                    insertArtist($db, $_POST['txtArtist'], $_FILES['filePictureFileName']);
                } else {
                    // Kör updateArtist om artist ID redan finns
                    $record = $stmt->fetch();
                    $oldName = $record['picture'];
                    // $_FILES söker upp namnet direkt för att underlätta updateArtist()
                    updateArtist($db, $_POST['hidId'], $_POST['txtArtist'], $_FILES['filePictureFileName']['name'], $oldName);
                }
                
            } elseif (isset($_POST['btnDelete'])) {
                
                 // Anropar funktionen för att ta bort vald artist
                deleteArtist($db, $_POST['hidId'], $_POST['hidPictureFileName']);
                
            } 
        ?>

        <?php printArtistForm(); ?>
    </fieldset>

    <div id="accordion"> <!-- Accordion start -->

        <?php listArtists($db); ?>

    </div> <!-- Accordion end -->

</div>
					
<?php include("incl/footer.php");


