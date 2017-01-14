<?php  
    $title="Login";

    ini_set("display_errors", 1);
    include('src/databaseFunctions.php');
    include('src/loginFunctions.php');
    // Om man trycker på "Login"-knappen i login.php
    if (isset($_POST["btnLogin"])) {
        try {
            $db = myDBConnect();
            // kollar om användaren finns och om lösenordet är rätt
            // Måste connecta med databasen innan, men include header skriver ut html så då fungerar inte startSession()
            if (validateUser($db, $_POST["txtUserName"], $_POST["txtPassWord"]) === 1) {
                startSession();
                header("Location: adminArtist.php");
                exit();
            } else {
                throw new Exception("Felaktigt användarnamn och/eller lösenord!");
            }

        } catch (Exception $e) {
            $error = 'Error connecting to DB: ' . $e->getMessage();
        }
    }

    include("incl/header.php");
?>

<div id="content">

    <h1><?php echo($title); ?></h1>
    <hr />

    <fieldset>
        <legend>Type username and password</legend>
        <form action="login.php" method="post" name="frmLogin" >
            <label>
                Name
                <br />
                <input type="text" name="txtUserName" id="txtUserName" title="Username" placeholder="Type your username!" autofocus="autofocus" required="required" />
            </label>
            <br />
            <label>
                Password
                <br />
                <input type="password" name="txtPassWord" id="txtPassWord" title="Password" placeholder="Type your Password!" required="required" />
            </label>
            <br />
            <input type="submit" name="btnLogin" id="btnLogin" value="Login" />
            <input type="reset" name="btnReset" id="btnReset" value="Reset" />
        </form>
        <?php
            if(isset($error)) {
                echo $error;
            }
        ?>
    </fieldset>
</div>

<?php include("incl/footer.php"); ?>