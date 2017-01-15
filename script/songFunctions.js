//songFunctions.js

"use strict";

$(function () {
    $('#accordion').accordion({
        collapsible: true,
        active: false
    });
});

// Kör funktionen validateSongFormData när man trycker på Save
$('input[value=Save]').click(validateSongFormData);
// Kör funktionen resetSongFormData när man trycker på Reset
$('input[value=Reset]').click(resetSongFormData);
// Lyssnare för Edit-knappen
$('input[value=Edit]').click(function (e) {
    // Hämtar nödvändiga referenser till värden i formulärets element
    var dataId = $(this).siblings('input[name=hidId]').attr('value');
    var artistId = $(this).siblings('input[name=hidArtistId]').attr('value');
    var title = $(this).siblings('input[name=hidTitle]').attr('value');
    var fileName = $(this).siblings('input[name=hidSoundFileName]').attr('value');
    var count = $(this).siblings('input[name=hidCount]').attr('value');
    
    // Skickar med värdena med funktionen copySongFormData
    copySongFormData(dataId, fileName, artistId, title, count);
});

// Lyssnare för Delete-knappen
$('input[value=Delete]').click(function (e) {
    // Hämtar nödvändiga referenser till värden i formulärets element
    var dataId = $(this).siblings('input[name=hidId]').attr('value');
    var title = $(this).siblings('input[name=hidTitle]').attr('value');
    // Variabel som är true/false beroende på vad som klickas i confirm-boxen
    var val = verifyDeleteOfSong(dataId, title);
    
    // Om man trycker på Avbryt händer ingenting
    if(val===false)
    	e.preventDefault();
});

/**
*	Funktionen resetSongFormData rensar inmatad data i formuläret "frmNewUpdateSong"
*	samt meddelandetexten (om något fel uppstått) i "jsErrorMsg".
*	@version 1.1
*	@author Peter Bellström
*/
function resetSongFormData() {

	var theForm = document.getElementById("frmNewUpdateSong");
	
    theForm.hidId.value = "";
    theForm.hidSoundFileName.value = "";
    theForm.reset();
	window.document.getElementById("jsErrorMsg").innerHTML = "";
}

/**
*	Funktionen copySongFormData kopierar inkommande parametrar till formuläret "frmNewUpdateSong".
*	@param {Number} inId - Id (primärnyckel i databasen) för sången som skall redigeras.
*	@param {String} inFileName - Filnamn för sången som skall redigeras.
*	@param {Number} inArtistId - Id (främmandenyckel i databasen) för artisten sången knyts till.
*	@param {String} inTitle - Sångtitel för sången som skall redigeras.
*	@param {Number} inCount - Antal "gilla" får sången som skall redigeras.
*	@version 1.0
*	@author Peter Bellström
*/
function copySongFormData(inId, inFileName, inArtistId, inTitle, inCount) {

	var theForm = document.getElementById("frmNewUpdateSong");
	
    theForm.hidId.value = inId;
    theForm.hidSoundFileName.value = inFileName;
    theForm.selArtistId.value = inArtistId;
	theForm.txtTitle.value = inTitle;
    theForm.txtCount.value = inCount;
}

/**
*	Funktionen verifyDeleteOfSong visar en dialogruta med "OK" och "Cancel".
*	Texten i dialogrutan består av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck på "OK" och falskt vid tryck på "Cancel.
*	@param {Number} inId - Id (primärnyckel i databasen) för sången som skall tas bort.
*	@param {String} inTitle - Sångtitel för sången som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellström
*/
function verifyDeleteOfSong(inId, inTitle) {
   return window.confirm("Delete " + inId + " " + inTitle + "?");
}

/**
*	Funktionen checkFileExtension kontrollerar filändelsen för inkommande parameter och
*	returnerar sant om det är "ogg" annars falskt.
*	@param {String} inFileName - Filnamn för filen som skall kontrolleras.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellström
*/
function checkFileExtension(inFileName) {

    var fileExtension = inFileName.substring(inFileName.length - 3);
	fileExtension = fileExtension.toLowerCase();

    if(fileExtension !== 'ogg'){
        return false;
    }
    return true;
}

/**
*	Funktionen validateSongFormData kontrollerar att indata i formuläret "frmNewUpdateSong" uppfyller
*	givna villkor.Om alla villkor uppfylls returneras sant om inte visas en felet i elementet med id=jsErrorMsg.
*	Därefter sätts focus på det elementet som genererade felet och avslutningsvis returneras falskt.
*	@returns {Boolean}
*	@version 1.1
*	@author Peter Bellström
*/
function validateSongFormData() {
	var theForm = document.getElementById("frmNewUpdateSong");

  	try {
		if(theForm.selArtistId.selectedIndex === 0) {
			//throw new Error("Artist is missing!");
			throw {
					"name" : "",
					"message" : "Arist is missing!",
					"id" : theForm.selArtistId.getAttribute("id")
			};
		}
		
		if(theForm.txtTitle.value === "") {
			//throw new Error("Songtitle is missing!");
			throw {
					"name" : "",
					"message" : "Songtitle is missing!",
					"id" : theForm.txtTitle.getAttribute("id")
			};
		}
		
		if(theForm.hidId.value === ""){
			if(theForm.fileSoundFileName.value === "") {
                //throw new Error("Soundname is missing!");
				throw {
					"name" : "",
					"message" : "Soundname is missing!",
					"id" : theForm.fileSoundFileName.getAttribute("id")
				};
            }
            else {
                if(checkFileExtension(theForm.fileSoundFileName.value) === false) {
					//throw new Error('Only ogg files are valid!');
					throw {
						"name" : "",
						"message" : "Only ogg files are valid!",
						"id" : theForm.fileSoundFileName.getAttribute("id")
					};
				}
            }
			
		}
	
		if(theForm.hidId.value !== "") {
			if(theForm.hidSoundFileName.value !== null || theForm.hidSoundFileName.value !== "") {
                if(checkFileExtension(theForm.hidSoundFileName.value) == false) {
					//throw new Error("Only ogg files are valid!");
					throw {
						"name" : "",
						"message" : "Only ogg files are valid!",
						"id" : theForm.fileSoundFileName.getAttribute("id")
					};
				}
            }
		}
		
		if(theForm.txtCount.value === "") {
			//throw new Error("Count is missing!");
			throw {
				"name" : "",
				"message" : "Count is missing!",
				"id" : theForm.txtCount.getAttribute("id")
			};
		}
		
		if(isNaN(theForm.txtCount.value)) {
			//throw new Error("Count is not a number!");
			throw {
				"name" : "",
				"message" : "Count is not a number!",
				"id" : theForm.txtCount.getAttribute("id")
			};
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
