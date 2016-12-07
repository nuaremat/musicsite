//searchFunctions.js
"use strict";

// Toggla kommentarsfältet
// Källa: http://api.jquery.com/slidetoggle/
$('.toggle-button').click(function () {
    $(this).next('.toggle-result').slideToggle('slow');
});

// AJAX like-funktion
$('.like-button').click(function (e) {
    e.preventDefault();
    
    // sparar data-id till klickat element i en variabel
    var dataId = $(this).attr('data-id');
    
    // AJAXanrop
    $.ajax({
        url: 'ajax/likesong.php', // fil att hämta JSON ur
        type: 'POST',
        dataType: 'json',
        // Lyckat
        success: function (result) {
            // spanen med samma data-id som like-knappen visar resultatet på svaret från JSON
            $('span[data-id=' + dataId + ']').html(result['gilla']);
        },
        // Misslyckat
        error: function (xhr, status, error) {
            window.alert(xhr.statusText + " : " + status + " : " + error);
        }
    });
});

// AJAX kommentera-funktion
$('input[name="btnSave"]').click(function (e) {
    e.preventDefault();
    
    // sparar data-id till klickat element i en variabel
    var dataId = $(this).parents("form[name=frmcomment]").attr('data-id'),
        textareaValue = $(this).siblings('textarea[name="txtComment"]').html(),
        commentArea = $('div[data-id=' + dataId + ']');
    
    // AJAXanrop
    $.ajax({
        url: 'ajax/savecomment.php', // fil att hämta JSON ur
        type: 'POST',
        dataType: 'json',
        // Lyckat
        success: function (result) {
            // Appenda kommentar till kommentarsfältet
            commentArea.prepend('<p><b>' + result['date'] + ': </b><i>' + result['comment'] + '</i>');
        },
        // Misslyckat
        error: function (xhr, status, error) {
            window.alert(xhr.statusText + " : " + status + " : " + error);
        }
    });
});