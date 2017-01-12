  <?php
 	
	/**
	*	Funktionen validateAndMoveUploadedFile validerar filändelse och flyttar en fil från tmp-katalogen till angiven katalog.
	*	Om något av villkoren inte uppfylls kastas ett undantag med en beskrivning om vad som är fel.
	*	
	*	@param string $inFileExtension Filändelsen för giltig fil (jpg eller ogg).
	*/
	function validateAndMoveUploadedFile($inFileExtension) {
	
		$uploadErrorMsg = array(
			0 => "There is no error, the file uploaded with success",
			1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
			2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
			3 => "The uploaded file was only partially uploaded",
			4 => "No file was uploaded",
			6 => "Missing a temporary folder",
			7 => "File can not be written to disk",
			8 => "An issue with PHPs configuration caused the upload to fail"
		);
		
		$fileComponent = "";
		$inFileExtension = strtolower($inFileExtension);
		
		if($inFileExtension == "jpg") {
			$fileComponent = "filePictureFileName";
		}
		else {
			$fileComponent = "fileSoundFileName";
		}
		
		//När ni använder funktionen första gången skall ni kontrollera så att PATH konstanten blir korrekt!
		if(strtoupper(substr(PHP_OS, 0, 3)) == "WIN") {
			//WAMP
			define("PATH", $_SERVER["DOCUMENT_ROOT"]."/musicsite/musicsite/upload_".$inFileExtension."/");
		}
		else {	
			//XAMP
			// OLLE HÄR LANDAR DET NOG PÅ DIN MAC SÅ FIXA TILL RÄTT FILVÄG FÖR DIG OCH TA BORT MIN KOMMENTAR :D
			define("PATH", $_SERVER["DOCUMENT_ROOT"]."/ISGB24/upload_".$inFileExtension."/");
		}
		
		/* Denna if-sats skall ni flytta till adminSong och adminArtist och skall användas i samband med INSERT & UPDATE
		if(empty($_FILES) && empty($_POST) && isset($_SERVER["REQUEST_METHOD"]) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
			throw new Exception("Du försöke skicka för mycket data.<br />\n'max_post_size' är idag satt till ".ini_get("post_max_size"));
		}
		*/
		
		if($_FILES[$fileComponent]["error"] != UPLOAD_ERR_OK) {
			throw new Exception($uploadErrorMsg[$_FILES[$fileComponent]["error"]]);
		}

		$fileExtension = substr($_FILES[$fileComponent]["name"], - 3);
		$fileExtension = strtolower($fileExtension);
		
		if($fileExtension != $inFileExtension){
			throw new Exception("Endast filer med filändelsen ".$inFileExtension." är giltiga!");
		}
		
		if(!move_uploaded_file($_FILES[$fileComponent]["tmp_name"], PATH.$_FILES[$fileComponent]["name"])) {
			throw new Exception("Det gick inte att flytta ".$_FILES[$fileComponent]["name"]);
		}

	}
