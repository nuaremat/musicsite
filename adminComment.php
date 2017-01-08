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
        <?php
        
            if (isset($_POST['btnDelete'])) {
                $hidId = $_POST['hidId'];
                
                deleteComment($db, $hidId);
            }
        
        ?>
        
        <?php listComments($db); ?>
    </div>
</div>

<?php include("incl/footer.php");