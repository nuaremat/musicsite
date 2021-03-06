<?php
	
	$script="songFunctions.js";
	$title="Admin song";
	$accordion = TRUE;
	$jquery = TRUE;
	$admin = "secretpage";
	
    include('src/databaseFunctions.php');    include('src/loginFunctions.php');

    // Kolla om man är inloggad
    if (!checkSession()) {
        header("Location: login.php");
    }

    // Databasuppkoppling
    try {
        $db = myDBConnect();
    } catch (Exception $e) {
        // variabel som används för att skriva ut errormeddelande på sidan
        $error = 'Error connecting to DB: ' . $e->getMessage();
    }
    
	include("incl/header.php");
    include("src/songFunctions.php");
    include("src/uploadFunctions.php");
	
?>
<div id="content">

    <h1>Admin Song</h1>
    <hr />

    <fieldset>
        <legend>New/Edit Song</legend>

        <span id="jsErrorMsg" class="errorClass"></span>
        <?php
            if(isset($error)) {
                echo $error;
            }
        ?>
        <?php printSongForm($db); ?>

        <?php
            if (isset($_POST['btnSave'])) {
                
                if(empty($_FILES) && empty($_POST) && isset($_SERVER["REQUEST_METHOD"]) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
                    throw new Exception("Du försöke skicka för mycket data.<br />\n'max_post_size' är idag satt till ".ini_get("post_max_size"));
                }
                
                // prepare skyddar mot SQL injection
                // http://php.net/manual/en/pdo.prepare.php
                $stmt = $db->prepare('SELECT * FROM tblsong WHERE id = ?;');
                $stmt->bindParam(1, $_POST['hidId']);
                $stmt->execute();
                
                if($stmt->rowCount() == 0) {
                    // Kör insertSong om sång ID inte finns
                    insertSong($db, $_POST['selArtistId'], $_POST['txtCount'], $_POST['txtTitle'], $_FILES['fileSoundFileName']); 
                } else {
                    // Kör updateSong om sång ID redan finns
                    $record = $stmt->fetch();
                    $oldName = $record['sound'];
                    // Accessar direkt namnet för nya filen för enklare hantering i updateSong()
                    updateSong($db, $_POST['hidId'], $_POST['selArtistId'], $_POST['txtCount'], $_POST['txtTitle'], $_FILES['fileSoundFileName']['name'], $oldName);
                }
            } 
            elseif (isset($_POST['btnDelete'])) {
                // Anropar funktionen för att ta bort vald låt
                deleteSong($db, $_POST['hidId'], $_POST['hidSoundFileName']);
            } 
        ?>
        
    </fieldset>

    <div id="accordion"> <!-- Accordion start -->

        <?php listSongs($db); ?>
        
    </div> <!-- Accordion end -->

</div>

<?php include("incl/footer.php"); ?>


