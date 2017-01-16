<?php
	
	$script="commentFunctions.js";
	$title="Admin comment";
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
    include("src/commentFunctions.php");
	
?>

<div id="content">

    <h1>Admin Comment</h1>
    <hr />
    <?php
        if(isset($error)) {
            echo $error;
        }
    ?>
    <div id="accordion"> <!-- Accordion start -->
        <?php
            if (isset($_POST['btnDelete'])) {
                $hidId = $_POST['hidId'];
                
                deleteComment($db, $hidId);
            }
        ?>
        <?php listComments($db); ?>
    </div> <!-- Accordion end -->
</div>

<?php include("incl/footer.php");