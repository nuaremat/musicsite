<?php
	
	$script="commentFunctions.js";
	$title="Admin comment";
	$accordion = TRUE;
	$jquery = TRUE;
	//$admin = "secretpage";
	
	include("incl/header.php");
    include("src/commentFunctions.php");
	
?>

<div id="content">

    <h1>Admin Comment</h1>
    <hr />

    <!-- Hårdkodad HTML5 för Admin Comment -->
            
    <div id="accordion">
        <?php listComments($db); ?>
        <?php
        
            if (isset($_POST['btnDelete'])) {
                deleteComment($db, $_POST['hidId']);
            }
        
        ?>
    </div>
</div>

<?php include("incl/footer.php");