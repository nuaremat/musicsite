//commentFunctions.js

"use strict";

$(function () {
    $('#accordion').accordion({
        collapsible: true,
        active: false
    });
});

// Funktion f�r vad som h�nder n�r man trycker p� Delete
$('input[value=Delete]').click(function (e) {
    
    var dataId = $(this).siblings('input[name=hidId]').attr('value'),
        inText = $(this).siblings('input[name=hidText]').attr('value'),
        // Variabel som �r true/false beroende p� vad som klickas i confirm-boxen
        val = verifyDeleteOfComment(dataId, inText);

    // Om man trycker p� Avbryt h�nder ingenting
    if (!val) {
        e.preventDefault();
    }
    
    // Om man trycker p� OK ska data skickas till servern
    
});

/**
*	Funktionen verifyDeleteOfComment visar en dialogruta med "OK" och "Cancel".
*	Texten i dialogrutan best�r av tal + text i inkommande parametrar.
*	Funktionen returnerar sant vid tryck p� "OK" och falskt vid tryck p� "Cancel.
*	@param {Number} inId - Id (prim�rnyckel i databasen) f�r kommentaren som skall tas bort.
*	@param {String} inText - Texten i kommentaren som skall tas bort.
*	@returns {Boolean}
*	@version 1.0
*	@author Peter Bellstr�m
*/
function verifyDeleteOfComment(inId, inText) {
    return window.confirm("Delete " + inId + ": " + inText + "?");
}