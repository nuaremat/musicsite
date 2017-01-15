//songFunctions.js

"use strict";

$(function () {
    $('#accordion').accordion({
        collapsible: true,
        active: false
    });
});

// K�r funktionen validateSongFormData n�r man trycker p� Save
$('input[value=Save]').click(validateSongFormData);
// K�r funktionen resetSongFormData n�r man trycker p� Reset
$('input[value=Reset]').click(resetSongFormData);
// Lyssnare f�r Edit-knappen
$('input[value=Edit]').click(function (e) {
    // H�mtar n�dv�ndiga referenser till v�rden i formul�rets element
    var dataId = $(this).siblings('input[name=hidId]').attr('value');
    var artistId = $(this).siblings('input[name=hidArtistId]').attr('value');
    var title = $(this).siblings('input[name=hidTitle]').attr('value');
    var fileName = $(this).siblings('input[name=hidSoundFileName]').attr('value');
    var count = $(this).siblings('input[name=hidCount]').attr('value');
    
    // Skickar med v�rdena med funktionen copySongFormData
    copySongFormData(dataId, fileName, artistId, title, count);
});

// Lyssnare f�r Delete-knappen
$('input[value=Delete]').click(function (e) {
    // H�mtar n�dv�ndiga referenser till v�rden i formul�rets element
    var dataId = $(this).siblings('input[name=hidId]').attr('value');
    var title = $(this).siblings('input[name=hidTitle]').attr('value');
    // Variabel som �r true/false beroende p� vad som klickas i confirm-boxen
    var val = verifyDeleteOfSong(dataId, title);
    
    // Om man trycker p� Avbryt h�nder ingenting
    if(val===false)
    	e.preventDefault();
});

/**
*	Funktionen resetSongFormData rensar inmatad data i formul�ret "frmNewUpdateSong"
*	samt meddelandetexten (om n�got fel uppst�tt) i "jsErrorMsg".
*	@version 1.1
*	@author Peter Bellstr�m
*/
function resetSongFormData() {

	var theForm = document.getElementById("frmNewUpdateSong");
	
    theForm.hidId.value = "";
    theForm.hidSoundFileName.value = "";
    theForm.reset();
	window.document.getElementById("jsErrorMsg").innerHTML = "";
}

/**
*	Funktionen copySongFormData kopierar inkommande parametrar till formul�ret "frmNewUpdateSong".
*	@param {Number} inId - Id (prim�rnyckel i databasen) f�r s�ngen som skall redigeras.
*	@param {String} inFileName - Filnamn f�r s�ngen som skall redigeras.
*	@param {Number} inArtistId - Id (fr�mmandenyckel i databasen) f�r artisten s�ngen knyts till.
*	@param {String} inTitle - S�ngtitel f�r s�ngen som skall redigeras.
*	@param {Number} inCount - Antal "gilla" f�r s�ngen som skall redigeras.
*	@version 1.0
*	@author Peter Bellstr�m
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
*	Texten i dialogrutan best�r av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck p� "OK" och falskt vid tryck p� "Cancel.
*	@param {Number} inId - Id (prim�rnyckel i databasen) f�r s�ngen som skall tas bort.
*	@param {String} inTitle - S�ngtitel f�r s�ngen som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellstr�m
*/
function verifyDeleteOfSong(inId, inTitle) {
   return window.confirm("Delete " + inId + " " + inTitle + "?");
}

/**
*	Funktionen checkFileExtension kontrollerar fil�ndelsen f�r inkommande parameter och
*	returnerar sant om det �r "ogg" annars falskt.
*	@param {String} inFileName - Filnamn f�r filen som skall kontrolleras.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellstr�m
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
*	Funktionen validateSongFormData kontrollerar att indata i formul�ret "frmNewUpdateSong" uppfyller
*	givna villkor.Om alla villkor uppfylls returneras sant om inte visas en felet i elementet med id=jsErrorMsg.
*	D�refter s�tts focus p� det elementet som genererade felet och avslutningsvis returneras falskt.
*	@returns {Boolean}
*	@version 1.1
*	@author Peter Bellstr�m
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
