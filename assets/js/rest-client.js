function groupJsonArray (arr, groupFields)
{
    var groupedArr = new Object();
    arr.forEach(function (row)
    {
        var group = groupedArr;
        for (var i = 0; i < groupFields.length; i++)
        {
            var fieldName = groupFields[i];
            var groupValue = row[fieldName];

            var initProperty = !group.hasOwnProperty(groupValue);
            if (i == (groupFields.length-1))
            {
                if (initProperty)
                    group[groupValue] = [];

                group[groupValue].push(row);
            }
            else
            {
                if (initProperty)
                    group[groupValue] = new Object();

                group = group[groupValue];
            }
        }
    });

    return groupedArr;
}

function showFormErrors (response, isPopup)
{
    var error = response.error;

    if (isPopup)
        showPopupMessage(error.message, false);
    else
        showMessage(error.message, false);

    if (typeof error.fields !== "undefined")
    {
        var fields = error.fields;
        for (var field in fields)
        {
            if (Array.isArray(fields[field]))
            {
                fields[field].forEach(function(row, idx)
                {
                    for (var rowField in row)
                    {
                        $(".error-" + field + "-" + rowField).eq(idx).html(row[rowField]);
                    }
                });
            }
            else
            {
                $(".error-" + field).html(fields[field]);
            }
        }
    }
    else if (typeof error.batchFields !== "undefined")
    {
        var batchFields = error.batchFields;
        batchFields.forEach(function (row, idx)
        {
            if (row !== null)
            {
                for (var rowField in row) {
                    $(".error-" + rowField).eq(idx).html(row[rowField]);
                }
            }
        });
    }
}

/*
 * Helpers
 */

var confirmOnLeave = false;
var transferMessage;

window.onbeforeunload = function (){
    if (confirmOnLeave)
    {
        return transferMessage;
    }
};

function setConfirmLeave (message)
{
    confirmOnLeave = true;
    transferMessage = message;
}

function removeConfirmLeave ()
{
    confirmOnLeave = false;
    transferMessage = "";
}

function showMessage(message, success)
{
    var alertDiv;
    if (success)
    {
        alertDiv = '<div class="alert alert-success pastel alert-dismissable">' +
            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>' +
            '<i class="fa fa-check pr10"></i>' + message +
            '</div>';
    }
    else
    {
        alertDiv = '<div class="alert alert-danger pastel alert-dismissable">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<i class="fa fa-remove pr10"></i>' + message +
            '</div>';
    }

    if ($('#content_message').length == 0)
        $('section#content').prepend('<div id="content_message"></div>');

    $("#content_message").html(alertDiv);
}

function showPopupMessage(message, success)
{
    var alertDiv;
    if (success)
    {
        alertDiv = '<div class="alert alert-success pastel alert-dismissable">' +
            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>' +
            '<i class="fa fa-check pr10"></i>' + message +
            '</div>';
    }
    else
    {
        alertDiv = '<div class="alert alert-danger pastel alert-dismissable">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<i class="fa fa-remove pr10"></i>' + message +
            '</div>';
    }

    $(".popup-message").html(alertDiv);
}

function showEditPopupMessage(message, success)
{
    var alertDiv;
    if (success)
    {
        alertDiv = '<div class="alert alert-success pastel alert-dismissable">' +
            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>' +
            '<i class="fa fa-check pr10"></i>' + message +
            '</div>';
    }
    else
    {
        alertDiv = '<div class="alert alert-danger pastel alert-dismissable">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<i class="fa fa-remove pr10"></i>' + message +
            '</div>';
    }

    $(".popup-edit-message").html(alertDiv);
}

