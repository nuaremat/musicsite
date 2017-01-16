<?php
    $title="Logout";

    include("src/loginFunctions.php");

    // Kolla om man är inloggad
    if (checkSession()) {
        endSession();
    } else {
        header("Location: login.php");
        exit();
    }

    include("incl/header.php");
    
?>

<div id="content">

    <h1> You are no longer logged on!</h1>
    <hr />

</div>

<?php include("incl/footer.php"); ?>