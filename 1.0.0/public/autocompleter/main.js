/**
 * Crayola colors in JSON format
 * from: https://gist.github.com/jjdelc/1868136
 */
var colors =
[
    {
        "hex": "#EFDECD",
        "label": "Almond",
        "rgb": "(239, 222, 205)",
		"username": "1",
    },
    {
        "hex": "#CD9575",
        "label": "Antique Brass",
        "rgb": "(205, 149, 117)",
		"username": "2",
    },
   
];

$(function () {
  $('#nope').autocompleter({
        // marker for autocomplete matches
        highlightMatches: true,

        // object to local or url to remote search
        source: colors,

        // custom template
        template: '{{ label }} <span>({{ hex }})</span>',

        // show hint
        hint: true,

        // abort source if empty field
        empty: false,

        // max results
        limit: 5,

        callback: function (value, index, selected) {
            if (selected) {
                $('.icon').css('background-color', selected.hex);
            }
        }
    });
});
