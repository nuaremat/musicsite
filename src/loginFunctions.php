<?php
	/* Funktioner (inklusive parametrar) som behövs för att hantera användare och sessioner */
    // Större delen av detta är gjort med hjälp av funktionerna från räknestugan
	
	/**
	*	Funktionen validateUser söker ut antalet poster som matchar $inUserName och $inPassWord och returnerar talet (0 eller 1).
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $inUserName Användarnamn
	*	@param string $inPassWord Lösenord
	*
	*	@return int Antalet rader som matchar sökkriterierna
	*/
    function validateUser($inDBConnection, $inUserName, $inPassWord) {
        // prepare skyddar mot SQL injection
        // http://php.net/manual/en/pdo.prepare.php
        $stmt = $inDBConnection->prepare("SELECT username FROM tbladmin WHERE username = ? AND password = SHA1(?);");
        $stmt->bindParam(1, $inUserName);
        $stmt->bindParam(2, $inPassWord);
        $stmt->execute();

        $count = $stmt->rowCount();

        return $count;
    }
    
	/**
	*	Funktionen startSession() startar upp en session och sparar i denna sparar sessionsvariablerna usernamn och online.
	*	Funktionen tar inte emot någon data och returnerar heller ingen data.
	*/
	function startSession() {
        session_start();
        session_regenerate_id(true);
        $_SESSION["txtUserName"] = $_POST["txtUserName"];
        $_SESSION["datetime"] = date("Y-m-d H:i:s");
        $_SESSION["online"] = true;
    }
    
	/**
	*	Funktionen endSession() avslutar en befintlig session.
	*	Funktionen tar inte emot någon data och returnerar heller ingen data.
	*/
	function endSession() {
        session_unset();

        if (ini_get("session.use_cookies")) {
            $data = session_get_cookie_params();

            $path = $data["path"];
            $domain = $data["domain"];
            $secure = $data["secure"];
            $httponly = $data["httponly"];

            setcookie(session_name(), "", time() - 3600, $path, $domain, $secure, $httponly);
        }

        session_destroy();
    }
    
	/**
	*	Funktionen checkSesion() kontrolleras om en session är igång och om så är fallet genererar ett nytt sessionsid och returnerar sant. 
	*	Är ingen session igång returneras falskt.
	*	Funktionen tar inte emot någon data. 
	*
	*	@return boolean Om en användare är påloggad eller inte
	*/
	function checkSession() {
        session_start();
        $online = false;

        if (isset($_SESSION["online"])) {
            $online = true;
            session_regenerate_id(true);
        } else {
            endSession();
        }

        return $online;
    }

?>
