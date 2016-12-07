//commentFunctions.js

"use strict";

$(function () {
    $('#accordion').accordion({
        collapsible: true,
        active: false
    });
});

// Funktion för vad som händer när man trycker på Delete
$('input[value=Delete]').click(function (e) {
    
    var dataId = $(this).siblings('input[name=hidId]').attr('value'),
        inText = $(this).siblings('input[name=hidText]').attr('value'),
        // Variabel som är true/false beroende på vad som klickas i confirm-boxen
        val = verifyDeleteOfComment(dataId, inText);

    // Om man trycker på Avbryt händer ingenting
    if (!val) {
        e.preventDefault();
    }
    
    // Om man trycker på OK ska data skickas till servern
    
});

/**
*	Funktionen verifyDeleteOfComment visar en dialogruta med "OK" och "Cancel".
*	Texten i dialogrutan består av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck på "OK" och falskt vid tryck på "Cancel.
*	@param {Number} inId - Id (primärnyckel i databasen) för kommentaren som skall tas bort.
*	@param {String} inText - Texten i kommentaren som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellström
*/
function verifyDeleteOfComment(inId, inText) {
    return window.confirm("Delete " + inId + ": " + inText + "?");
}