//artistFunctions.js

"use strict";

/**
*   http://api.jqueryui.com/accordion/
*/
$(function () {
    $('#accordion').accordion({
        collapsible: true,
        active: false
    });
});

// Kallar på validateArtistFormData när submit-knappen klickas
$('#btnSave').click(validateArtistFormData);

// Kallar på resetArtistFormData när reset-knappen klickas
$('#btnReset').click(resetArtistFormData);

// Kallar på copyArtistFormData när edit-knappen klickas
$('input[value=Edit]').click(function (e) {
    
    var dataId = $(this).siblings('input[name=hidId]').attr('value'),
        artist = $(this).siblings('input[name=hidArtist]').attr('value'),
        fileName = $(this).siblings('input[name=hidPictureFileName]').attr('value');
    
    // Skickar med värdet på det som ska kopieras som parametrar
    copyArtistFormData(dataId, fileName, artist);
});

// Kallar på verifyDeleteOfArtist när delete-knappen klickas
$('input[value=Delete]').click(function (e) {
    
    var inId = $(this).siblings('input[name=hidId]').attr('value'),
        inArtist = $(this).siblings('input[name=hidArtist]').attr('value'),
        // Variabel som är true/false beroende på vad som klickas i confirm-boxen
        val = verifyDeleteOfArtist(inId, inArtist);

    // Om man trycker på Avbryt händer ingenting
    if (!val) {
        e.preventDefault();
    }
    
});

/**
*	Funktionen resetArtistFormData rensar inmatad data i formuläret "frmNewUpdateArtist"
*	samt meddelandetexten (om något fel uppstått) i "jsErrorMsg".
*	@version 1.1
*	@author Peter Bellström
*/
function resetArtistFormData() {
	var theForm = document.getElementById("frmNewUpdateArtist");
    theForm.hidId.value = "";
    theForm.hidPictureFileName.value = "";
    theForm.reset();
	window.document.getElementById("jsErrorMsg").innerHTML = "";
}

/**
*	Funktionen copyArtistFormData kopierar inkommande parametrar till formuläret "frmNewUpdateArtist".
*	@param {Number} inId - Id (primärnyckel i databasen) för artisten som skall redigeras.
*	@param {String} inFileName - Filnamn för artisten som skall redigeras.
*	@param {String} inArtist - Artistnamn för artisten som skall redigeras.
*	@version 1.0
*	@author Peter Bellström
*/
function copyArtistFormData(inId, inFileName, inArtist) {
	var theForm = document.getElementById("frmNewUpdateArtist");
    theForm.hidId.value = inId;
    theForm.hidPictureFileName.value = inFileName;
    theForm.txtArtist.value = inArtist;
}

/**
*	Funktionen verifyDeleteOfArtist visar en dialogruta med "OK" och "Cancel".
*	Texten i dialogrutan består av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck på "OK" och falskt vid tryck på "Cancel.
*	@param {Number} inId - Id (primärnyckel i databasen) för artisten som skall tas bort.
*	@param {String} inArtist - Artistnamn för artisten som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellström
*/
function verifyDeleteOfArtist(inId, inArtist) {
    return window.confirm("Delete " + inId + " " + inArtist + "?");
}

/**
*	Funktionen checkFileExtension kontrollerar filändelsen för inkommande parameter och
*	returnerar sant om det är "jpg" annars falskt.
*	@param {String} inFileName - Filnamn för filen som skall kontrolleras.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellström
*/
function checkFileExtension(inFileName) {
    var fileExtension = inFileName.substring(inFileName.length - 3);
	
	fileExtension = fileExtension.toLowerCase();

    if (fileExtension !== "jpg")
    {
        return false;
    }

    return true;

}

/**
*	Funktionen validateArtistFormData kontrollerar att indata i formuläret "frmNewUpdateArtist" uppfyller
*	givna villkor. Om alla villkor uppfylls returneras sant om inte visas en felet i elementet med id=jsErrorMsg.
*	Därefter sätts focus på det elementet som genererade felet och avslutningsvis returneras falskt.
*	@returns {Boolean}
*	@version 1.1
*	@author Peter Bellström
*/
function validateArtistFormData() {
	var theForm = document.getElementById("frmNewUpdateArtist");

	try
	{
		if(theForm.txtArtist.value === "")
		{
			//throw new Error("Artistname is missing!");
			throw {
					"name" : "",
					"message" : "Artistname is missing!",
					"id" : theForm.txtArtist.getAttribute("id")
				};
		}
		
		if(theForm.hidId.value === "")
		{
			if(theForm.filePictureFileName.value === "")
            {
                //throw new Error("Picturename is missing!");
				throw {
					"name" : "",
					"message" : "Picturename is missing!",
					"id" : theForm.filePictureFileName.getAttribute("id")
				};
		   }
            else
            {
                if(checkFileExtension(theForm.filePictureFileName.value) === false)
				{
					//throw new Error("Only jpg files are valid!");
					throw {
						"name" : "",
						"message" : "Only jpg files are valid!",
						"id" : theForm.filePictureFileName.getAttribute("id")
					};
				}
            }
			
		}
	
		if(theForm.hidId.value !== "")
		{
			if(theForm.filePictureFileName.value !== "")
            {
                if(checkFileExtension(theForm.filePictureFileName.value) === false)
				{
					//throw new Error("Only jpg files are valid!");
					throw {
						"name" : "",
						"message" : "Only jpg files are valid!",
						"id" : theForm.filePictureFileName.getAttribute("id")
					};
				}
            }
			
		}
		
		return true;
	
	}
	catch(oException)
	{
		window.document.getElementById("jsErrorMsg").innerHTML = oException.message;
		window.document.getElementById(oException.id).focus();
		
		return false;
	}
}
