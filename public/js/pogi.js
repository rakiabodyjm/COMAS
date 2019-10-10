var editForm = function(id) {
    console.log('ready!' + id)
    $('#' + id).submit()
}

$(document).ready(function() {
    // $('#id').submit()
})

$(document).ready(function() {
    $('#search').on('keyup', function() {
        var value = $(this)
            .val()
            .toLowerCase()
        $('#table tr').filter(function() {
            $(this).toggle(
                $(this)
                    .text()
                    .toLowerCase()
                    .indexOf(value) > -1
            )
        })
    })

    document.getElementById('date').valueAsDate = new Date()
})
$(document).ready(function() {
    $('[id^=search]').on('keyup', function() {
        var id = $(this).attr('id')
        id = id.substr(6)
        var value = $(this)
            .val()
            .toLowerCase()
        $('#search' + id + ' tr').filter(function() {
            $(this).toggle(
                $(this)
                    .text()
                    .toLowerCase()
                    .indexOf(value) > -1
            )
        })
    })

    document.getElementById('date').valueAsDate = new Date()
})

we = []

var i = 0
$.getJSON('/pogi.json', function(data) {
    $.each(data, function(data, value) {
        we.push('' + value.lname + ', ' + value.fname + '')
    })

    var we_suggestion = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: we
    })
    $('.typeahead').typeahead({ minLength: 0 }, { source: we_suggestion })
})

$(document).ready(function($) {
    $('.clickable-row').click(function() {
        window.location = $(this).data('href')
    })
})
