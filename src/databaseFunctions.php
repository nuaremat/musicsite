<?php

	/* http://us3.php.net/manual/en/book.mysqli.php */
	
	/**
	*	Funktionen myDBConnect kopplar upp webbapplikationen mot MySQL med angivna konstanter.
	*	Om uppkopplingen misslyckas kastas ett undantag. Om allt fungerar returneras databaskopplingen.
	*
	*	@return resource Kopplingen till MySQL mot given databas.
	*/
	function myDBConnect() {
	
		define("DB_HOST", "localhost");
		define("DB_USERNAME", "mysqluser");
		define("DB_PASSWORD", "mysqlpassword");
		define("DB", "ISGB24");
	
		$dbConnection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB);
		
		if (!$dbConnection) {
			throw new Exception(mysqli_connect_errno().": ".mysqli_connect_error());
		}
		
		return $dbConnection;
	}
	
	/**
	*	Funktionen myDBQuery exekverar en SQL fr�ga mot en given databas.
	*	Om SQL fr�gan misslyckas kastas ett undantag. Om allt fungerar returneras en tabell med efterfr�gad data.
	*
	*	@param resurce $dbConnection Databaskoppling
	*	@param string $strSQL SQL fr�gan i klartext
	*	@return resource Tabell med uts�kt data.
	*/
	function myDBQuery($dbConnection, $strSQL) {	
	
		if(!$recordSet = mysqli_query($dbConnection, $strSQL)) {
			throw new Exception(mysqli_errno($dbConnection).": ".mysqli_error($dbConnection));
		}
		
		return $recordSet;
	}
	
	/**
	*	Funktionen myDBFreeResult frig�r minnet f�r parametern $recordSet.
	*
	*	@param resurce $recordSet Tabellen vars minne som skall frig�ras.
	*/
	function myDBFreeResult($recordSet) {
	
		mysqli_free_result($recordSet);
		
	}
	
	/**
	*	Funktionen myDBClose st�nger kopplingen mot given databas i MySQL.
	*	Om st�ngningen misslyckas kastas ett undantag.
	*
	*	@param resurce $dbConnection Databaskoppling
	*/
	function myDBClose($dbConnection) {
	
		if(!mysqli_close($dbConnection)) {
			throw new Exception(mysqli_errno($dbConnection).": ".mysqli_error($dbConnection));
		}
	}